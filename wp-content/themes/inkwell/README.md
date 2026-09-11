# Inkwell theme

PHP page layouts, ACF component blocks and Tailwind CSS 3. Start the WordPress site in Local before previewing it.

## New installation checklist

The project-creation command is not built yet. Until then, use this setup for each fresh Local site:

1. Create and start the site in Local. Local supplies WordPress, the database and its site URL.
2. Copy this theme into `wp-content/themes/inkwell/`. Install and activate ACF Pro, then activate the theme. Install other plugins only as required by the project.
3. Copy `dev.config.example.json` to `dev.config.json` in the theme folder. Set `localUrl` to the URL shown by Local. This is the only development URL to configure; leave Local's database configuration alone.
4. From the theme directory, run `npm ci` once, then `npm run dev`. Use the proxy URL printed by BrowserSync while developing. On later sessions, start the site in Local and run `npm run dev`.
5. Set the WordPress site title and tagline under Settings > General, and the logo under Appearance > Customize > Site Identity if needed. These supply the theme's visible site identity.
6. Create the project's pages, choose the homepage under Settings > Reading, set the permalink structure under Settings > Permalinks, and assign navigation under Appearance > Menus. Put the selected form block or shortcode in the Contact page content if needed.
7. Change colours and fonts in `src/css/globals.css` for the client design. Adjust Tailwind extensions in `tailwind.config.js` only when the design calls for it.

Optional labels: change `Theme Name` in `style.css` if you want the client name in the theme picker; change the author only if appropriate. The npm package name is internal and can remain `inkwell-theme`.

Keep the theme folder, `inkwell/...` block names, PHP function names, text domain and existing ACF group/field keys unchanged for ordinary projects. They are reusable code identifiers, not client-facing branding. Do not run a global search-and-replace over them.

Run `npm run build` for production assets. Hosting URLs, production credentials and plugin-specific settings are separate from `dev.config.json` and belong to the later deployment/setup workflow.

## Development

Run commands from this theme directory after installing dependencies with `npm ci`:

```sh
npm run build
npm run dev
```

`build` compiles production assets into `dist/`. `dev` watches source files and starts BrowserSync using the Local URL saved in `dev.config.json`; it does not start WordPress.

This site is already configured. For a fresh checkout, copy `dev.config.example.json` to `dev.config.json` once and enter the URL shown by Local:

```json
{
  "localUrl": "http://your-project.local"
}
```

Then use `npm run dev` each time. `dev.config.json` is excluded from Git. Restart the watcher after changing it. The `LOCAL_URL` environment variable or `--env localUrl=...` can override the saved URL when needed. BrowserSync prints its proxy address; use that address for automatic refresh. It does not open a browser automatically. Production builds never start BrowserSync or read the local config.

## Structure

- `src/css/globals.css`: the single Tailwind entry point, project defaults and shared custom styles.
- `src/js/`: the JavaScript entry point and shared modules.
- `dist/`: compiled output; rebuild after changing source files.
- `blocks/<name>/`: block metadata, ACF field definitions and PHP rendering.
- `inc/setup.php`: theme support and menu locations.
- `inc/assets.php`: front-end assets and file-based cache versions.
- `inc/editor.php`: the same compiled stylesheet for component previews.
- `inc/register-blocks.php`: automatic component and field registration.
- `template-parts/`: shared PHP fragments.

Existing PHP page layouts stay at the theme root so existing assignments and URL-based template selection continue to work. New explicitly selectable layouts may go in `page-templates/`; normal hierarchy files such as `page.php` and `single.php` belong at the root. No folder is required until a layout needs it.

## Project defaults

1. Set the site title in WordPress Settings > General. The header and footer use it instead of a fixed client name.
2. Set a logo in Appearance > Customize > Site Identity if needed. The footer also retains the old `pixelpress_options.logo` fallback for existing sites; new projects should use Site Identity.
3. Set `--brand-primary`, `--brand-accent`, `--brand-text`, `--brand-surface`, the remaining colour variables and font variables at the top of `src/css/globals.css`. Update its font import if changing font families. Existing colours and fonts are retained as starter defaults, with aliases for older component classes.
4. Configure Tailwind extensions and breakpoints in `tailwind.config.js`. Its content paths include PHP components and `.mjs` source modules and exclude dependencies and compiled output.
5. Optionally edit the theme display name and author in `style.css`. The package name in `package.json` can stay `inkwell-theme`; if you choose to change it, regenerate the lockfile with npm.

Keep the `inkwell` folder, block names and ACF field keys stable on existing sites: saved content refers to these identifiers. A display-name change does not require renaming those identifiers.

## Components

Every component has `block.json`, `acf-fields.json` and `render.php`. The field loader supports a single field-group object or an array of groups. Keep field keys unchanged when editing an existing component. If editing fields through ACF's admin interface, export the updated definitions back into the component's `acf-fields.json`; database changes alone are not portable.

Keep Tailwind utility classes directly in PHP. Use complete class strings for conditional variants so Tailwind can discover them. Components share the typography, buttons and design variables in `globals.css`.

For optional component behaviour, place the JavaScript beside the block and import it from `src/js/app.js`. A file's presence alone does not load it. Initialisers must tolerate absent markup and multiple block instances. If it must run in ACF editor previews, wire up the ACF preview lifecycle as well; the front-end app bundle is not loaded into the editor. The existing accordion uses native `details`/`summary` and needs no script.

ACF Pro is required for the component blocks. All seven blocks include their field definitions, including the hero exported with its existing keys. Client content and media remain in WordPress.

The Contact Page layout now renders page content: insert the chosen form block or shortcode there instead of relying on a fixed plugin and form ID. The older optional page hero fragment remains for sites with its page fields; it safely renders nothing when those fields are absent. The unused flexible-content dispatcher referencing a missing fragment has been removed.
