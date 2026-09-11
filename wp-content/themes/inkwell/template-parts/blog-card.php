<div class="w-full border border-[#999] rounded-md overflow-hidden">
    <?php if (has_post_thumbnail()) {
        the_post_thumbnail('large', ['class' => 'w-full h-auto']);
    } ?>
    <div class="p-4">
        <h3 class="font-semibold">
            <a href="<?php the_permalink(); ?>">
                <?php the_title() ?>
            </a>
        </h3>
        <div class="my-4">
            <?php the_excerpt(); ?>
        </div>
        <a class="text-sm" href="<?php the_permalink() ?>">Read More...</a>
    </div>
</div>
