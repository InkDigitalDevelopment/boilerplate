export const navScroll = () => {
    const sections = document.querySelectorAll('.section');
    const navLi = document.querySelectorAll('.docs-side-nav__item--link');

    if (!sections.length || !navLi.length) {
        return;
    }

    window.addEventListener('scroll', () => {
        let current = "";
      
        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            if (scrollY >= sectionTop + 450) {
                current = section.getAttribute("id");
            }
        });
      
        navLi.forEach((li) => {
            li.classList.remove("active");

            if (current && li.classList.contains(current)) {
                li.classList.add("active");
            }
        });
    }, { passive: true });

    // Add active class to side menu items
    const menuItems = document.querySelectorAll(".docs-side-nav__item--link");

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            menuItems.forEach(i => {i.classList.remove('active')})
            item.classList.add('active');
        })
    });    
}
