<?php
    if (!function_exists('get_field')) {
        return;
    }
    $showHero = get_field('show_hero_component');
    $hero = get_field('hero_component');
    if (!$showHero || !is_array($hero)) {
        return;
    }
    $backgroundImage = $hero['background_image'] ?? '';
    $title = $hero['title'] ?? '';
    $heroText = $hero['hero_text'] ?? '';
    $linkUrl = $hero['link_url'] ?? '';
    $linkText = $hero['link_text'] ?? '';
?>

<div class="py-40 bg-cover bg-top" <?php if ($backgroundImage) { ?> style="background-image: url('<?php echo esc_url($backgroundImage); ?>')" <?php } ?>>
    <div class="container mx-auto px-4">
        <div class="hero-content">
            <!-- Hero Title -->
            <h1 class="hero-title text-white text-4xl md:text-[60px] leading-tight mb-6"><?php echo esc_html($title); ?></h1>

            <?php
                // Hero Copy
                if ($heroText):
                    echo wp_kses_post($heroText);
                endif;
                // if link exists display
                if ($linkUrl):
                    echo '<a class="hero__inner--link" href="' . esc_url($linkUrl) . '">' . esc_html($linkText) . '</a>';
                endif;
            ?>
        </div>
    </div>
</div>
