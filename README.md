# Boilerplate

Inkwell PHP layouts, reusable ACF component blocks and Tailwind CSS, for WordPress sites running in Local.

## Install into a new Local site

Start the site in Local, open its **Site Shell**, and run this from `app/public`:

```sh
npx create-inkwell-site
```

Node.js 20 or newer and npm must be installed. Local supplies PHP and WP-CLI through its Site Shell. Git or GitHub Desktop must also be installed.

The installer reads this site's WordPress URL, copies the theme, writes `dev.config.json`, installs build dependencies, builds assets and activates the theme. It adds a project `.gitignore` and root npm scripts. It does not install plugins, create pages or change the site's content, menus, homepage, permalinks or database credentials.

It also creates a brand-new Git repository on `main` and makes the `Initial project setup` commit. This repository has its own history and has no connection to the boilerplate repository. During setup, it asks for the optional GitHub repository URL; press Enter to keep the repository local.

To push during installation, first create a new empty GitHub repository without a README, licence or `.gitignore`, then enter its URL when prompted.

The installer adds the supplied URL as `origin` and pushes `main`. Leave it blank if you only want the new local Git repository; you can publish it later through GitHub Desktop. The non-interactive form remains available as `npx create-inkwell-site -- --repo https://github.com/InkDigitalDevelopment/client-project.git`.

Then run:

```sh
npm run dev
```

Use the BrowserSync address printed in the terminal for automatic refresh. Keep the site running in Local. Run `npm run build` when you need production assets.

ACF Pro is installed separately when you want to use the component blocks. The theme can run without it, and shows a dependency notice in WordPress admin.

The theme includes 12 design-library components matching the supplied reference: Hero Split, Logo Strip, Icon Grid, Process Steps, Team Grid, Featured Case Study, Latest Posts, Form + Content, Anchor Navigation, Content Columns, Full Width Media and Quote. Every component has its own importable `acf-fields.json` file alongside its `block.json` and PHP renderer.

## Files to change for each project

All theme paths are under `wp-content/themes/inkwell/`.

| File | Change |
| --- | --- |
| `dev.config.json` | Automatically created from the new site URL. Edit only if that URL changes. |
| `src/css/globals.css` | Client colours, font variables and font import. |
| `style.css` | Optional theme display name and author. |
| `tailwind.config.js` | Breakpoints or extensions only when required by the design. |

Keep block names, ACF keys, PHP identifiers and the theme folder unchanged for normal projects. More component details are in [the theme README](wp-content/themes/inkwell/README.md).

## Existing files and reruns

Setup refuses to overwrite an existing `inkwell` theme, root `package.json`, root `.gitignore` or Git repository on first installation. Use a fresh Local site. It also rejects theme paths that lead outside that site.

Setup records progress in `.inkwell-install.json`. If dependency installation or the build fails, fix the reported issue and run the same command again. The copied theme and local settings are retained. A completed installation is a no-op on rerun, so it does not replace later client work.

Append `--dry-run` to inspect the target and URL without installing anything. To use a downloaded repository directly, run `node /path/to/boilerplate/scripts/create-site.mjs /path/to/site/app/public` from the target site's Local Site Shell.

## Repository contents

Git contains the theme source, dependency lockfiles, installer and tests. WordPress core, all plugins, uploads, credentials, local configuration, `node_modules` and compiled assets are excluded. Build assets before deploying the theme. The installer is public in this repository; it is not published as a separate npm registry package.

`npm test` runs installer checks. `npm run build` builds the source theme after `npm ci --prefix wp-content/themes/inkwell`.
