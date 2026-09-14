export function initImageHotspots(root = document) {
  root.querySelectorAll('[data-hotspots]:not([data-hotspots-ready])').forEach(component => {
    component.dataset.hotspotsReady = 'true';
    const triggers = [...component.querySelectorAll('[data-hotspot-index]')];
    const details = [...component.querySelectorAll('[data-hotspot-detail]')];
    const activate = index => {
      triggers.forEach(trigger => {
        const active = trigger.dataset.hotspotIndex === index;
        trigger.setAttribute('aria-pressed', String(active));
        trigger.classList.toggle('is-active', active);
      });
      details.forEach(detail => { detail.hidden = detail.dataset.hotspotDetail !== index; });
    };
    triggers.forEach(trigger => {
      trigger.addEventListener('click', () => activate(trigger.dataset.hotspotIndex));
      trigger.addEventListener('focus', () => activate(trigger.dataset.hotspotIndex));
    });
  });
}
