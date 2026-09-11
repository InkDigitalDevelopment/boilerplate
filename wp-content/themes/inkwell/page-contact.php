<?php
/* Template Name: Contact Page */
get_header();
// Get Hero Field
$hero = function_exists('get_field') ? get_field('hero') : null;
?>
<!-- Page Hero -->
<?php if (!empty($hero['show_hero'])) {
    include(locate_template('template-parts/hero.php'));
} ?>
<div class="contact-content py-12">
    <div class="container mx-auto px-4">
        <div class="contact-content-inner">

            <?php
            while (have_posts()) {
                the_post();
                the_content();
            }
            ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
