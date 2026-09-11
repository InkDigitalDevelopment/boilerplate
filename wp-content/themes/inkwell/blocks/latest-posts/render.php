<?php
$eyebrow = get_field('latest_posts_eyebrow');
$title = get_field('latest_posts_title');
$archiveLink = get_field('latest_posts_archive_link');
$posts = get_field('latest_posts_posts') ?: [];
$count = max(1, min(6, (int) (get_field('latest_posts_count') ?: 3)));
$sectionId = inkwell_component_id($block ?? [], 'latest-posts');
if (!$posts) {
    $posts = get_posts(['post_type' => 'post', 'post_status' => 'publish', 'numberposts' => $count]);
}
$posts = array_slice($posts, 0, $count);
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto max-w-7xl">
        <header class="mb-8 flex flex-wrap items-end justify-between gap-5">
            <div>
                <?php if ($eyebrow) { ?><p class="mb-3 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
                <?php if ($title) { ?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight tracking-[-.035em]"><?php echo esc_html($title); ?></h2><?php } ?>
            </div>
            <?php if ($archiveLink) { echo inkwell_component_link($archiveLink, 'text-sm font-semibold text-[#0867f2] hover:underline'); } ?>
        </header>
        <?php if ($posts) { ?>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($posts as $postItem) {
                    $postId = is_object($postItem) ? $postItem->ID : (int) $postItem;
                    if (!$postId) continue;
                    ?>
                    <article class="overflow-hidden rounded border border-[#dfe5ee] bg-white">
                        <a href="<?php echo esc_url(get_permalink($postId)); ?>" class="block aspect-[16/9] bg-[#e9edf3]">
                            <?php echo get_the_post_thumbnail($postId, 'large', ['class' => 'h-full w-full object-cover']); ?>
                        </a>
                        <div class="p-5">
                            <time class="text-xs text-[#69758a]" datetime="<?php echo esc_attr(get_the_date('c', $postId)); ?>"><?php echo esc_html(get_the_date('', $postId)); ?></time>
                            <h3 class="mt-3 text-xl font-semibold leading-snug"><a href="<?php echo esc_url(get_permalink($postId)); ?>"><?php echo esc_html(get_the_title($postId)); ?></a></h3>
                            <a href="<?php echo esc_url(get_permalink($postId)); ?>" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#0867f2]">Read more <?php echo inkwell_component_icon('arrow', 'h-4 w-4'); ?></a>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
