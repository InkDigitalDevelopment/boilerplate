<?php
$quote = get_field('quote_feature_quote');
$portrait = get_field('quote_feature_portrait');
$name = get_field('quote_feature_name');
$role = get_field('quote_feature_role');
$sectionId = inkwell_component_id($block ?? [], 'quote-feature');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="border-y border-[#e2e7ef] bg-white px-6 py-[clamp(64px,9vw,120px)] text-[#09152f]">
    <div class="mx-auto grid max-w-5xl grid-cols-[56px_1fr] gap-5 sm:grid-cols-[90px_1fr] sm:gap-9">
        <div class="text-[clamp(72px,10vw,132px)] font-bold leading-[.75] text-[#d4dbe6]" aria-hidden="true">“</div>
        <figure>
            <?php if ($quote) { ?><blockquote class="max-w-4xl text-[clamp(25px,3vw,40px)] leading-[1.24] tracking-[-.025em]"><?php echo wp_kses_post($quote); ?></blockquote><?php } ?>
            <?php if ($portrait || $name || $role) { ?>
                <figcaption class="mt-9 flex items-center gap-5">
                    <?php if ($portrait) { ?><div class="h-16 w-16 shrink-0 overflow-hidden rounded-full bg-[#e9edf3]"><?php echo inkwell_component_image($portrait, 'thumbnail', 'h-full w-full object-cover'); ?></div><?php } ?>
                    <div>
                        <?php if ($name) { ?><strong class="block text-base font-semibold"><?php echo esc_html($name); ?></strong><?php } ?>
                        <?php if ($role) { ?><span class="mt-1 block text-sm text-[#657188]"><?php echo esc_html($role); ?></span><?php } ?>
                    </div>
                </figcaption>
            <?php } ?>
        </figure>
    </div>
</section>
