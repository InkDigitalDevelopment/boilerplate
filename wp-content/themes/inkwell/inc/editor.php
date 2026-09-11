<?php
if (!defined('ABSPATH')) {
    exit;
}

function inkwell_editor_styles() {
    add_theme_support('editor-styles');
    add_editor_style('dist/style.css');
}
add_action('after_setup_theme', 'inkwell_editor_styles');
