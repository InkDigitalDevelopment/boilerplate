<?php
$heading = get_field('heading');
$faqs = get_field('faqs');
?>

<section class="accordion-faqs px-[clamp(24px,4vw,64px)] py-[clamp(48px,7vw,96px)]">
    <div class="mx-auto max-w-4xl">
        <?php if ($heading) { ?>
            <h2 class="mb-[clamp(28px,4vw,48px)] font-bold leading-tight text-[var(--brand-charcoal)]">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php } ?>

        <?php if ($faqs) { ?>
            <div class="border-t border-black/20">
                <?php foreach ($faqs as $faq) { ?>
                    <details class="group border-b border-black/20">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-5 py-6 text-[clamp(18px,1.6vw,24px)] font-bold text-[var(--brand-charcoal)] [&::-webkit-details-marker]:hidden">
                            <span><?php echo esc_html($faq['question'] ?? ''); ?></span>
                            <span class="text-2xl font-normal leading-none transition-transform group-open:rotate-45" aria-hidden="true">+</span>
                        </summary>

                        <?php if (!empty($faq['answer'])) { ?>
                            <div class="max-w-[75ch] pb-6 leading-relaxed text-[var(--light-charcoal)]">
                                <?php echo wp_kses_post($faq['answer']); ?>
                            </div>
                        <?php } ?>
                    </details>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
