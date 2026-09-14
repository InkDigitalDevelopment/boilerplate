export function initBeforeAfterSliders(root = document) {
  root.querySelectorAll('[data-comparison]:not([data-comparison-ready])').forEach(comparison => {
    comparison.dataset.comparisonReady = 'true';
    const control = comparison.querySelector('.comparison-control');
    if (!control) return;
    const update = () => comparison.style.setProperty('--comparison-position', `${control.value}%`);
    control.addEventListener('input', update);
    update();
  });
}
