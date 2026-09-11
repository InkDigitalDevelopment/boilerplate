<?php
$eyebrow = get_field('featured_case_study_eyebrow');
$title = get_field('featured_case_study_title');
$copy = get_field('featured_case_study_copy');
$cta = get_field('featured_case_study_cta');
$image = get_field('featured_case_study_image');
$stats = get_field('featured_case_study_stats') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'featured-case-study');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="border-y border-[#e2e7ef] bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto grid max-w-7xl items-stretch gap-10 lg:grid-cols-[.9fr_1.1fr] lg:gap-14">
        <div class="flex flex-col justify-center">
            <?php if ($eyebrow) { ?><p class="mb-4 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(34px,4vw,52px)] font-semibold leading-[1.08] tracking-[-.04em]"><?php echo esc_html($title); ?></h2><?php } ?>
            <?php if ($copy) { ?><div class="mt-5 max-w-lg text-base leading-7 text-[#617087]"><?php echo wp_kses_post($copy); ?></div><?php } ?>
            <?php if ($cta) { ?><div class="mt-8"><?php echo inkwell_component_link($cta, 'inline-flex rounded bg-[#0867f2] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#075bd4]'); ?></div><?php } ?>
        </div>
        <div class="grid min-h-[440px] overflow-hidden bg-[#e9edf3] sm:grid-cols-[minmax(0,1fr)_180px]">
            <div><?php echo inkwell_component_image($image, 'full', 'h-full min-h-[320px] w-full object-cover'); ?></div>
            <?php if ($stats) { ?>
                <div class="flex flex-col justify-center gap-8 bg-[#111d2d] p-7 text-white">
                    <?php foreach ($stats as $stat) { ?>
                        <div>
                            <?php if (!empty($stat['featured_case_study_stat_value'])) { ?><strong class="block text-4xl font-semibold"><?php echo esc_html($stat['featured_case_study_stat_value']); ?></strong><?php } ?>
                            <?php if (!empty($stat['featured_case_study_stat_label'])) { ?><span class="mt-1 block text-xs leading-5 text-white/75"><?php echo esc_html($stat['featured_case_study_stat_label']); ?></span><?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
