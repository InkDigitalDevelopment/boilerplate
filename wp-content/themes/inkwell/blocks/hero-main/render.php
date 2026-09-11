<?php
$title = get_field('title');
$copy = get_field('copy');
$primaryCta = get_field('primary_cta');
$secondaryCta = get_field('secondary_cta');
$image = get_field('image');
?>

<section class="hero-main">
    <div class="hero-inner mx-auto grid grid-cols-1 items-start gap-[clamp(24px,4vw,64px)] p-[clamp(24px,3vw,40px)] lg:grid-cols-[minmax(0,1fr)_minmax(0,.95fr)] lg:items-stretch">
        <div class="hero-content min-w-0 self-start pt-[140px] lg:self-end lg:pt-0">
            <!-- Hero Title -->
            <?php if ($title) { ?>
                <h1 class="hero-title font-bold uppercase leading-[.98]">
                    <?php echo wp_kses_post($title); ?>
                </h1>
            <?php } ?>

            <!-- Hero Copy -->
            <?php if ($copy) { ?>
                <div class="hero-copy my-[clamp(18px,2vw,24px)] max-w-[68ch] text-[clamp(16px,1.1vw,18px)] leading-[1.55] text-[var(--light-charcoal)]">
                    <?php echo wp_kses_post($copy); ?>
                </div>
            <?php } ?>

            <!-- CTAs -->
            <?php if($primaryCta || $secondaryCta) { ?>
                <div class="hero-ctas grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Primary CTA -->
                    <?php if (!empty($primaryCta['url']) && !empty($primaryCta['title'])): ?>
                    <a class="primary-cta text-center" href="<?php echo esc_url($primaryCta['url']); ?>"<?php if (!empty($primaryCta['target'])) { ?> target="<?php echo esc_attr($primaryCta['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                        <?php echo esc_html($primaryCta['title']); ?>
                    </a>
                    <?php endif; ?>

                    <!-- Secondary CTA -->
                    <?php if (!empty($secondaryCta['url']) && !empty($secondaryCta['title'])): ?>
                    <a class="secondary-cta text-center" href="<?php echo esc_url($secondaryCta['url']); ?>"<?php if (!empty($secondaryCta['target'])) { ?> target="<?php echo esc_attr($secondaryCta['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                        <?php echo esc_html($secondaryCta['title']); ?>
                    </a>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>

        <div class="hero-media flex min-w-0 w-full">
            <!-- Hero Image -->
            <?php if (!empty($image['url'])) { ?>
                <div class="hero-image flex w-full">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" class="h-auto w-full">
                </div>
            <?php } ?>
        </div>
    </div>
</section>
