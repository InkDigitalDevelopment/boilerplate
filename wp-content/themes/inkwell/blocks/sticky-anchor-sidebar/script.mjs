export function initStickyAnchorSidebars(root = document) {
  root.querySelectorAll('[data-anchor-sidebar]:not([data-anchor-ready])').forEach(component => {
    component.dataset.anchorReady = 'true';
    const links = [...component.querySelectorAll('[data-anchor-target]')];
    const pairs = links.map(link => ({ link, section: document.getElementById(link.dataset.anchorTarget) })).filter(pair => pair.section);
    if (!pairs.length || !('IntersectionObserver' in window)) return;
    const setActive = activeLink => links.forEach(link => {
      const active = link === activeLink;
      link.classList.toggle('is-active', active);
      link.classList.toggle('border-[#0867f2]', active);
      link.classList.toggle('text-[#0867f2]', active);
      link.classList.toggle('border-transparent', !active);
      link.classList.toggle('opacity-70', !active);
      if (active) link.setAttribute('aria-current', 'location'); else link.removeAttribute('aria-current');
    });
    const observer = new IntersectionObserver(entries => {
      const visible = entries.filter(entry => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (visible) setActive(pairs.find(pair => pair.section === visible.target)?.link);
    }, { rootMargin: '-20% 0px -60% 0px', threshold: [0, .1, .5] });
    pairs.forEach(pair => observer.observe(pair.section));
  });
}
