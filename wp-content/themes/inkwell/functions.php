<?php
if (!defined('ABSPATH')) {
    exit;
}

foreach (['setup', 'assets', 'editor', 'component-helpers', 'register-blocks'] as $module) {
    require_once get_theme_file_path('/inc/' . $module . '.php');
}
