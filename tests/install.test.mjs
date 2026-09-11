import test from 'node:test';
import assert from 'node:assert/strict';
import fs from 'node:fs';
import os from 'node:os';
import path from 'node:path';
import { installSite } from '../scripts/lib/install.mjs';

function fixture(t) {
  const base = fs.mkdtempSync(path.join(os.tmpdir(), 'inkwell-test-'));
  t.after(() => {
    const resolved = fs.realpathSync(base);
    assert.equal(path.dirname(resolved).toLowerCase(), fs.realpathSync(os.tmpdir()).toLowerCase());
    assert(path.basename(resolved).startsWith('inkwell-test-'));
    fs.rmSync(resolved, { recursive: true });
  });
  const sourceRoot = path.join(base, 'starter');
  const target = path.join(base, 'Local site with spaces', 'app', 'public');
  const put = (root, file, text = '') => {
    fs.mkdirSync(path.dirname(path.join(root, file)), { recursive: true });
    fs.writeFileSync(path.join(root, file), text);
  };
  put(target, 'wp-load.php');
  put(target, 'wp-includes/version.php');
  put(target, 'wp-config.php', 'local connection settings');
  fs.mkdirSync(path.join(target, 'wp-content/themes'), { recursive: true });
  put(sourceRoot, 'package.json', '{"version":"1.0.0"}');
  const theme = 'wp-content/themes/inkwell/';
  for (const file of ['style.css', 'index.php', 'functions.php', 'package.json', 'package-lock.json']) put(sourceRoot, theme + file, 'source');
  put(sourceRoot, theme + 'dev.config.json', '{"localUrl":"http://wrong-source.local"}');
  put(sourceRoot, theme + 'node_modules/private.txt', 'excluded');
  put(sourceRoot, theme + 'dist/app.js', 'stale build');
  put(sourceRoot, theme + '.env', 'excluded');
  const calls = [];
  const tools = { wp: { command: 'wp' }, npm: { command: 'npm' } };
  const run = (tool, args, options) => {
    calls.push({ tool: tool.command, args, options });
    return args.includes('home') ? 'http://client-name.local\n' : '';
  };
  return { sourceRoot, target, put, calls, tools, run, log: () => {} };
}

test('fresh install excludes local data and only activates the theme', async t => {
  const options = fixture(t);
  const result = await installSite(options);
  assert.equal(result.status, 'installed');
  const theme = path.join(options.target, 'wp-content/themes/inkwell');
  assert.deepEqual(JSON.parse(fs.readFileSync(path.join(theme, 'dev.config.json'))), { localUrl: 'http://client-name.local' });
  for (const file of ['node_modules', 'dist', '.env']) assert(!fs.existsSync(path.join(theme, file)));
  assert.equal(fs.readFileSync(path.join(options.target, 'wp-config.php'), 'utf8'), 'local connection settings');
  assert.equal(options.calls.filter(call => call.tool === 'npm').length, 2);
  assert(options.calls.some(call => call.args.slice(-3).join(' ') === 'theme activate inkwell'));
  assert(!options.calls.some(call => call.args.includes('plugin') || call.args.includes('post') || call.args.includes('update')));
});

test('dry run writes no files and runs no installation commands', async t => {
  const options = fixture(t);
  assert.equal((await installSite({ ...options, dryRun: true })).status, 'dry-run');
  assert(!fs.existsSync(path.join(options.target, '.inkwell-install.json')));
  assert(!fs.existsSync(path.join(options.target, 'wp-content/themes/inkwell')));
  assert.equal(options.calls.length, 2);
});

test('existing projects are rejected before any command or write', async t => {
  const options = fixture(t);
  options.put(options.target, 'wp-content/themes/inkwell/style.css', 'client work');
  await assert.rejects(installSite(options), /Already exists/);
  assert.equal(options.calls.length, 0);
  assert.equal(fs.readFileSync(path.join(options.target, 'wp-content/themes/inkwell/style.css'), 'utf8'), 'client work');
});

test('completed rerun preserves subsequent changes', async t => {
  const options = fixture(t);
  await installSite(options);
  options.put(options.target, 'wp-content/themes/inkwell/style.css', 'client work');
  options.calls.length = 0;
  assert.equal((await installSite(options)).status, 'already-installed');
  assert.equal(options.calls.length, 0);
  assert.equal(fs.readFileSync(path.join(options.target, 'wp-content/themes/inkwell/style.css'), 'utf8'), 'client work');
});

test('a failed build resumes without replacing local settings or source edits', async t => {
  const options = fixture(t);
  const fail = (tool, args, config) => {
    if (args[0] === 'run') throw new Error('build failed');
    return options.run(tool, args, config);
  };
  await assert.rejects(installSite({ ...options, run: fail }), /build failed/);
  options.put(options.target, 'wp-content/themes/inkwell/style.css', 'fixed client styles');
  options.put(options.target, 'wp-content/themes/inkwell/dev.config.json', '{"localUrl":"http://changed.local"}');
  assert.equal((await installSite(options)).status, 'installed');
  assert.equal(fs.readFileSync(path.join(options.target, 'wp-content/themes/inkwell/style.css'), 'utf8'), 'fixed client styles');
  assert.equal(JSON.parse(fs.readFileSync(path.join(options.target, 'wp-content/themes/inkwell/dev.config.json'))).localUrl, 'http://changed.local');
});

test('database failures leave the destination unchanged', async t => {
  const options = fixture(t);
  await assert.rejects(installSite({ ...options, run: () => { throw new Error('database unavailable'); } }), /database unavailable/);
  assert(!fs.existsSync(path.join(options.target, '.inkwell-install.json')));
});

test('root package files are protected', async t => {
  const options = fixture(t);
  options.put(options.target, 'package.json', '{"name":"existing"}');
  await assert.rejects(installSite(options), /Already exists: package.json/);
});

test('theme directory junctions outside the site are rejected', async t => {
  const options = fixture(t);
  const themes = path.join(options.target, 'wp-content/themes');
  fs.rmdirSync(themes);
  fs.symlinkSync(options.sourceRoot, themes, 'junction');
  await assert.rejects(installSite(options), /inside this WordPress site/);
  fs.unlinkSync(themes);
});
