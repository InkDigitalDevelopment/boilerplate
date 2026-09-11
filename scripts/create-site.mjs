#!/usr/bin/env node
import { createInterface } from 'node:readline/promises';
import { fileURLToPath } from 'node:url';
import { installSite } from './lib/install.mjs';

async function askForGitRemote() {
  if (!process.stdin.isTTY || !process.stdout.isTTY) return;
  const prompt = createInterface({ input: process.stdin, output: process.stdout });
  try {
    const answer = await prompt.question('Empty GitHub repository URL (press Enter to keep Git local): ');
    return answer.trim() || undefined;
  } finally {
    prompt.close();
  }
}

const args = process.argv.slice(2);
if (args.includes('--help') || args.includes('-h')) {
  console.log('Usage: create-inkwell-site [path/to/app/public] [--repo <empty-github-url>] [--dry-run]\nRun from the new site\'s Local Site Shell. No plugins are installed.');
} else {
  let dryRun = false;
  let gitRemote;
  const targets = [];
  const unknown = [];

  for (let index = 0; index < args.length; index++) {
    const arg = args[index];
    if (arg === '--dry-run') {
      dryRun = true;
    } else if (arg === '--repo') {
      gitRemote = args[++index];
      if (!gitRemote) unknown.push('--repo requires a URL');
    } else if (arg.startsWith('--repo=')) {
      gitRemote = arg.slice('--repo='.length);
    } else if (arg.startsWith('-')) {
      unknown.push(arg);
    } else {
      targets.push(arg);
    }
  }

  if (unknown.length || targets.length > 1) {
    console.error('Use one site path, optionally followed by --repo <empty-github-url> and --dry-run. Run with --help for usage.');
    process.exitCode = 1;
  } else {
    try {
      if (!gitRemote && !dryRun) gitRemote = await askForGitRemote();
      await installSite({
        target: targets[0] || process.cwd(),
        sourceRoot: fileURLToPath(new URL('../', import.meta.url)),
        dryRun,
        gitRemote,
      });
    } catch (error) {
      console.error(`Setup stopped: ${error.message}`);
      process.exitCode = 1;
    }
  }
}
