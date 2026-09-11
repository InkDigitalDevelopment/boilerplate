<?php
get_header();

$defaultImage = get_theme_mod('company_default_image', '');
?>
<div class="main-content py-12">
    <div class="container mx-auto px-4">
        <div class="main-content__inner--content">
            <div class="main-content__inner--content-main">
                <div class="overflow-hidden w-full h-[350px] rounded-md mb-6 relative">
                    <img class="absolute left-0 right-0 mx-auto z-0" src="<?php echo $defaultImage ?>" alt="<?php echo the_title(); ?> image">
                    <div class="bg-gradient-to-b from-transparent to-black w-full h-[350px] absolute left-0 right-0 mx-auto flex items-end">
                        <h1 class="text-white pl-6 pb-6"><?php echo the_title(); ?></h1>
                    </div>
                </div>
                <?php echo the_content(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>