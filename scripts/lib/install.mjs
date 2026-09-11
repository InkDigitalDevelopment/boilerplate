import fs from 'node:fs';
import path from 'node:path';
import { execFileSync } from 'node:child_process';

const themeRelative = 'wp-content/themes/inkwell';
const stateName = '.inkwell-install.json';
const omitted = new Set(['node_modules', 'dist', 'dev.config.json', '.git', '.env', '.DS_Store', 'Thumbs.db']);

function inside(root, target) {
  const relative = path.relative(root, target);
  return relative !== '..' && !relative.startsWith(`..${path.sep}`) && !path.isAbsolute(relative);
}

function checkedDirectory(root, directory) {
  if (!fs.existsSync(directory) || !fs.statSync(directory).isDirectory() || !inside(root, fs.realpathSync(directory))) {
    throw new Error(`Expected a directory inside this WordPress site: ${directory}`);
  }
}

export function themeFiles(directory) {
  const files = [];
  function visit(folder, prefix = '') {
    for (const item of fs.readdirSync(folder, { withFileTypes: true })) {
      if (omitted.has(item.name) || item.name.startsWith('.env.') || /\.(log|tgz)$/.test(item.name)) continue;
      const relative = path.join(prefix, item.name);
      if (item.isSymbolicLink()) throw new Error(`Theme symlinks are not supported: ${relative}`);
      if (item.isDirectory()) visit(path.join(folder, item.name), relative);
      else if (item.isFile()) files.push(relative);
    }
  }
  visit(directory);
  return files.sort();
}

function onPath(name) {
  const extensions = process.platform === 'win32' ? ['.exe', '.cmd', '.bat', ''] : [''];
  for (const folder of (process.env.PATH || '').split(path.delimiter)) {
    for (const extension of extensions) {
      const candidate = path.join(folder.replace(/^"|"$/g, ''), name + extension);
      if (fs.existsSync(candidate) && fs.statSync(candidate).isFile()) return candidate;
    }
  }
}

export function localTools() {
  const php = process.env.WP_CLI_PHP || onPath('php');
  const wp = onPath('wp');
  const pharCandidates = [
    process.env.WP_CLI_PHAR,
    wp && path.resolve(path.dirname(wp), '../wp-cli.phar'),
    process.env.LOCALAPPDATA && path.join(process.env.LOCALAPPDATA, 'Programs/Local/resources/extraResources/bin/wp-cli/wp-cli.phar'),
  ].filter(Boolean);
  const phar = pharCandidates.find(candidate => fs.existsSync(candidate));
  let wpCommand;
  if (php && phar) wpCommand = { command: php, prefix: [phar] };
  else if (wp && process.platform !== 'win32') wpCommand = { command: wp, prefix: [] };
  else throw new Error('Open this site\'s Site Shell in Local and run the command there. PHP and WP-CLI must be available.');

  const npm = onPath('npm');
  const npmCandidates = [
    process.env.npm_execpath && path.join(path.dirname(process.env.npm_execpath), 'npm-cli.js'),
    path.join(path.dirname(process.execPath), 'node_modules/npm/bin/npm-cli.js'),
    npm && path.join(path.dirname(npm), 'node_modules/npm/bin/npm-cli.js'),
    npm && process.platform !== 'win32' && fs.realpathSync(npm),
  ].filter(Boolean);
  const npmCli = npmCandidates.find(candidate => fs.existsSync(candidate) && candidate.endsWith('.js'));
  if (!npmCli) throw new Error('npm was not found. Install Node.js with npm, then reopen the Local Site Shell.');
  return { wp: wpCommand, npm: { command: process.execPath, prefix: [npmCli] } };
}

function execute(tool, args, { cwd, quiet = false }) {
  try {
    return execFileSync(tool.command, [...tool.prefix, ...args], {
      cwd, encoding: 'utf8', windowsHide: true, stdio: quiet ? 'pipe' : 'inherit',
    }) || '';
  } catch (error) {
    const detail = quiet ? String(error.stderr || '').trim() : '';
    throw new Error(`${path.basename(tool.command)} ${args[0]} failed.${detail ? ` ${detail}` : ''}`);
  }
}

const projectIgnore = `/*
!/.gitignore
!/package.json
!/package-lock.json
!/README.md
!/wp-content/
/.inkwell-install.json
/wp-content/*
!/wp-content/themes/
/wp-content/themes/*
!/wp-content/themes/inkwell/
**/node_modules/
**/dist/
**/dev.config.json
**/.env
**/.env.*
**/*.log
`;

