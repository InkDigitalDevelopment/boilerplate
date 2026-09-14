// JS Module Imports
// Responsible for the side menu auto scroll and active class on the theme docs page
import { navScroll } from './nav-scroll.mjs';
navScroll();
// Responsible for the mobile menu trigger
import { mobileMenu } from './mobile-menu.mjs';
mobileMenu();
import { initStickySideContent } from '../../blocks/sticky-side-content/script.mjs';
import { initImageHotspots } from '../../blocks/image-hotspots/script.mjs';
import { initBeforeAfterSliders } from '../../blocks/before-after-slider/script.mjs';
import { initVideoTestimonials } from '../../blocks/video-testimonial/script.mjs';
import { initStickyAnchorSidebars } from '../../blocks/sticky-anchor-sidebar/script.mjs';

const initComponents = (root = document) => {
    initStickySideContent(root);
    initImageHotspots(root);
    initBeforeAfterSliders(root);
    initVideoTestimonials(root);
    initStickyAnchorSidebars(root);
};

initComponents();

if (window.acf?.addAction) {
    window.acf.addAction('render_block_preview', element => {
        initComponents(element?.[0] || element || document);
    });
}
