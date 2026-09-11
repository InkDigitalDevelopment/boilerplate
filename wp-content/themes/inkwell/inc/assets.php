<?php
if (!defined('ABSPATH')) {
    exit;
}

function inkwell_asset_version($relativePath) {
    $path = get_theme_file_path($relativePath);
    return is_file($path) ? (string) filemtime($path) : wp_get_theme()->get('Version');
}

function inkwell_enqueue_assets() {
    wp_enqueue_style('inkwell-theme', get_stylesheet_uri(), [], inkwell_asset_version('/style.css'));
    wp_enqueue_style('inkwell-globals', get_theme_file_uri('/dist/style.css'), ['inkwell-theme'], inkwell_asset_version('/dist/style.css'));
    wp_enqueue_script('inkwell-app', get_theme_file_uri('/dist/app.js'), [], inkwell_asset_version('/dist/app.js'), true);
}
add_action('wp_enqueue_scripts', 'inkwell_enqueue_assets');
