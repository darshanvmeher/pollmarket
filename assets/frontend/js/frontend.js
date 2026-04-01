(function () {
  const navToggler = document.querySelector('[data-nav-toggle]');
  const navCollapse = document.getElementById('siteNav');
  const quantityButtons = document.querySelectorAll('[data-qty-action]');

  if (navToggler && navCollapse) {
    navToggler.addEventListener('click', () => {
      navCollapse.classList.toggle('show');
    });
  }

  quantityButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const action = button.getAttribute('data-qty-action');
      const input = document.querySelector(button.getAttribute('data-qty-target'));
      if (!input) return;

      const current = parseInt(input.value, 10) || 1;
      input.value = action === 'increase' ? current + 1 : Math.max(1, current - 1);
    });
  });
})();
