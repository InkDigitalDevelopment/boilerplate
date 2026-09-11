<?php
if (!defined('ABSPATH')) {
    exit;
}
// Register Block Directory
function inkwellRegisterAcfBlocks() {
    if (!function_exists('acf_register_block_type')) {
        return;
    }
    $blockDirectories = glob(get_theme_file_path('/blocks/*'), GLOB_ONLYDIR);

    if (!$blockDirectories) {
        return;
    }

    foreach ($blockDirectories as $blockDirectory) {
        if (file_exists($blockDirectory . '/block.json')) {
            register_block_type($blockDirectory);
        }
    }
}
add_action('init', 'inkwellRegisterAcfBlocks');

// Register block field groups stored alongside each block.
function inkwellRegisterAcfBlockFields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $fieldGroupFiles = glob(get_theme_file_path('/blocks/*/acf-fields.json'));

    if (!$fieldGroupFiles) {
        return;
    }

    foreach ($fieldGroupFiles as $fieldGroupFile) {
        $fieldGroupJson = file_get_contents($fieldGroupFile);

        if ($fieldGroupJson === false) {
            continue;
        }

        $fieldGroups = json_decode($fieldGroupJson, true);

        if (!is_array($fieldGroups)) {
            continue;
        }

        // Support both a single ACF field group and ACF's import/export array format.
        if (isset($fieldGroups['key'])) {
            $fieldGroups = [$fieldGroups];
        }

        foreach ($fieldGroups as $fieldGroup) {
            if (is_array($fieldGroup) && isset($fieldGroup['key'], $fieldGroup['fields'])) {
                acf_add_local_field_group($fieldGroup);
            }
        }
    }
}
add_action('acf/init', 'inkwellRegisterAcfBlockFields');

function inkwellRegisterBlockCategories($categories, $editorContext) {
    return array_merge(
        [
            [
                'slug' => 'inkwell-components',
                'title' => __('Inkwell Components', 'inkwell'),
            ],
        ],
        $categories
    );
}
add_filter('block_categories_all', 'inkwellRegisterBlockCategories', 10, 2);
