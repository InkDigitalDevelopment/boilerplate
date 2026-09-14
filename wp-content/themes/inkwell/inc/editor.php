<?php
if (!defined('ABSPATH')) {
    exit;
}

function inkwell_editor_styles() {
    add_theme_support('editor-styles');
    add_editor_style('dist/style.css');
}
add_action('after_setup_theme', 'inkwell_editor_styles');

function inkwell_editor_component_scripts() {
    if (!function_exists('acf')) {
        return;
    }

    wp_enqueue_script(
        'inkwell-editor-components',
        get_theme_file_uri('/dist/app.js'),
        ['acf-input'],
        inkwell_asset_version('/dist/app.js'),
        true
    );
}
add_action('enqueue_block_editor_assets', 'inkwell_editor_component_scripts');
