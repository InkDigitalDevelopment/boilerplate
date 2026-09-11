<!-- Existing logo option retained for sites that already use it. -->
<?php
    $options = get_option('pixelpress_options', []);
    $logo = !empty($options['logo']) ? $options['logo'] : '';
?>
<footer class="footer py-8 border-t border-[#999]">
    <div class="container mx-auto px-4 flex flex-col items-center justify-between md:flex-row">
        <?php if (has_custom_logo()) { ?>
            <div class="max-w-[180px]"><?php the_custom_logo(); ?></div>
        <?php } elseif ($logo) { ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="w-full h-auto max-w-[180px]" src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            </a>
        <?php } else { ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <p class="text-4xl font-bold tracking-tighter"><?php echo esc_html(get_bloginfo('name')); ?></p>
            </a>
        <?php } ?>
        <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?></p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
