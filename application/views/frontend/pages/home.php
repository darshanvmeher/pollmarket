<?php $this->load->view('frontend/partials/header'); ?>

<section class="hero-section hero-lite">
    <div class="row align-items-center g-4">
        <div class="col-lg-6">
            <div class="hero-card fade-up">
                <div class="eyebrow"><i class="bi bi-stars"></i> India-focused wholesale storefront</div>
                <h1 class="hero-title"><?php echo html_escape($hero['title']); ?></h1>
                <p class="hero-copy"><?php echo html_escape($hero['subtitle']); ?></p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a class="btn btn-primary btn-lg" href="<?php echo site_url('frontend/shop'); ?>">Shop Products</a>
                    <a class="btn btn-outline-dark btn-lg" href="<?php echo site_url('frontend/bulk-buyers'); ?>">Bulk Buyers</a>
                </div>
                <div class="hero-product-tags mt-4">
                    <span class="hero-tag">Garbage bags</span>
                    <span class="hero-tag">Paper bags</span>
                    <span class="hero-tag">Cling films</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hero-gallery fade-up delay-1">
                <div class="hero-gallery-main">
                    <img src="<?php echo html_escape($hero_scene['warehouse']); ?>" alt="Indian warehouse supply">
                </div>
                <div class="hero-gallery-side">
                    <div class="hero-gallery-tile">
                        <img src="<?php echo html_escape($hero_scene['office']); ?>" alt="Indian business procurement team">
                    </div>
                    <div class="hero-gallery-tile">
                        <img src="<?= base_url($hero_products[0]['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                            alt="<?= html_escape($hero_products[0]['product_name'] ?? 'Product') ?>">
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="trust-strip compact-strip">
        <div class="client-badge">
            <div class="text-muted small">Fast-moving categories</div>
            <div class="client-kpi">4 core lines</div>
        </div>
        <div class="client-badge">
            <div class="text-muted small">India-ready service</div>
            <div class="client-kpi">GST billing</div>
        </div>
        <div class="client-badge">
            <div class="text-muted small">Bulk orders</div>
            <div class="client-kpi">Wholesale friendly</div>
        </div>
        <div class="client-badge">
            <div class="text-muted small">Dispatch focus</div>
            <div class="client-kpi">Quick turnaround</div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading d-flex justify-content-between align-items-end gap-3 flex-wrap">
        <div>
            <div class="section-kicker">Shop by category</div>
            <h2 class="section-title">Simple, visual, and product-first</h2>
        </div>
        <a class="btn btn-outline-dark" href="<?php echo site_url('frontend/categories'); ?>">View categories</a>
    </div>
    <div class="row g-3">
        <?php foreach ($featured_categories as $index => $category): ?>
            <div class="col-6 col-lg-3">
                <div class="category-tile fade-up delay-<?php echo min($index + 1, 3); ?>">
                    <div class="category-tile-label"><?php echo html_escape($category['label']); ?></div>
                    <div class="category-tile-count"><?php echo html_escape($category['count']); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Featured products</div>
        <h2 class="section-title">A quick look at the catalog</h2>
    </div>
    <div class="row g-3">
        <?php foreach ($featured_products as $index => $product): ?>
                    <div class="col-md-6 col-xl-3 d-flex">
                    <div class="product-card fade-up delay-<?php echo min($index + 1, 3); ?>">
                    <div class="product-thumb d-flex flex-column justify-content-between">
                        <div class="product-photo">
                            <img src="<?= base_url($product['media'][0]['media_path'] ?? 'assets/no-image.png') ?>">
                        </div>
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="product-pill"><?php echo html_escape($product['badge']); ?></span>
                            <span class="product-pill"><i class="bi bi-star-fill"></i> <?php echo html_escape($product['rating']); ?></span>
                        </div>
                        <div>
                            <div class="text-white-50 small"><?php echo html_escape($product['category_name']); ?></div>
                            <h3 class="h5 mt-1 mb-0"><?php echo html_escape($product['product_name']); ?></h3>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="price"><?php echo html_escape($product['price']); ?></span>
                                <span class="price-old ms-2"><?php echo html_escape($product['strike_price']); ?></span>
                            </div>
                            <a class="btn btn-sm btn-primary" href="<?php echo site_url('frontend/product/' . $product['id']); ?>">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Quick picks</div>
        <h2 class="section-title">Best fit for daily business buying</h2>
    </div>
    <div class="row g-3">
        <?php foreach ($industries as $industry): ?>
            <div class="col-md-6 col-lg-3">
                <div class="use-card use-card-compact">
                    <div class="industry-accent industry-accent-<?php echo html_escape($industry['accent']); ?>"></div>
                    <div>
                        <div class="fw-bold"><?php echo html_escape($industry['title']); ?></div>
                        <p class="text-muted mb-0"><?php echo html_escape($industry['copy']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="brand-banner brand-banner-compact fade-up">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="eyebrow text-white"><i class="bi bi-geo-alt"></i> Built for India</div>
                <h2 class="display-6 fw-bold text-white mb-2">Clean, modern, and ready for bulk buying.</h2>
                <p class="text-white-50 mb-0">Short copy, stronger visuals, and faster product discovery.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="btn btn-light btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Talk to Sales</a>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
