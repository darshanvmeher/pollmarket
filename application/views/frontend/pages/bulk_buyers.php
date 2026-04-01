<?php $this->load->view('frontend/partials/header'); ?>

<section class="bulk-hero hero-section">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-7">
            <div class="hero-card bulk-hero-card fade-up">
                <div class="eyebrow"><i class="bi bi-building-check"></i> Bulk buyers & procurement</div>
                <h1 class="hero-title"><?php echo html_escape($hero['title']); ?></h1>
                <p class="hero-copy"><?php echo html_escape($hero['subtitle']); ?></p>
                <div class="bulk-hero-points mt-4">
                    <div class="bulk-point"><i class="bi bi-check2-circle"></i> GST-ready business invoices</div>
                    <div class="bulk-point"><i class="bi bi-truck"></i> Pan-India fulfillment support</div>
                    <div class="bulk-point"><i class="bi bi-bag-check"></i> Volume-based pricing tiers</div>
                    <div class="bulk-point"><i class="bi bi-clock-history"></i> Fast repeat ordering</div>
                </div>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a class="btn btn-primary btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Request a Quote</a>
                    <a class="btn btn-outline-dark btn-lg" href="<?php echo site_url('frontend/shop'); ?>">Browse Catalog</a>
                </div>
                <div class="hero-badges mt-4">
                    <span class="soft-badge"><i class="bi bi-people"></i> Dedicated account support</span>
                    <span class="soft-badge"><i class="bi bi-receipt"></i> Procurement-friendly billing</span>
                    <span class="soft-badge"><i class="bi bi-box-seam"></i> Multi-category supply</span>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="bulk-summary-panel fade-up delay-1">
                <div class="section-kicker text-white">Quick snapshot</div>
                <h2 class="h3 text-white mb-3">Designed for frequent reordering and larger supply cycles</h2>
                <div class="row g-2">
                    <?php foreach ($cta_stats as $stat): ?>
                        <div class="col-4">
                            <div class="bulk-stat">
                                <span><?php echo html_escape($stat['label']); ?></span>
                                <strong><?php echo html_escape($stat['value']); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="bulk-quote mt-3">
                    <div class="fw-bold mb-1">Best fit for</div>
                    <p class="mb-0 text-white-50">Wholesalers, retailers, distributors, offices, kitchens, and logistics teams buying packaging and essentials in volume.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Why buyers choose us</div>
        <h2 class="section-title">Built for procurement teams that need speed, clarity, and predictable supply</h2>
    </div>
    <div class="row g-3">
        <?php foreach ($benefits as $benefit): ?>
            <div class="col-md-4">
                <div class="info-card h-100 bulk-benefit-card">
                    <div class="bulk-benefit-icon"><i class="bi bi-check2"></i></div>
                    <div class="fw-bold mb-2"><?php echo html_escape($benefit['title']); ?></div>
                    <p class="text-muted mb-0"><?php echo html_escape($benefit['copy']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="row g-4 align-items-stretch">
        <div class="col-lg-6">
            <div class="portfolio-panel h-100">
                <div class="section-kicker">How it works</div>
                <h2 class="section-title">A simple flow for bulk purchase conversations</h2>
                <div class="d-grid gap-3 mt-3">
                    <?php foreach ($bulk_steps as $index => $step): ?>
                        <div class="step-card">
                            <div class="step-number"><?php echo html_escape($index + 1); ?></div>
                            <div>
                                <div class="fw-bold"><?php echo html_escape($step['title']); ?></div>
                                <p class="text-muted mb-0"><?php echo html_escape($step['copy']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portfolio-panel h-100">
                <div class="section-kicker">Trust signals</div>
                <h2 class="section-title">What makes procurement easier for your team</h2>
                <div class="row g-3 mt-1">
                    <?php foreach ($trust_points as $point): ?>
                        <div class="col-md-6">
                            <div class="trust-card">
                                <div class="fw-bold mb-1"><?php echo html_escape($point['title']); ?></div>
                                <p class="text-muted mb-0"><?php echo html_escape($point['copy']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Popular bundles</div>
        <h2 class="section-title">Common bulk order combinations we can quote faster</h2>
        <p class="section-copy">These starter bundles make it easier for teams to request a packaged quote and compare categories together.</p>
    </div>
    <div class="row g-3">
        <?php foreach ($bulk_bundles as $bundle): ?>
            <div class="col-md-6 col-xl-3">
                <div class="bundle-card h-100">
                    <div class="bundle-photo">
                        <img src="<?php echo html_escape($bundle['image']); ?>" alt="<?php echo html_escape($bundle['title']); ?>">
                    </div>
                    <div class="p-3">
                        <div class="fw-bold mb-1"><?php echo html_escape($bundle['title']); ?></div>
                        <p class="text-muted mb-0"><?php echo html_escape($bundle['copy']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Client Logos</div>
        <h2 class="section-title">Trusted by wholesalers, distributors, and retail chains</h2>
    </div>
    <div class="row g-3">
        <?php foreach ($client_logos as $client_logo): ?>
            <div class="col-6 col-md-3">
                <div class="logo-card">
                    <div class="logo-mark"><?php echo html_escape(substr($client_logo['name'], 0, 1)); ?></div>
                    <div class="fw-bold mt-3"><?php echo html_escape($client_logo['name']); ?></div>
                    <div class="text-muted small"><?php echo html_escape($client_logo['tag']); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="bulk-cta surface-card p-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="section-kicker">Ready to quote</div>
                <h2 class="section-title mb-2">Need a bulk quote for your business or distribution network?</h2>
                <p class="section-copy mb-0">Share your quantity, delivery city, and category mix, and we will prepare a procurement-friendly quote for Poll Market Solutions.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="btn btn-primary btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
