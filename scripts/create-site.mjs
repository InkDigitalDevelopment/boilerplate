#!/usr/bin/env node
import { fileURLToPath } from 'node:url';
import { installSite } from './lib/install.mjs';

const args = process.argv.slice(2);
if (args.includes('--help') || args.includes('-h')) {
  console.log('Usage: create-inkwell-site [path/to/app/public] [--dry-run]\nRun from the new site\'s Local Site Shell. No plugins are installed.');
} else {
  const unknown = args.filter(arg => arg.startsWith('-') && arg !== '--dry-run');
  const targets = args.filter(arg => !arg.startsWith('-'));
  if (unknown.length || targets.length > 1) {
    console.error('Use one site path and optionally --dry-run. Run with --help for usage.');
    process.exitCode = 1;
  } else {
    try {
      await installSite({
        target: targets[0] || process.cwd(),
        sourceRoot: fileURLToPath(new URL('../', import.meta.url)),
        dryRun: args.includes('--dry-run'),
      });
    } catch (error) {
      console.error(`Setup stopped: ${error.message}`);
      process.exitCode = 1;
    }
  }
}
