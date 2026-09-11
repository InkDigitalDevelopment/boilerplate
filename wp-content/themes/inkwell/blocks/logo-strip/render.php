<?php
$eyebrow = get_field('logo_strip_eyebrow');
$logos = get_field('logo_strip_logos') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'logo-strip');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="border-y border-[#e2e7ef] bg-white px-6 py-[clamp(48px,7vw,84px)] text-[#09152f]">
    <div class="mx-auto max-w-7xl">
        <?php if ($eyebrow) { ?><p class="mb-9 text-center text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
        <?php if ($logos) { ?>
            <div class="flex flex-wrap items-center justify-center gap-x-[clamp(28px,5vw,72px)] gap-y-8">
                <?php foreach ($logos as $item) {
                    $logo = $item['logo_strip_logo'] ?? null;
                    $link = $item['logo_strip_link'] ?? null;
                    $logoMarkup = inkwell_component_image($logo, 'medium', 'max-h-9 w-auto max-w-[140px] object-contain grayscale opacity-70 transition hover:grayscale-0 hover:opacity-100');
                    if (!$logoMarkup) continue;
                    if (!empty($link['url'])) { ?>
                        <a href="<?php echo esc_url($link['url']); ?>"<?php if (!empty($link['target'])) { ?> target="<?php echo esc_attr($link['target']); ?>" rel="noopener noreferrer"<?php } ?>><?php echo $logoMarkup; ?></a>
                    <?php } else { echo $logoMarkup; }
                } ?>
            </div>
        <?php } ?>
    </div>
</section>
