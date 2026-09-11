<?php
$heading = get_field('heading');
$stats = get_field('stats');
?>

<section class="stats-highlights bg-[var(--brand-charcoal)] px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)] text-white">
    <div class="mx-auto max-w-7xl">
        <?php if ($heading) { ?>
            <h2 class="mb-[clamp(28px,4vw,48px)] max-w-3xl font-bold leading-tight">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php } ?>

        <?php if ($stats) { ?>
            <dl class="grid grid-cols-1 gap-px bg-white/20 sm:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($stats as $stat) { ?>
                    <div class="flex flex-col bg-[var(--brand-charcoal)] p-[clamp(24px,4vw,40px)]">
                        <?php if (!empty($stat['label'])) { ?>
                            <dt class="order-2 mt-3 text-[clamp(16px,1.2vw,20px)] leading-snug">
                                <?php echo esc_html($stat['label']); ?>
                            </dt>
                        <?php } ?>

                        <?php if (!empty($stat['value'])) { ?>
                            <dd class="order-1 text-[clamp(42px,5vw,72px)] font-bold leading-none text-[var(--brand-gold)]">
                                <?php echo esc_html($stat['value']); ?>
                            </dd>
                        <?php } ?>
                    </div>
                <?php } ?>
            </dl>
        <?php } ?>
    </div>
</section>
