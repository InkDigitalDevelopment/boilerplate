<?php
/* Template Name: Homepage */
get_header();
?>

<div class="main-content py-14">
    <div class="container mx-auto px-4">
        <div class="">
            <h2><?php echo the_title(); ?></h2>
            <?php echo the_content(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>