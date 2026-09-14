export function initVideoTestimonials(root = document) {
  root.querySelectorAll('.video-play:not([data-video-ready])').forEach(button => {
    button.dataset.videoReady = 'true';
    button.addEventListener('click', () => {
      const src = button.dataset.videoSrc;
      const frame = button.closest('[data-video-frame]');
      if (!src || !frame) return;
      const iframe = document.createElement('iframe');
      iframe.src = src;
      iframe.title = button.getAttribute('aria-label') || 'Testimonial video';
      iframe.className = 'absolute inset-0 h-full w-full';
      iframe.allow = 'encrypted-media; picture-in-picture; fullscreen';
      iframe.allowFullscreen = true;
      frame.replaceChildren(iframe);
      iframe.focus();
    }, { once: true });
  });
}
