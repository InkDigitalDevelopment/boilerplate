<?php
$heading = get_field('heading');
$copy = get_field('copy');
$image = get_field('image');
$imagePosition = get_field('image_position') ?: 'right';
$cta = get_field('cta');
$contentOrder = $imagePosition === 'left' ? 'lg:order-2' : 'lg:order-1';
$imageOrder = $imagePosition === 'left' ? 'lg:order-1' : 'lg:order-2';
$layoutColumns = $image && !empty($image['url']) ? 'lg:grid-cols-2' : 'lg:grid-cols-1';
?>

<section class="text-image px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)]">
    <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-[clamp(32px,6vw,80px)] <?php echo esc_attr($layoutColumns); ?>">
        <div class="text-image-content <?php echo esc_attr($contentOrder); ?>">
            <?php if ($heading) { ?>
                <h2 class="font-bold leading-tight text-[var(--brand-charcoal)]">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php } ?>

            <?php if ($copy) { ?>
                <div class="mt-5 max-w-[68ch] text-[clamp(16px,1.1vw,18px)] leading-relaxed text-[var(--light-charcoal)]">
                    <?php echo wp_kses_post($copy); ?>
                </div>
            <?php } ?>

            <?php if ($cta && !empty($cta['url']) && !empty($cta['title'])) { ?>
                <div class="mt-7 max-w-xs">
                    <a class="primary-cta" href="<?php echo esc_url($cta['url']); ?>"<?php if (!empty($cta['target'])) { ?> target="<?php echo esc_attr($cta['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                        <?php echo esc_html($cta['title']); ?>
                    </a>
                </div>
            <?php } ?>
        </div>

        <?php if ($image && !empty($image['url'])) { ?>
            <div class="text-image-media <?php echo esc_attr($imageOrder); ?>">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" class="h-auto w-full object-cover">
            </div>
        <?php } ?>
    </div>
</section>
