(function () {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');

  function setActiveMenu() {
    const current = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('[data-nav-item]').forEach((item) => {
      const href = item.getAttribute('href');
      if (href === current || (current === '' && href === 'index.html')) {
        item.classList.add('active');
      } else {
        item.classList.remove('active');
      }
    });
  }

  function closeSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
  }

  function toggleSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
  }

  toggleButtons.forEach((btn) => btn.addEventListener('click', toggleSidebar));
  if (overlay) overlay.addEventListener('click', closeSidebar);

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      closeSidebar();
    }
  });

  setActiveMenu();
})();
