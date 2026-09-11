<?php
$heading = get_field('heading');
$testimonials = get_field('testimonials');
?>

<section class="testimonials bg-[var(--off-white)] px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)]">
    <div class="mx-auto max-w-7xl">
        <?php if ($heading) { ?>
            <h2 class="mb-[clamp(28px,4vw,48px)] max-w-3xl font-bold leading-tight text-[var(--brand-charcoal)]">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php } ?>

        <?php if ($testimonials) { ?>
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <?php foreach ($testimonials as $testimonial) {
                    $quote = $testimonial['quote'] ?? '';
                    $name = $testimonial['name'] ?? '';
                    $roleCompany = $testimonial['role_company'] ?? '';
                    $image = $testimonial['image'] ?? null;
                    ?>
                    <blockquote class="flex h-full flex-col bg-white p-[clamp(24px,4vw,40px)]">
                        <?php if ($quote) { ?>
                            <p class="flex-1 text-[clamp(20px,2vw,28px)] leading-relaxed text-[var(--brand-charcoal)]">
                                &ldquo;<?php echo esc_html($quote); ?>&rdquo;
                            </p>
                        <?php } ?>

                        <?php if ($name || $roleCompany || ($image && !empty($image['url']))) { ?>
                            <footer class="mt-7 flex items-center gap-4">
                                <?php if ($image && !empty($image['url'])) { ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" class="h-16 w-16 rounded-full object-cover">
                                <?php } ?>

                                <div>
                                    <?php if ($name) { ?>
                                        <cite class="block font-bold not-italic text-[var(--brand-charcoal)]">
                                            <?php echo esc_html($name); ?>
                                        </cite>
                                    <?php } ?>
                                    <?php if ($roleCompany) { ?>
                                        <p class="mt-1 text-sm text-[var(--light-charcoal)]">
                                            <?php echo esc_html($roleCompany); ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </footer>
                        <?php } ?>
                    </blockquote>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
