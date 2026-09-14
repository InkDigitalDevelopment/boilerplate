export function initStickySideContent(root = document) {
  root.querySelectorAll('[data-tab-component]:not([data-tabs-ready])').forEach(component => {
    component.dataset.tabsReady = 'true';
    const tabs = [...component.querySelectorAll('[role="tab"]')];
    const panels = [...component.querySelectorAll('[role="tabpanel"]')];
    const activate = (tab, focus = false) => {
      tabs.forEach(item => {
        const active = item === tab;
        item.setAttribute('aria-selected', String(active));
        item.tabIndex = active ? 0 : -1;
        item.classList.toggle('is-active', active);
        item.classList.toggle('border-[#0867f2]', active);
        item.classList.toggle('text-[#0867f2]', active);
        item.classList.toggle('border-transparent', !active);
        item.classList.toggle('opacity-70', !active);
      });
      panels.forEach(panel => { panel.hidden = panel.id !== tab.getAttribute('aria-controls'); });
      if (focus) tab.focus();
    };
    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => activate(tab));
      tab.addEventListener('keydown', event => {
        let next = index;
        if (event.key === 'ArrowDown' || event.key === 'ArrowRight') next = (index + 1) % tabs.length;
        else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
        else if (event.key === 'Home') next = 0;
        else if (event.key === 'End') next = tabs.length - 1;
        else return;
        event.preventDefault(); activate(tabs[next], true);
      });
    });
  });
}
