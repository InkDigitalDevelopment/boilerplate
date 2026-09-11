<?php
$sectionHeading = get_field('section_heading');
$sectionIntro = get_field('section_intro');
$cards = get_field('cards');
?>

<section class="card-grid px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)]">
    <div class="mx-auto max-w-7xl">
        <?php if ($sectionHeading || $sectionIntro) { ?>
            <header class="mb-[clamp(28px,4vw,48px)] max-w-3xl">
                <?php if ($sectionHeading) { ?>
                    <h2 class="font-bold leading-tight text-[var(--brand-charcoal)]">
                        <?php echo esc_html($sectionHeading); ?>
                    </h2>
                <?php } ?>

                <?php if ($sectionIntro) { ?>
                    <div class="mt-4 text-[clamp(16px,1.1vw,18px)] leading-relaxed text-[var(--light-charcoal)]">
                        <?php echo wp_kses_post($sectionIntro); ?>
                    </div>
                <?php } ?>
            </header>
        <?php } ?>

        <?php if ($cards) { ?>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($cards as $card) {
                    $cardHeading = $card['card_heading'] ?? '';
                    $cardCopy = $card['card_copy'] ?? '';
                    $imageIcon = $card['image_icon'] ?? null;
                    $link = $card['link'] ?? null;
                    ?>
                    <article class="flex h-full flex-col overflow-hidden border border-black/10 bg-white">
                        <?php if ($imageIcon && !empty($imageIcon['url'])) { ?>
                            <img src="<?php echo esc_url($imageIcon['url']); ?>" alt="<?php echo esc_attr($imageIcon['alt'] ?? ''); ?>" class="aspect-[16/10] w-full object-cover">
                        <?php } ?>

                        <div class="flex flex-1 flex-col p-[clamp(22px,3vw,32px)]">
                            <?php if ($cardHeading) { ?>
                                <h3 class="text-[clamp(24px,2vw,32px)] font-bold leading-tight text-[var(--brand-charcoal)]">
                                    <?php echo esc_html($cardHeading); ?>
                                </h3>
                            <?php } ?>

                            <?php if ($cardCopy) { ?>
                                <div class="mt-4 flex-1 leading-relaxed text-[var(--light-charcoal)]">
                                    <?php echo wp_kses_post($cardCopy); ?>
                                </div>
                            <?php } ?>

                            <?php if ($link && !empty($link['url']) && !empty($link['title'])) { ?>
                                <a class="mt-6 font-bold text-[var(--brand-purple)] underline decoration-2 underline-offset-4" href="<?php echo esc_url($link['url']); ?>"<?php if (!empty($link['target'])) { ?> target="<?php echo esc_attr($link['target']); ?>" rel="noopener noreferrer"<?php } ?>>
                                    <?php echo esc_html($link['title']); ?>
                                </a>
                            <?php } ?>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
