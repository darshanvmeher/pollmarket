<?php $this->load->view('frontend/partials/header'); ?>
<?php
$hero_collage = array(
    array(
        'title' => 'Garbage Bags',
        'copy' => 'Heavy-duty liners for warehouses, retail, and facility ops.',
        'image' => base_url('assets/frontend/images/products/garbage-bag.jpg'),
        'tone' => 'primary'
    ),
    array(
        'title' => 'Cling Film',
        'copy' => 'Food-safe wrap and dispatch-ready packaging rolls.',
        'image' => base_url('assets/frontend/images/products/cling-film.jpg'),
        'tone' => 'steel'
    ),
    array(
        'title' => 'RFID Seals',
        'copy' => 'Industrial control, traceability, and tamper security.',
        'image' => base_url('assets/frontend/images/products/rfid-seal.jpg'),
        'tone' => 'accent'
    )
);
?>

<section class="hero-industrial-shell">
    <div class="hero-industrial-grid">
        <div class="hero-industrial-copy fade-up">
            <div class="hero-industrial-kicker">
                <span class="hero-industrial-dot"></span>
                Industrial Packaging Supply
            </div>
            <h1 class="hero-industrial-title">Premium packaging essentials for fast-moving industrial buying.</h1>
            <p class="hero-industrial-copy-text">Source garbage bags, cling film, RFID seals, and business-ready consumables from a storefront designed for procurement teams, plant operators, and repeat wholesale ordering.</p>

            <div class="hero-industrial-cta">
                <a class="btn btn-primary btn-lg" href="<?php echo site_url('frontend/shop'); ?>">Explore Catalog</a>
                <a class="btn btn-outline-light btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Talk to Sales</a>
            </div>

            <div class="hero-industrial-metrics">
                <div class="hero-industrial-metric">
                    <span>Dispatch-ready SKUs</span>
                    <strong>250+</strong>
                </div>
                <div class="hero-industrial-metric">
                    <span>Industrial segments</span>
                    <strong>Retail to logistics</strong>
                </div>
                <div class="hero-industrial-metric">
                    <span>Service layer</span>
                    <strong>GST and bulk billing</strong>
                </div>
            </div>

            <div class="hero-industrial-tags">
                <span class="hero-industrial-tag">Garbage bags</span>
                <span class="hero-industrial-tag">Cling film</span>
                <span class="hero-industrial-tag">RFID seals</span>
                <span class="hero-industrial-tag">Premium industrial supply</span>
            </div>
        </div>

        <div class="hero-industrial-visual fade-up delay-1">
            <div class="hero-industrial-collage">
                <div class="hero-industrial-panel">
                    <div class="hero-industrial-panel__eyebrow">Industrial Range</div>
                    <h2>Made for procurement teams that need speed, consistency, and clean presentation.</h2>
                </div>

                <article class="hero-industrial-card hero-industrial-card-main">
                    <div class="hero-industrial-card__media">
                        <img src="<?php echo html_escape($hero_collage[0]['image']); ?>" alt="<?php echo html_escape($hero_collage[0]['title']); ?>">
                    </div>
                    <div class="hero-industrial-card__overlay"></div>
                    <div class="hero-industrial-card__content">
                        <div class="hero-industrial-card__eyebrow">Bulk utility</div>
                        <h2><?php echo html_escape($hero_collage[0]['title']); ?></h2>
                        <p><?php echo html_escape($hero_collage[0]['copy']); ?></p>
                    </div>
                </article>

                <div class="hero-industrial-card-stack">
                    <article class="hero-industrial-card hero-industrial-card-secondary">
                        <div class="hero-industrial-card__media">
                            <img src="<?php echo html_escape($hero_collage[1]['image']); ?>" alt="<?php echo html_escape($hero_collage[1]['title']); ?>">
                        </div>
                        <div class="hero-industrial-card__overlay"></div>
                        <div class="hero-industrial-card__content">
                            <div class="hero-industrial-card__eyebrow">Food and retail wrap</div>
                            <h2><?php echo html_escape($hero_collage[1]['title']); ?></h2>
                            <p><?php echo html_escape($hero_collage[1]['copy']); ?></p>
                        </div>
                    </article>

                    <article class="hero-industrial-card hero-industrial-card-secondary">
                        <div class="hero-industrial-card__media">
                            <img src="<?php echo html_escape($hero_collage[2]['image']); ?>" alt="<?php echo html_escape($hero_collage[2]['title']); ?>">
                        </div>
                        <div class="hero-industrial-card__overlay"></div>
                        <div class="hero-industrial-card__content">
                            <div class="hero-industrial-card__eyebrow">Secure tracking</div>
                            <h2><?php echo html_escape($hero_collage[2]['title']); ?></h2>
                            <p><?php echo html_escape($hero_collage[2]['copy']); ?></p>
                        </div>
                    </article>
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
            <h2 class="section-title">Large visual lanes for fast category discovery</h2>
        </div>
        <a class="btn btn-outline-dark" href="<?php echo site_url('frontend/categories'); ?>">View categories</a>
    </div>
    <div class="category-showcase-grid">
        <?php foreach ($featured_categories as $index => $category): ?>
            <a
                class="category-showcase-card fade-up delay-<?php echo min($index + 1, 3); ?>"
                href="<?php echo html_escape($category['url']); ?>"
            >
                <div class="category-showcase-card__media">
                    <img src="<?php echo html_escape($category['image']); ?>" alt="<?php echo html_escape($category['label']); ?>">
                </div>
                <div class="category-showcase-card__overlay"></div>
                <div class="category-showcase-card__content">
                    <div class="category-showcase-card__label"><?php echo html_escape($category['label']); ?></div>
                    <div class="category-showcase-card__count"><?php echo html_escape($category['count']); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Why Choose Us</div>
        <h2 class="section-title">Built for practical, high-volume business supply</h2>
        <p class="section-copy">Clear strengths that matter when customers compare industrial packaging partners.</p>
    </div>
    <div class="why-choose-grid">
        <?php foreach ($why_choose_us as $index => $feature): ?>
            <article class="why-choose-card fade-up delay-<?php echo min($index + 1, 3); ?>">
                <div class="why-choose-card__icon">
                    <i class="bi <?php echo html_escape($feature['icon']); ?>"></i>
                </div>
                <h3 class="why-choose-card__title"><?php echo html_escape($feature['title']); ?></h3>
                <p class="why-choose-card__copy"><?php echo html_escape($feature['copy']); ?></p>
            </article>
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
                                <span class="price">₹<?php echo html_escape($product['price']); ?></span>
                                <span class="price-old ms-2">₹<?php echo html_escape($product['strike_price']); ?></span>
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
