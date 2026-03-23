(function () {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');

  function setActiveMenu() {
    const currentPath = window.location.pathname.replace(/\/+$/, '');
    let matched = false;
    document.querySelectorAll('[data-nav-item]').forEach((item) => {
      const hrefPath = new URL(item.href, window.location.origin).pathname.replace(/\/+$/, '');
      const isActive = currentPath === hrefPath || currentPath.endsWith(hrefPath);
      if (isActive) {
        matched = true;
        item.classList.add('active');
      } else if (!item.classList.contains('active')) {
        item.classList.remove('active');
      }
    });

    // Keep server-rendered active state in CI3 if pathname matching fails.
    if (!matched) {
      return;
    }
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

  function initCategoryModals() {
    const categoryFormModal = document.getElementById('categoryFormModal');
    const categoryDeleteModal = document.getElementById('categoryDeleteModal');

    if (categoryFormModal) {
      categoryFormModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const mode = trigger.getAttribute('data-category-mode') || 'add';
        const title = categoryFormModal.querySelector('[data-category-modal-title]');
        const subtitle = categoryFormModal.querySelector('[data-category-modal-subtitle]');
        const submitLabel = categoryFormModal.querySelector('[data-category-submit-label]');
        const nameInput = categoryFormModal.querySelector('[data-category-input="name"]');
        const statusInput = categoryFormModal.querySelector('[data-category-input="status"]');
        const descriptionInput = categoryFormModal.querySelector('[data-category-input="description"]');

        if (mode === 'edit') {
          title.textContent = 'Edit Category';
          subtitle.textContent = 'Update the selected category details.';
          submitLabel.textContent = 'Update Category';
          nameInput.value = trigger.getAttribute('data-category-name') || '';
          statusInput.value = trigger.getAttribute('data-category-status') || 'Active';
          descriptionInput.value = trigger.getAttribute('data-category-description') || '';
          return;
        }

        title.textContent = 'Add Category';
        subtitle.textContent = 'Create a new category master for the catalog.';
        submitLabel.textContent = 'Save Category';
        nameInput.value = '';
        statusInput.value = 'Active';
        descriptionInput.value = '';
      });
    }

    if (categoryDeleteModal) {
      categoryDeleteModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const nameTarget = categoryDeleteModal.querySelector('[data-category-delete-name]');
        const productsTarget = categoryDeleteModal.querySelector('[data-category-delete-products]');

        nameTarget.textContent = trigger.getAttribute('data-category-name') || 'Category';
        productsTarget.textContent = trigger.getAttribute('data-category-products') || '0';
      });
    }
  }

  toggleButtons.forEach((btn) => btn.addEventListener('click', toggleSidebar));
  if (overlay) overlay.addEventListener('click', closeSidebar);

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      closeSidebar();
    }
  });

  setActiveMenu();
  initCategoryModals();
})();
