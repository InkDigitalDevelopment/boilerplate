<?php
$eyebrow = get_field('hero_split_eyebrow');
$title = get_field('hero_split_title');
$copy = get_field('hero_split_copy');
$primaryCta = get_field('hero_split_primary_cta');
$secondaryCta = get_field('hero_split_secondary_cta');
$benefits = get_field('hero_split_benefits') ?: [];
$image = get_field('hero_split_image');
$sectionId = inkwell_component_id($block ?? [], 'hero-split');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="bg-white px-6 py-[clamp(56px,8vw,112px)] text-[#09152f]">
    <div class="mx-auto grid max-w-7xl items-center gap-10 lg:grid-cols-2 lg:gap-16">
        <div class="max-w-xl">
            <?php if ($eyebrow) { ?><p class="mb-5 text-xs font-semibold uppercase tracking-[.14em] text-[#68758d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h1 class="text-[clamp(40px,5vw,66px)] font-semibold leading-[1.02] tracking-[-.04em]"><?php echo esc_html($title); ?></h1><?php } ?>
            <?php if ($copy) { ?><div class="mt-6 max-w-lg text-lg leading-8 text-[#55627a]"><?php echo wp_kses_post($copy); ?></div><?php } ?>
            <?php if ($primaryCta || $secondaryCta) { ?>
                <div class="mt-8 flex flex-wrap gap-4">
                    <?php echo inkwell_component_link($primaryCta, 'rounded bg-[#0867f2] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#075bd4]'); ?>
                    <?php echo inkwell_component_link($secondaryCta, 'rounded border border-[#0867f2] px-6 py-3.5 text-sm font-semibold text-[#0867f2] transition hover:bg-[#eef5ff]'); ?>
                </div>
            <?php } ?>
            <?php if ($benefits) { ?>
                <ul class="mt-8 flex flex-wrap gap-x-7 gap-y-3 text-sm text-[#55627a]">
                    <?php foreach ($benefits as $benefit) { if (empty($benefit['hero_split_benefit_text'])) continue; ?>
                        <li class="flex items-center gap-2 text-[#40506a]"><span class="text-[#0867f2]"><?php echo inkwell_component_icon('check', 'h-4 w-4'); ?></span><?php echo esc_html($benefit['hero_split_benefit_text']); ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="min-h-[360px] overflow-hidden bg-[#e9edf3] lg:min-h-[540px]">
            <?php echo inkwell_component_image($image, 'full', 'h-full min-h-[360px] w-full object-cover lg:min-h-[540px]'); ?>
        </div>
    </div>
</section>
