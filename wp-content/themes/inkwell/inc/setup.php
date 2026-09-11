<?php
if (!defined('ABSPATH')) {
    exit;
}

function inkwell_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    // Keep existing location keys so saved menu assignments continue to work.
    register_nav_menus([
        'header' => __('Custom Primary Menu', 'inkwell'),
        'header-menu' => __('Header Menu', 'inkwell'),
        'footer-menu' => __('Footer Menu', 'inkwell'),
    ]);
}
add_action('after_setup_theme', 'inkwell_setup');

function inkwell_active_menu_class($classes) {
    if (in_array('current-menu-item', $classes, true)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'inkwell_active_menu_class');

function inkwell_acf_notice() {
    if (current_user_can('activate_plugins') && !function_exists('acf_register_block_type')) {
        echo '<div class="notice notice-info"><p>' . esc_html__('Install and activate ACF Pro to use the Inkwell component blocks.', 'inkwell') . '</p></div>';
    }
}
add_action('admin_notices', 'inkwell_acf_notice');
