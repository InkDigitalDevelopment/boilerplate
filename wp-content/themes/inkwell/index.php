<?php get_header(); ?>
<main class="container mx-auto px-4 py-12">
    <?php if (have_posts()) { ?>
        <?php while (have_posts()) {
            the_post(); ?>
            <article <?php post_class('mb-12'); ?>>
                <h2 class="mb-4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </article>
        <?php } ?>
        <?php the_posts_pagination(); ?>
    <?php } else { ?>
        <p><?php esc_html_e('No posts found.', 'inkwell'); ?></p>
    <?php } ?>
</main>
<?php get_footer(); ?>
