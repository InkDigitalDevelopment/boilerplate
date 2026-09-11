<?php
$eyebrow = get_field('form_content_eyebrow');
$title = get_field('form_content_title');
$copy = get_field('form_content_copy');
$phone = get_field('form_content_phone');
$email = get_field('form_content_email');
$address = get_field('form_content_address');
$shortcode = get_field('form_content_shortcode');
$sectionId = inkwell_component_id($block ?? [], 'form-content');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="border-y border-[#e2e7ef] bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto grid max-w-7xl gap-12 lg:grid-cols-[.8fr_1.2fr] lg:gap-20">
        <div>
            <?php if ($eyebrow) { ?><p class="mb-4 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="max-w-lg text-[clamp(34px,4vw,52px)] font-semibold leading-[1.08] tracking-[-.04em]"><?php echo esc_html($title); ?></h2><?php } ?>
            <?php if ($copy) { ?><div class="mt-5 max-w-lg text-base leading-7 text-[#617087]"><?php echo wp_kses_post($copy); ?></div><?php } ?>
            <?php if ($phone || $email || $address) { ?>
                <ul class="mt-9 space-y-4 text-sm">
                    <?php if ($phone) { ?><li class="flex items-center gap-4"><span class="text-[#0867f2]"><?php echo inkwell_component_icon('phone', 'h-5 w-5'); ?></span><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li><?php } ?>
                    <?php if ($email) { ?><li class="flex items-center gap-4"><span class="text-[#0867f2]"><?php echo inkwell_component_icon('mail', 'h-5 w-5'); ?></span><a href="mailto:<?php echo esc_attr(antispambot($email)); ?>"><?php echo esc_html(antispambot($email)); ?></a></li><?php } ?>
                    <?php if ($address) { ?><li class="flex items-center gap-4"><span class="text-[#0867f2]"><?php echo inkwell_component_icon('pin', 'h-5 w-5'); ?></span><span><?php echo esc_html($address); ?></span></li><?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="form-content-panel rounded bg-white p-[clamp(24px,4vw,48px)] shadow-[0_18px_60px_rgba(20,45,80,.09)] ring-1 ring-[#edf0f5]">
            <?php if ($shortcode) { echo do_shortcode($shortcode); } elseif (!empty($is_preview)) { ?><p class="text-sm text-[#68758d]">Add a form shortcode to display the form here.</p><?php } ?>
        </div>
    </div>
</section>
