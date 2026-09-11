<?php
$eyebrow = get_field('icon_grid_eyebrow');
$title = get_field('icon_grid_title');
$items = get_field('icon_grid_items') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'icon-grid');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto max-w-7xl">
        <header class="mx-auto mb-12 max-w-3xl text-center">
            <?php if ($eyebrow) { ?><p class="mb-3 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight tracking-[-.035em]"><?php echo esc_html($title); ?></h2><?php } ?>
        </header>
        <?php if ($items) { ?>
            <div class="grid gap-y-10 sm:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($items as $item) { ?>
                    <article class="px-6 text-center lg:border-r lg:border-[#e2e7ef] lg:last:border-r-0">
                        <div class="mx-auto mb-5 flex h-12 w-12 items-center justify-center text-[#0867f2]"><?php echo inkwell_component_icon($item['icon_grid_icon'] ?? 'strategy', 'h-11 w-11'); ?></div>
                        <?php if (!empty($item['icon_grid_item_title'])) { ?><h3 class="text-lg font-semibold"><?php echo esc_html($item['icon_grid_item_title']); ?></h3><?php } ?>
                        <?php if (!empty($item['icon_grid_item_copy'])) { ?><p class="mx-auto mt-3 max-w-[24ch] text-sm leading-6 text-[#647087]"><?php echo wp_kses_post($item['icon_grid_item_copy']); ?></p><?php } ?>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
