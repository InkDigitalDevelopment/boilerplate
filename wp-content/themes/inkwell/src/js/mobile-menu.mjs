export const mobileMenu = () => {
    const elements = {
        trigger: document.querySelector('.mobile-nav-trigger, .mobile-tav-trigger'),
        menu: document.querySelector('.theme-main-menu'),
        body: document.querySelector('body')
    };

    if (!elements.trigger || !elements.menu) {
        return;
    }

    const toggleMenu = () => {
        elements.menu.classList.toggle('open');
        elements.body.style.position = elements.body.style.position === 'fixed' ? '' : 'fixed';
    };

    elements.trigger.addEventListener('click', toggleMenu);
};