export async function installSite({ target, sourceRoot, dryRun = false, run = execute, tools, log = console.log }) {
  const root = fs.realpathSync(path.resolve(target));
  for (const file of ['wp-load.php', 'wp-includes/version.php']) {
    if (!fs.existsSync(path.join(root, file))) throw new Error('Choose the app/public directory of an existing WordPress site in Local.');
  }
  const themesRoot = path.join(root, 'wp-content/themes');
  checkedDirectory(root, themesRoot);
  const themeTarget = path.join(root, themeRelative);
  const statePath = path.join(root, stateName);
  let state;
  if (fs.existsSync(statePath)) {
    if (fs.lstatSync(statePath).isSymbolicLink()) throw new Error('The setup state must be a regular file.');
    state = JSON.parse(fs.readFileSync(statePath, 'utf8'));
    if (state.kind !== 'inkwell-install' || state.schema !== 1 || state.root !== root) {
      throw new Error('Unrecognised setup state. Existing files were left untouched.');
    }
  }
  if (!state) {
    for (const relative of [themeRelative, 'package.json', '.gitignore']) {
      if (fs.existsSync(path.join(root, relative))) throw new Error(`Already exists: ${relative}. Use a fresh Local site; setup will not overwrite it.`);
    }
  }
  if (fs.existsSync(themeTarget)) checkedDirectory(root, themeTarget);
  if (state?.status === 'complete') {
    for (const relative of [themeRelative + '/style.css', 'package.json', '.gitignore']) {
      if (!fs.existsSync(path.join(root, relative))) throw new Error(`A completed install is missing ${relative}. Restore it manually; setup will not overwrite project work.`);
    }
    log('This site is already set up. Run npm run dev from app/public.');
    return { status: 'already-installed', root };
  }

  tools ||= localTools();
  const wp = (args, quiet = true) => run(tools.wp, [`--path=${root}`, '--skip-plugins', '--skip-themes', ...args], { cwd: root, quiet });
  wp(['core', 'is-installed']);
  const siteUrl = wp(['option', 'get', 'home']).trim();
  const url = new URL(siteUrl);
  if (!['http:', 'https:'].includes(url.protocol) || url.username || url.password) throw new Error('WordPress must have a valid HTTP(S) site URL without credentials.');
  const sourceTheme = path.join(sourceRoot, themeRelative);
  const files = themeFiles(sourceTheme);
  for (const required of ['style.css', 'index.php', 'functions.php', 'package.json', 'package-lock.json']) {
    if (!files.includes(required)) throw new Error(`Starter is missing ${required}.`);
  }
  const version = JSON.parse(fs.readFileSync(path.join(sourceRoot, 'package.json'), 'utf8')).version;
  log(`Site: ${root}\nURL: ${siteUrl}\nTheme: inkwell\nPlugins: none`);
  if (dryRun) {
    log('Dry run complete. No files or WordPress settings changed.');
    return { status: 'dry-run', root, siteUrl };
  }
  const saveState = () => fs.writeFileSync(statePath, JSON.stringify(state, null, 2) + '\n');
  if (!state) {
    state = { kind: 'inkwell-install', schema: 1, root, version, status: 'installing', copied: false };
    fs.writeFileSync(statePath, JSON.stringify(state, null, 2) + '\n', { flag: 'wx' });
  }
  if (!state.copied) {
    if (fs.existsSync(themeTarget)) throw new Error('A theme appeared during setup. It was left untouched.');
    const staging = fs.mkdtempSync(path.join(themesRoot, '.inkwell-stage-'));
    try {
      for (const relative of files) {
        const destination = path.join(staging, relative);
        fs.mkdirSync(path.dirname(destination), { recursive: true });
        fs.copyFileSync(path.join(sourceTheme, relative), destination, fs.constants.COPYFILE_EXCL);
      }
      fs.renameSync(staging, themeTarget);
    } finally {
      if (fs.existsSync(staging) && inside(fs.realpathSync(themesRoot), fs.realpathSync(staging))) {
        fs.rmSync(staging, { recursive: true });
      }
    }
    state.copied = true;
    saveState();
  }
  const writeNew = (relative, value) => {
    const file = path.join(root, relative);
    if (fs.existsSync(file)) {
      if (fs.lstatSync(file).isSymbolicLink()) throw new Error(`Refusing a symlink: ${relative}`);
      return;
    }
    fs.writeFileSync(file, value, { flag: 'wx' });
  };
  writeNew(themeRelative + '/dev.config.json', JSON.stringify({ localUrl: siteUrl }, null, 2) + '\n');
  writeNew('.gitignore', projectIgnore);
  writeNew('package.json', JSON.stringify({
    name: 'inkwell-site', private: true,
    scripts: { dev: 'npm --prefix wp-content/themes/inkwell run dev', build: 'npm --prefix wp-content/themes/inkwell run build' },
  }, null, 2) + '\n');
  log('Installing theme build dependencies…');
  run(tools.npm, ['ci', '--no-audit', '--no-fund'], { cwd: themeTarget });
  log('Building theme assets…');
  run(tools.npm, ['run', 'build'], { cwd: themeTarget });
  wp(['theme', 'activate', 'inkwell'], false);
  state.status = 'complete';
  saveState();
  log('Ready. Run npm run dev from app/public.\nACF component editing needs ACF Pro installed separately.');
  return { status: 'installed', root, siteUrl };
}
