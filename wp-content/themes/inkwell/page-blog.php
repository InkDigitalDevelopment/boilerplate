<?php
/* Template Name: Blog Page */
get_header();
// Get posts
$blogPosts = new WP_Query(
    array(
        'post_type'=>'post',
        'post_status'=>'publish',
        'posts_per_page'=> 8,
        'paged' => get_query_var( 'paged' )
    )
);
?>

<div class="blog py-12">
    <div class="container mx-auto px-4">
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 grid-rows-auto gap-4">
            <?php 
            if ( $blogPosts->have_posts() ) {
                while ( $blogPosts->have_posts() ) {
                    $blogPosts->the_post();

                    include(locate_template('template-parts/blog-card.php'));
                }
            }
            ?>
        </div>
        <div class="blog-pagination">
            <?php
            echo paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $blogPosts->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => -1,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf(  __( '<', 'text-domain' ) ),
                'next_text'    => sprintf(  __( '>', 'text-domain' ) ),
                'add_args'     => false,
                'add_fragment' => '',
            ) ); ?>
        </div>        
        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>
