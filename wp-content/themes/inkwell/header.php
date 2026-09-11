<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="w-full py-6 shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <?php if (has_custom_logo()) { ?>
                <div class="max-w-[180px]"><?php the_custom_logo(); ?></div>
            <?php } else { ?>
                <a class="text-3xl font-bold" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                </a>
            <?php } ?>
    
            <nav aria-label="Primary navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'menu_class'     => 'nav-menu',
                    'container'     => false,
                    'order'          => 'ASC',
                ));
                ?>
            </nav>
        </div>
    </div>
</header>
