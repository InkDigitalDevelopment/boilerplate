<?php
$eyebrow = get_field('process_steps_eyebrow');
$title = get_field('process_steps_title');
$steps = get_field('process_steps_items') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'process-steps');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="border-y border-[#e2e7ef] bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto max-w-7xl">
        <header class="mx-auto mb-12 max-w-3xl text-center">
            <?php if ($eyebrow) { ?><p class="mb-3 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight tracking-[-.035em]"><?php echo esc_html($title); ?></h2><?php } ?>
        </header>
        <?php if ($steps) { ?>
            <div class="relative grid gap-9 md:grid-cols-4 md:gap-5">
                <div class="absolute left-[10%] right-[10%] top-6 hidden h-px bg-[#cad6e8] md:block" aria-hidden="true"></div>
                <?php foreach ($steps as $index => $step) { ?>
                    <article class="relative text-center">
                        <span class="relative z-10 mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#287bf0] text-base font-semibold text-white ring-8 ring-white"><?php echo esc_html($index + 1); ?></span>
                        <?php if (!empty($step['process_steps_item_title'])) { ?><h3 class="mt-6 text-lg font-semibold"><?php echo esc_html($step['process_steps_item_title']); ?></h3><?php } ?>
                        <?php if (!empty($step['process_steps_item_copy'])) { ?><p class="mx-auto mt-3 max-w-[24ch] text-sm leading-6 text-[#647087]"><?php echo wp_kses_post($step['process_steps_item_copy']); ?></p><?php } ?>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
