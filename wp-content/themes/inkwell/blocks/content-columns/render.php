<?php
$eyebrow = get_field('content_columns_eyebrow');
$title = get_field('content_columns_title');
$copy = get_field('content_columns_copy');
$items = get_field('content_columns_items') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'content-columns');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-2 lg:gap-20">
        <div class="max-w-xl">
            <?php if ($eyebrow) { ?><p class="mb-4 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(34px,4vw,52px)] font-semibold leading-[1.08] tracking-[-.04em]"><?php echo esc_html($title); ?></h2><?php } ?>
            <?php if ($copy) { ?><div class="mt-5 text-base leading-7 text-[#617087]"><?php echo wp_kses_post($copy); ?></div><?php } ?>
        </div>
        <?php if ($items) { ?>
            <div class="space-y-8 border-l border-[#dfe5ee] pl-[clamp(24px,5vw,64px)]">
                <?php foreach ($items as $item) { ?>
                    <article class="grid grid-cols-[40px_1fr] gap-5">
                        <div class="text-[#0867f2]"><?php echo inkwell_component_icon($item['content_columns_icon'] ?? 'lightbulb', 'h-8 w-8'); ?></div>
                        <div>
                            <?php if (!empty($item['content_columns_item_title'])) { ?><h3 class="text-base font-semibold"><?php echo esc_html($item['content_columns_item_title']); ?></h3><?php } ?>
                            <?php if (!empty($item['content_columns_item_copy'])) { ?><p class="mt-1 text-sm leading-6 text-[#647087]"><?php echo wp_kses_post($item['content_columns_item_copy']); ?></p><?php } ?>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
