<?php
$heading = get_field('heading');
$copy = get_field('copy');
$primaryCta = get_field('primary_cta');
$secondaryCta = get_field('secondary_cta');
$ctaColumns = $primaryCta && $secondaryCta ? 'sm:grid-cols-2' : 'sm:grid-cols-1';
?>

<section class="simple-cta px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)]">
    <div class="mx-auto max-w-7xl bg-[var(--brand-gold)] p-[clamp(28px,6vw,72px)] text-center">
        <?php if ($heading) { ?>
            <h2 class="mx-auto max-w-4xl font-bold leading-tight text-[var(--brand-charcoal)]">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php } ?>

        <?php if ($copy) { ?>
            <div class="mx-auto mt-5 max-w-3xl text-[clamp(16px,1.2vw,20px)] leading-relaxed text-[var(--brand-charcoal)]">
                <?php echo wp_kses_post($copy); ?>
            </div>
        <?php } ?>

        <?php if ($primaryCta || $secondaryCta) { ?>
            <div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-4 <?php echo esc_attr($ctaColumns); ?>">
                <?php if ($primaryCta && !empty($primaryCta['url']) && !empty($primaryCta['title'])) { ?>
                    <a class="primary-cta" href="<?php echo esc_url($primaryCta['url']); ?>"<?php if (!empty($primaryCta['target'])) { ?> target="<?php echo esc_attr($primaryCta['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                        <?php echo esc_html($primaryCta['title']); ?>
                    </a>
                <?php } ?>

                <?php if ($secondaryCta && !empty($secondaryCta['url']) && !empty($secondaryCta['title'])) { ?>
                    <a class="secondary-cta" href="<?php echo esc_url($secondaryCta['url']); ?>"<?php if (!empty($secondaryCta['target'])) { ?> target="<?php echo esc_attr($secondaryCta['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                        <?php echo esc_html($secondaryCta['title']); ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
