// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.querySelector('[data-nav-toggle]');
  const panel = document.querySelector('[data-nav-panel]');
  
  if (!btn || !panel) return;
  
  const close = () => {
    panel.classList.add('hidden');
    btn.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  };
  
  const open = () => {
    panel.classList.remove('hidden');
    btn.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  };
  
  const toggle = () => {
    if (panel.classList.contains('hidden')) {
      open();
    } else {
      close();
    }
  };
  
  // Toggle on button click
  btn.addEventListener('click', toggle);
  
  // Close on backdrop click
  panel.addEventListener('click', (e) => {
    if (e.target === panel) {
      close();
    }
  });
  
  // Close on navigation link click
  const navLinks = panel.querySelectorAll('a');
  navLinks.forEach(link => {
    link.addEventListener('click', close);
  });
  
  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !panel.classList.contains('hidden')) {
      close();
    }
  });
});

