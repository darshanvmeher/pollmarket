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

  function initCouponModals() {
    const couponFormModal = document.getElementById('couponFormModal');
    const couponDeleteModal = document.getElementById('couponDeleteModal');

    if (couponFormModal) {
      couponFormModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const mode = trigger.getAttribute('data-coupon-mode') || 'add';
        const title = couponFormModal.querySelector('[data-coupon-modal-title]');
        const subtitle = couponFormModal.querySelector('[data-coupon-modal-subtitle]');
        const submitLabel = couponFormModal.querySelector('[data-coupon-submit-label]');
        const codeInput = couponFormModal.querySelector('[data-coupon-input="code"]');
        const typeInput = couponFormModal.querySelector('[data-coupon-input="type"]');
        const discounttypeInput = couponFormModal.querySelector('[data-coupon-input="discount_type"]');
        const discountvalueInput = couponFormModal.querySelector('[data-coupon-input="discount_value"]')
        const validityInput = couponFormModal.querySelector('[data-coupon-input="validity"]');
        const statusInput = couponFormModal.querySelector('[data-coupon-input="status"]');
        const descriptionInput = couponFormModal.querySelector('[data-coupon-input="description"]');

        if (mode === 'edit') {
          title.textContent = 'Edit Coupon';
          subtitle.textContent = 'Update coupon code settings.';
          submitLabel.textContent = 'Update Coupon';
          codeInput.value = trigger.getAttribute('data-coupon-code') || '';
          typeInput.value = trigger.getAttribute('data-coupon-type') || 'Order Value';
          discounttypeInput.value = trigger.getAttribute('data-coupon-discount_type') || '';
           discountvalueInput.value = trigger.getAttribute('data-coupon-discount_value') || '';
          validityInput.value = trigger.getAttribute('data-coupon-validity') || '';
          statusInput.value = trigger.getAttribute('data-coupon-status') || 'Active';
          descriptionInput.value = trigger.getAttribute('data-coupon-description') || '';
          return;
        }

        title.textContent = 'Add Coupon';
        subtitle.textContent = 'Create a new coupon code for promotions.';
        submitLabel.textContent = 'Save Coupon';
        codeInput.value = '';
        typeInput.value = 'Order Value';
        discounttypeInput.value = '';
        discountvalueInput.value = '';
        validityInput.value = '';
        statusInput.value = 'Active';
        descriptionInput.value = '';
      });
    }

    if (couponDeleteModal) {
      couponDeleteModal.addEventListener('show.bs.modal', (event) => {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const codeTarget = couponDeleteModal.querySelector('[data-coupon-delete-code]');
        const usageTarget = couponDeleteModal.querySelector('[data-coupon-delete-usage]');

        codeTarget.textContent = trigger.getAttribute('data-coupon-code') || 'Coupon';
        usageTarget.textContent = trigger.getAttribute('data-coupon-usage') || '0';
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
  initCouponModals();
})();
