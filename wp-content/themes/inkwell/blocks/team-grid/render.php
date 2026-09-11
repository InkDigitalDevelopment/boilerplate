<?php
$eyebrow = get_field('team_grid_eyebrow');
$title = get_field('team_grid_title');
$members = get_field('team_grid_members') ?: [];
$sectionId = inkwell_component_id($block ?? [], 'team-grid');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="bg-white px-6 py-[clamp(64px,8vw,104px)] text-[#09152f]">
    <div class="mx-auto max-w-7xl">
        <header class="mx-auto mb-10 max-w-3xl text-center">
            <?php if ($eyebrow) { ?><p class="mb-3 text-xs font-semibold uppercase tracking-[.14em] text-[#7b879d]"><?php echo esc_html($eyebrow); ?></p><?php } ?>
            <?php if ($title) { ?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight tracking-[-.035em]"><?php echo esc_html($title); ?></h2><?php } ?>
        </header>
        <?php if ($members) { ?>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($members as $member) { ?>
                    <article class="overflow-hidden rounded border border-[#dfe5ee] bg-white">
                        <div class="aspect-[4/3] bg-[#e9edf3]"><?php echo inkwell_component_image($member['team_grid_photo'] ?? null, 'large', 'h-full w-full object-cover object-top'); ?></div>
                        <div class="p-5">
                            <?php if (!empty($member['team_grid_name'])) { ?><h3 class="text-base font-semibold"><?php echo esc_html($member['team_grid_name']); ?></h3><?php } ?>
                            <?php if (!empty($member['team_grid_role'])) { ?><p class="mt-1 text-sm text-[#657188]"><?php echo esc_html($member['team_grid_role']); ?></p><?php } ?>
                            <div class="mt-4 flex min-h-5 items-center gap-4 text-sm font-semibold text-[#0d2348]">
                                <?php if (!empty($member['team_grid_linkedin'])) { ?><a href="<?php echo esc_url($member['team_grid_linkedin']); ?>" aria-label="<?php echo esc_attr(($member['team_grid_name'] ?? 'Team member') . ' on LinkedIn'); ?>">in</a><?php } ?>
                                <?php if (!empty($member['team_grid_x'])) { ?><a href="<?php echo esc_url($member['team_grid_x']); ?>" aria-label="<?php echo esc_attr(($member['team_grid_name'] ?? 'Team member') . ' on X'); ?>">X</a><?php } ?>
                                <?php if (!empty($member['team_grid_instagram'])) { ?><a href="<?php echo esc_url($member['team_grid_instagram']); ?>" aria-label="<?php echo esc_attr(($member['team_grid_name'] ?? 'Team member') . ' on Instagram'); ?>">◎</a><?php } ?>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
