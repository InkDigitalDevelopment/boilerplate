<?php
$p = 'sticky_side_content';
$sidebarHeading = get_field("{$p}_sidebar_heading");
$ctaHeading = get_field("{$p}_cta_heading");
$ctaCopy = get_field("{$p}_cta_copy");
$cta = get_field("{$p}_cta");
$tabs = get_field("{$p}_tabs") ?: [];
$settings = get_field("{$p}_section_settings");
$sectionId = inkwell_component_id($block ?? [], 'sticky-side-content');
?>
<section id="<?php echo esc_attr($sectionId); ?>" class="sticky-side-content px-6 <?php echo esc_attr(inkwell_component_section_classes($settings, $p)); ?>" data-tab-component>
 <div class="mx-auto grid gap-10 lg:grid-cols-[190px_minmax(0,1fr)] lg:gap-12 <?php echo esc_attr(inkwell_component_container_class($settings, $p)); ?>">
  <aside class="lg:sticky lg:top-8 lg:self-start">
   <?php if ($sidebarHeading) { ?><p class="mb-4 text-xs font-semibold uppercase tracking-[.14em] opacity-60"><?php echo esc_html($sidebarHeading); ?></p><?php } ?>
   <div class="flex gap-2 overflow-x-auto border-b border-[#dfe5ee] lg:block lg:border-b-0 lg:border-r" role="tablist" aria-label="<?php echo esc_attr($sidebarHeading ?: 'Content sections'); ?>">
    <?php foreach ($tabs as $i => $tab) { ?><button type="button" class="tab-trigger whitespace-nowrap border-b-2 px-3 py-2 text-left text-sm lg:block lg:w-full lg:border-b-0 lg:border-l-2 <?php echo $i === 0 ? 'is-active border-[#0867f2] text-[#0867f2]' : 'border-transparent opacity-70'; ?>" role="tab" id="<?php echo esc_attr("$sectionId-tab-$i"); ?>" aria-controls="<?php echo esc_attr("$sectionId-panel-$i"); ?>" aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>" tabindex="<?php echo $i === 0 ? '0' : '-1'; ?>"><?php echo esc_html($tab["{$p}_tab_label"] ?? ''); ?></button><?php } ?>
   </div>
   <?php if ($ctaHeading || $ctaCopy || $cta) { ?><div class="mt-7 hidden rounded border border-[#dfe5ee] bg-white p-4 text-[#09152f] shadow-sm lg:block"><?php if ($ctaHeading) { ?><strong class="block text-sm"><?php echo esc_html($ctaHeading); ?></strong><?php } ?><?php if ($ctaCopy) { ?><p class="mt-1 text-xs leading-5 text-[#647087]"><?php echo wp_kses_post($ctaCopy); ?></p><?php } ?><?php if ($cta) { ?><div class="mt-4"><?php echo inkwell_component_link($cta, 'inline-flex rounded bg-[#0867f2] px-4 py-2 text-xs font-semibold text-white'); ?></div><?php } ?></div><?php } ?>
  </aside>
  <div>
   <?php foreach ($tabs as $i => $tab) { $bullets = $tab["{$p}_bullets"] ?? []; ?>
    <div id="<?php echo esc_attr("$sectionId-panel-$i"); ?>" class="tab-panel" role="tabpanel" aria-labelledby="<?php echo esc_attr("$sectionId-tab-$i"); ?>"<?php if ($i !== 0) echo ' hidden'; ?>>
     <div class="grid gap-10 xl:grid-cols-[minmax(0,1fr)_minmax(260px,.75fr)] xl:gap-14">
      <div><?php if (!empty($tab["{$p}_eyebrow"])) { ?><p class="mb-4 text-xs font-semibold uppercase tracking-[.14em] opacity-60"><?php echo esc_html($tab["{$p}_eyebrow"]); ?></p><?php } ?><?php if (!empty($tab["{$p}_title"])) { ?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight tracking-[-.035em]"><?php echo esc_html($tab["{$p}_title"]); ?></h2><?php } ?><?php if (!empty($tab["{$p}_content"])) { ?><div class="mt-5 text-base leading-7 opacity-75"><?php echo wp_kses_post($tab["{$p}_content"]); ?></div><?php } ?><?php if ($bullets) { ?><ul class="mt-7 space-y-4"><?php foreach ($bullets as $bullet) { ?><li class="flex gap-3 text-sm"><span class="mt-0.5 text-[#0867f2]"><?php echo inkwell_component_icon('check','h-5 w-5'); ?></span><?php echo esc_html($bullet["{$p}_bullet"] ?? ''); ?></li><?php } ?></ul><?php } ?></div>
      <div class="min-h-[380px] overflow-hidden bg-[#e9edf3]"><?php echo inkwell_component_image($tab["{$p}_image"] ?? null, 'large', 'h-full min-h-[380px] w-full object-cover'); ?></div>
     </div>
    </div>
   <?php } ?>
  </div>
 </div>
</section>
