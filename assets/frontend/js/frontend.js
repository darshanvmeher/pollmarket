(function () {
  //const WISHLIST_KEY = 'pollmarket_wishlist';
  const navToggler = document.querySelector('[data-nav-toggle]');
  const navCollapse = document.getElementById('siteNav');
  const quantityButtons = document.querySelectorAll('[data-qty-action]');
  const wishlistBadge = document.querySelector('[data-wishlist-badge]');
  const wishlistGrid = document.querySelector('[data-wishlist-grid]');
  const wishlistEmpty = document.querySelector('[data-wishlist-empty]');
  const wishlistTemplate = document.getElementById('wishlist-card-template');
  const productBase = document.body ? document.body.getAttribute('data-product-base') || '' : '';
  const galleryMain = document.querySelector('[data-product-gallery-main]');
  const galleryThumbs = document.querySelectorAll('[data-product-gallery-thumb]');

  /*const readWishlist = () => {
    try {
      return JSON.parse(localStorage.getItem(WISHLIST_KEY) || '[]');
    } catch (error) {
      return [];
    }
  };

  const writeWishlist = (items) => {
    localStorage.setItem(WISHLIST_KEY, JSON.stringify(items));
  };

  const syncWishlistBadge = () => {
    if (!wishlistBadge) return;

    const count = readWishlist().length;
    wishlistBadge.textContent = count;
    wishlistBadge.classList.toggle('d-none', count === 0);
    wishlistBadge.style.display = count === 0 ? 'none' : 'inline-flex';
  };

  const upsertWishlistItem = (button) => {
    const item = {
      id: button.getAttribute('data-product-id'),
      name: button.getAttribute('data-product-name'),
      category: button.getAttribute('data-product-category'),
      price: button.getAttribute('data-product-price'),
      image: button.getAttribute('data-product-image')
    };

    if (!item.id) return;

    const wishlist = readWishlist();
    const exists = wishlist.some((entry) => entry.id === item.id);
    if (!exists) {
      wishlist.push(item);
      writeWishlist(wishlist);
    }

    syncWishlistBadge();
  };

  const removeWishlistItem = (id) => {
    const wishlist = readWishlist().filter((item) => item.id !== id);
    writeWishlist(wishlist);
    syncWishlistBadge();
    renderWishlistGrid();
  };

  const renderWishlistGrid = () => {
    if (!wishlistGrid || !wishlistTemplate) return;

    const items = readWishlist();
    const fragment = document.createDocumentFragment();

    wishlistGrid.querySelectorAll('[data-wishlist-rendered]').forEach((node) => node.remove());

    if (wishlistEmpty) {
      wishlistEmpty.style.display = items.length ? 'none' : '';
    }

    items.forEach((item) => {
      const node = wishlistTemplate.content.cloneNode(true);
      const wrapper = node.querySelector('.col-md-6, .col-xl-4');
      const image = node.querySelector('img');
      const pill = node.querySelector('.product-pill');
      const category = node.querySelector('.text-white-50.small');
      const name = node.querySelector('h3');
      const price = node.querySelector('.price');
      const removeButton = node.querySelector('[data-wishlist-remove]');
      const viewLink = node.querySelector('.btn.btn-primary');

      if (wrapper) wrapper.setAttribute('data-wishlist-rendered', 'true');
      if (image) {
        image.src = item.image || '';
        image.alt = item.name || 'Wishlist product';
      }
      if (pill) pill.textContent = 'Saved';
      if (category) category.textContent = item.category || '';
      if (name) name.textContent = item.name || '';
      if (price) price.textContent = item.price || '';
      if (removeButton) removeButton.setAttribute('data-product-id', item.id || '');
      if (viewLink) viewLink.href = item.id ? `${productBase}${item.id}` : '#';

      fragment.appendChild(node);
    });

    wishlistGrid.appendChild(fragment);
  };*/

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

  //document.addEventListener('click', (event) => {
    //const addButton = event.target.closest('[data-wishlist-add]');
    //const removeButton = event.target.closest('[data-wishlist-remove]');

    /*if (addButton) {
      event.preventDefault();
      upsertWishlistItem(addButton);
    }

    if (removeButton) {
      event.preventDefault();
      removeWishlistItem(removeButton.getAttribute('data-product-id'));
      const card = removeButton.closest('.col-md-6, .col-xl-4, .product-card');
      if (card && card.classList.contains('col-md-6')) {
        card.remove();
      } else if (card && card.classList.contains('col-xl-4')) {
        card.remove();
      } else if (card && card.classList.contains('product-card')) {
        const wrapper = removeButton.closest('.col-md-6, .col-xl-4');
        if (wrapper) wrapper.remove();
      }
    }*/
  });

  galleryThumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      if (!galleryMain) return;
      const src = thumb.getAttribute('data-gallery-src');
      if (!src) return;

      galleryMain.src = src;
      galleryThumbs.forEach((item) => item.classList.remove('active'));
      thumb.classList.add('active');
    });
  });

 // syncWishlistBadge();
  //renderWishlistGrid();


