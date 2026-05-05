<?php $this->load->view('frontend/partials/header'); ?>

<section class="page-hero-shell">
    <div class="page-hero-banner">
        <div class="page-hero-media">
            <img src="<?php echo html_escape($category_hero['image']); ?>" alt="<?php echo html_escape($category_hero['title']); ?>">
        </div>
        <div class="page-hero-overlay"></div>

        <div class="page-hero-content">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo site_url('frontend'); ?>">Home</a>
                <span>/</span>
                <span aria-current="page">Categories</span>
            </nav>

            <div class="page-hero-copy">
                <div class="page-hero-kicker">Category Directory</div>
                <h1 class="page-hero-title"><?php echo html_escape($category_hero['title']); ?></h1>
                <p class="page-hero-subtitle"><?php echo html_escape($category_hero['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="category-page-layout">
        <aside class="category-filter-panel">
            <div class="category-filter-panel__sticky">
                <div class="category-filter-panel__header">
                    <div class="section-kicker">Refine Results</div>
                    <h2 class="section-title">Filters</h2>
                    <p class="section-copy">Narrow the catalog with simple commercial specs.</p>
                </div>

                <div class="category-filter-group">
                    <div class="category-filter-group__title">Size</div>
                    <label class="category-filter-option">
                        <input type="checkbox" name="size[]" value="small">
                        <span>Small</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="size[]" value="medium">
                        <span>Medium</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="size[]" value="large">
                        <span>Large</span>
                    </label>
                </div>

                <div class="category-filter-group">
                    <div class="category-filter-group__title">Color</div>
                    <label class="category-filter-option">
                        <input type="checkbox" name="color[]" value="black">
                        <span>Black</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="color[]" value="transparent">
                        <span>Transparent</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="color[]" value="silver">
                        <span>Silver</span>
                    </label>
                </div>

                <div class="category-filter-group">
                    <div class="category-filter-group__title">Thickness</div>
                    <label class="category-filter-option">
                        <input type="checkbox" name="thickness[]" value="light">
                        <span>Light Duty</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="thickness[]" value="standard">
                        <span>Standard</span>
                    </label>
                    <label class="category-filter-option">
                        <input type="checkbox" name="thickness[]" value="heavy">
                        <span>Heavy Duty</span>
                    </label>
                </div>

                <div class="category-filter-group">
                    <div class="category-filter-group__title">Price Range</div>
                    <input class="category-filter-range" type="range" min="100" max="5000" value="2500">
                    <div class="category-filter-range__labels">
                        <span>&#8377;100</span>
                        <strong>&#8377;2,500</strong>
                        <span>&#8377;5,000</span>
                    </div>
                </div>
            </div>
        </aside>

        <div class="category-page-content">
            <div class="section-heading">
                <div class="section-kicker">Product Grid</div>
                <h2 class="section-title">Explore the full product range</h2>
                <p class="section-copy">A modern catalog view with product visuals, key specs, pricing, and fast add-to-cart access.</p>
            </div>

            <div class="category-products-grid">
                <?php foreach ($category_products as $product): ?>
                    <article
                        class="category-product-card"
                        data-product-id="<?php echo (int) ($product['id'] ?? 0); ?>"
                        data-product-name="<?php echo html_escape($product['name']); ?>"
                        data-product-specs="<?php echo html_escape($product['specs']); ?>"
                        data-product-description="<?php echo html_escape($product['description']); ?>"
                        data-product-image="<?php echo html_escape($product['image']); ?>"
                    >
                        <div class="category-product-card__media">
                            <span class="category-product-card__badge">Industrial Supply</span>
                            <img src="<?php echo html_escape($product['image']); ?>" alt="<?php echo html_escape($product['name']); ?>">
                        </div>
                        <div class="category-product-card__body">
                            <h3 class="category-product-card__title"><?php echo html_escape($product['name']); ?></h3>
                            <p class="category-product-card__specs"><?php echo html_escape($product['specs']); ?></p>
                            <div class="category-product-card__footer">
                                <span class="category-product-card__enquiry">Available on enquiry</span>
                                <div class="category-product-card__actions">
                                    <button class="btn btn-outline-dark btn-sm" type="button" data-quick-view>Quick View</button>
                                    <a class="btn btn-primary btn-sm" href="<?php echo site_url('frontend/contact'); ?>">Send Enquiry</a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="category-cta-shell">
    <div class="category-cta-banner">
        <div>
            <div class="category-cta-banner__kicker">Bulk Orders</div>
            <h2 class="category-cta-banner__title">Need high-volume quantities, custom specs, or repeat supply support?</h2>
            <p class="category-cta-banner__copy">Share your quantity, application, and delivery city. We’ll respond with the right product options and a fast commercial quote.</p>
        </div>
        <div class="category-cta-banner__actions">
            <a class="btn btn-light btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Get Quote</a>
            <a class="btn btn-outline-light btn-lg" href="https://wa.me/919175141468" target="_blank" rel="noopener noreferrer">WhatsApp</a>
        </div>
    </div>
</section>

<div class="quick-view-modal" id="quickViewModal" aria-hidden="true">
    <div class="quick-view-modal__backdrop" data-quick-view-close></div>
    <div class="quick-view-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="quickViewTitle">
        <button class="quick-view-modal__close" type="button" aria-label="Close quick view" data-quick-view-close>
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="quick-view-modal__layout">
            <div class="quick-view-modal__media">
                <img src="" alt="" id="quickViewImage">
            </div>

            <div class="quick-view-modal__content">
                <div class="quick-view-modal__eyebrow">Quick View</div>
                <h2 class="quick-view-modal__title" id="quickViewTitle"></h2>
                <div class="quick-view-modal__specs" id="quickViewSpecs"></div>
                <p class="quick-view-modal__description" id="quickViewDescription"></p>

                <div class="quick-view-modal__actions">
                    <a class="btn btn-primary btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Send Enquiry</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function ($) {
    const modal = $('#quickViewModal');
    const image = $('#quickViewImage');
    const title = $('#quickViewTitle');
    const specs = $('#quickViewSpecs');
    const description = $('#quickViewDescription');

    function openQuickView(card) {
        image.attr('src', card.data('product-image') || '');
        image.attr('alt', card.data('product-name') || 'Product');
        title.text(card.data('product-name') || 'Product');
        specs.text(card.data('product-specs') || '');
        description.text(card.data('product-description') || '');

        modal.addClass('is-open').attr('aria-hidden', 'false');
        $('body').addClass('quick-view-open');
    }

    function closeQuickView() {
        modal.removeClass('is-open').attr('aria-hidden', 'true');
        $('body').removeClass('quick-view-open');
    }

    $(document).on('click', '[data-quick-view]', function () {
        openQuickView($(this).closest('.category-product-card'));
    });

    $(document).on('click', '[data-quick-view-close]', function () {
        closeQuickView();
    });

    $(document).on('keydown', function (event) {
        if (event.key === 'Escape' && modal.hasClass('is-open')) {
            closeQuickView();
        }
    });
})(jQuery);
</script>

<?php $this->load->view('frontend/partials/footer'); ?>
