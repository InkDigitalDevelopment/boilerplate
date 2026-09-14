<?php
$p='before_after_slider'; $eyebrow=get_field("{$p}_eyebrow"); $title=get_field("{$p}_title"); $content=get_field("{$p}_content"); $before=get_field("{$p}_before_image"); $after=get_field("{$p}_after_image"); $beforeLabel=get_field("{$p}_before_label")?:'Before'; $afterLabel=get_field("{$p}_after_label")?:'After'; $position=max(10,min(90,(int)(get_field("{$p}_start_position")?:50))); $settings=get_field("{$p}_section_settings"); $sectionId=inkwell_component_id($block??[],'before-after-slider');
?>
<section id="<?php echo esc_attr($sectionId);?>" class="before-after-slider px-6 <?php echo esc_attr(inkwell_component_section_classes($settings,$p));?>">
 <div class="mx-auto <?php echo esc_attr(inkwell_component_container_class($settings,$p));?>">
  <?php if($eyebrow||$title||$content){?><header class="mb-8 max-w-3xl"><?php if($eyebrow){?><p class="mb-3 text-xs font-semibold uppercase tracking-[.14em] opacity-60"><?php echo esc_html($eyebrow);?></p><?php }?><?php if($title){?><h2 class="text-[clamp(32px,4vw,48px)] font-semibold leading-tight"><?php echo esc_html($title);?></h2><?php }?><?php if($content){?><div class="mt-4 leading-7 opacity-75"><?php echo wp_kses_post($content);?></div><?php }?></header><?php }?>
  <div class="comparison relative aspect-[16/7] min-h-[320px] overflow-hidden rounded bg-[#e9edf3]" data-comparison style="--comparison-position:<?php echo esc_attr($position);?>%">
   <div class="absolute inset-0"><?php echo inkwell_component_image($after,'full','h-full w-full object-cover');?></div>
   <div class="comparison-before absolute inset-0 overflow-hidden"><?php echo inkwell_component_image($before,'full','h-full w-full object-cover grayscale');?></div>
   <span class="absolute right-4 top-4 rounded bg-[#101d2e]/85 px-4 py-2 text-xs font-semibold text-white"><?php echo esc_html($afterLabel);?></span><span class="absolute left-4 top-4 rounded bg-[#101d2e]/85 px-4 py-2 text-xs font-semibold text-white"><?php echo esc_html($beforeLabel);?></span>
   <div class="comparison-divider pointer-events-none absolute inset-y-0 w-0.5 -translate-x-1/2 bg-white"><span class="absolute left-1/2 top-1/2 flex h-12 w-12 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-[#09152f] shadow-lg" aria-hidden="true">↔</span></div>
   <label class="sr-only" for="<?php echo esc_attr($sectionId.'-control');?>">Image comparison position</label><input id="<?php echo esc_attr($sectionId.'-control');?>" class="comparison-control absolute inset-0 h-full w-full cursor-ew-resize opacity-0" type="range" min="0" max="100" value="<?php echo esc_attr($position);?>">
  </div>
 </div>
</section>
