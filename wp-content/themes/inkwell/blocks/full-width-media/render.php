<?php
$image = get_field('full_width_media_image');
$eyebrow = get_field('full_width_media_eyebrow');
$title = get_field('full_width_media_title');
$copy = get_field('full_width_media_copy');
$primaryCta = get_field('full_width_media_primary_cta');
$videoCta = get_field('full_width_media_video_cta');
$sectionId = inkwell_component_id($block ?? [], 'full-width-media');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="relative isolate min-h-[560px] overflow-hidden bg-[#142131] px-6 py-[clamp(72px,11vw,144px)] text-white">
    <div class="absolute inset-0 -z-20"><?php echo inkwell_component_image($image, 'full', 'h-full w-full object-cover'); ?></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#0b1727]/95 via-[#0b1727]/75 to-[#0b1727]/25" aria-hidden="true"></div>
    <div class="mx-auto flex min-h-[360px] max-w-7xl items-center">
        <div class="max-w-2xl">
            <?php if ($eyebrow) { ?><p class="mb-5 text-xs font-semibold uppercase tracking-[.14em] text-white/75"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(40px,5vw,66px)] font-semibold leading-[1.03] tracking-[-.04em]"><?php echo esc_html($title); ?></h2><?php } ?>
            <?php if ($copy) { ?><div class="mt-6 max-w-xl text-lg leading-8 text-white/80"><?php echo wp_kses_post($copy); ?></div><?php } ?>
            <?php if ($primaryCta || $videoCta) { ?>
                <div class="mt-9 flex flex-wrap items-center gap-5">
                    <?php echo inkwell_component_link($primaryCta, 'rounded bg-white px-6 py-3.5 text-sm font-semibold text-[#09152f] transition hover:bg-[#edf3fb]'); ?>
                    <?php if (!empty($videoCta['url']) && !empty($videoCta['title'])) { ?>
                        <a class="inline-flex items-center gap-3 text-sm font-semibold text-white" href="<?php echo esc_url($videoCta['url']); ?>"<?php if (!empty($videoCta['target'])) { ?> target="<?php echo esc_attr($videoCta['target']); ?>" rel="noopener noreferrer"<?php } ?>><span class="flex h-12 w-12 items-center justify-center rounded-full border border-white/80"><?php echo inkwell_component_icon('play', 'h-5 w-5'); ?></span><?php echo esc_html($videoCta['title']); ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
