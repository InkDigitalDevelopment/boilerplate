<?php
if (!defined('ABSPATH')) {
    exit;
}

function inkwell_component_id($block, $slug) {
    if (!empty($block['anchor'])) {
        return sanitize_title($block['anchor']);
    }

    return sanitize_html_class($slug . '-' . ($block['id'] ?? wp_unique_id()));
}

function inkwell_component_link($link, $classes = '') {
    if (empty($link['url']) || empty($link['title'])) {
        return '';
    }

    $target = !empty($link['target']) ? $link['target'] : '_self';
    $rel = $target === '_blank' ? ' rel="noopener noreferrer"' : '';

    return sprintf(
        '<a class="%s" href="%s" target="%s"%s>%s</a>',
        esc_attr($classes),
        esc_url($link['url']),
        esc_attr($target),
        $rel,
        esc_html($link['title'])
    );
}

function inkwell_component_image($image, $size = 'large', $classes = '') {
    if (empty($image)) {
        return '';
    }

    $id = is_array($image) ? ($image['ID'] ?? $image['id'] ?? 0) : (int) $image;
    if ($id) {
        return wp_get_attachment_image($id, $size, false, ['class' => $classes]);
    }

    if (is_array($image) && !empty($image['url'])) {
        return sprintf(
            '<img src="%s" alt="%s" class="%s">',
            esc_url($image['url']),
            esc_attr($image['alt'] ?? ''),
            esc_attr($classes)
        );
    }

    return '';
}

function inkwell_component_icon($name, $classes = 'h-9 w-9') {
    $icons = [
        'strategy' => '<path d="M5 20V10m7 10V4m7 16v-7"/>',
        'layers' => '<path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5M3 16l9 5 9-5"/>',
        'code' => '<path d="m8 9-4 3 4 3m8-6 4 3-4 3m-2-9-4 12"/>',
        'support' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-2.8 2.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6v.2h-4V21a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1L4.2 17l.1-.1a1.7 1.7 0 0 0 .3-1.9A1.7 1.7 0 0 0 3 14H2.8v-4H3a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9L4.2 7 7 4.2l.1.1A1.7 1.7 0 0 0 9 4.6 1.7 1.7 0 0 0 10 3V2.8h4V3a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1L19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.2v4H21a1.7 1.7 0 0 0-1.6 1Z"/>',
        'lightbulb' => '<path d="M9 18h6m-5 3h4m3-12a5 5 0 1 0-8.7 3.4c.9.9 1.7 1.8 1.7 3.1h4c0-1.3.8-2.2 1.7-3.1A5 5 0 0 0 17 9Z"/>',
        'pencil' => '<path d="m4 20 4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Zm10-12 3 3"/>',
        'check' => '<path d="m5 12 4 4L19 6"/>',
        'phone' => '<path d="M6.6 3h3l1.5 4-2 1.7a15 15 0 0 0 6.2 6.2l1.7-2 4 1.5v3a3 3 0 0 1-3 3A15 15 0 0 1 3.6 6a3 3 0 0 1 3-3Z"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'pin' => '<path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2"/>',
        'arrow' => '<path d="M5 12h14m-5-5 5 5-5 5"/>',
        'play' => '<path d="m9 7 8 5-8 5V7Z"/>',
    ];

    $body = $icons[$name] ?? $icons['check'];

    return sprintf(
        '<svg class="%s" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
        esc_attr($classes),
        $body
    );
}
