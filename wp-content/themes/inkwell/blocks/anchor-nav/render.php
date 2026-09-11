<?php
$links = get_field('anchor_nav_links') ?: [];
$cta = get_field('anchor_nav_cta');
$sectionId = inkwell_component_id($block ?? [], 'anchor-nav');
?>
<nav id="<?php echo esc_attr($sectionId); ?>" class="anchor-nav border-y border-[#dfe5ee] bg-white px-6 text-[#42516a]" aria-label="Page sections">
    <div class="mx-auto flex max-w-7xl items-center gap-6 overflow-x-auto">
        <?php if ($links) { ?>
            <ul class="flex min-w-max flex-1 items-center gap-[clamp(24px,5vw,64px)]">
                <?php foreach ($links as $index => $item) {
                    $label = $item['anchor_nav_label'] ?? '';
                    $anchor = sanitize_title($item['anchor_nav_anchor'] ?? '');
                    if (!$label || !$anchor) continue;
                    ?>
                    <li><a class="anchor-nav-link block border-b-2 px-1 py-6 text-sm font-medium transition hover:text-[#0867f2] <?php echo $index === 0 ? 'is-active border-[#0867f2] text-[#0867f2]' : 'border-transparent'; ?>" href="#<?php echo esc_attr($anchor); ?>" data-anchor-target="<?php echo esc_attr($anchor); ?>"><?php echo esc_html($label); ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if ($cta) { ?><div class="ml-auto shrink-0 py-3"><?php echo inkwell_component_link($cta, 'inline-flex rounded bg-[#0867f2] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#075bd4]'); ?></div><?php } ?>
    </div>
</nav>
