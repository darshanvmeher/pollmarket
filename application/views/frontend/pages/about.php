<?php $this->load->view('frontend/partials/header'); ?>
<?php
$about_showcase = array(
    array(
        'title' => 'Garbage Bags',
        'image' => base_url('assets/frontend/images/products/garbage-bag.jpg')
    ),
    array(
        'title' => 'Cling Film',
        'image' => base_url('assets/frontend/images/products/cling-film.jpg')
    ),
    array(
        'title' => 'PP Bags',
        'image' => base_url('assets/frontend/images/products/paper-bag.jpg')
    ),
    array(
        'title' => 'Packaging Materials',
        'image' => base_url('assets/frontend/images/products/silver-foil.jpg')
    )
);
?>

<section class="page-hero-shell">
    <div class="page-hero-banner">
        <div class="page-hero-media">
            <img src="<?php echo html_escape($about_hero['image']); ?>" alt="<?php echo html_escape($about_hero['title']); ?>">
        </div>
        <div class="page-hero-overlay"></div>

        <div class="page-hero-content">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="<?php echo site_url('frontend'); ?>">Home</a>
                <span>/</span>
                <span aria-current="page">About Us</span>
            </nav>

            <div class="page-hero-copy">
                <div class="page-hero-kicker">About Us</div>
                <h1 class="page-hero-title"><?php echo html_escape($about_hero['title']); ?></h1>
                <p class="page-hero-subtitle"><?php echo html_escape($about_hero['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="who-we-are-panel">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="section-heading mb-0">
                    <div class="section-kicker">Who We Are</div>
                    <h2 class="section-title">Reliable packaging manufacturing backed by practical industry experience</h2>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="who-we-are-copy">
                    <p>Pollmarket Solutions is a trusted manufacturer of garbage bags, cling film, PP bags, and packaging materials. Based in Bhiwandi, Maharashtra, we specialize in delivering durable, hygienic, and customizable solutions for businesses and households.</p>
                    <p class="mb-0">We combine quality materials, modern production techniques, and customer-focused service to meet growing packaging demands across industries.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="mission-vision-card">
                <div class="mission-vision-card__icon">
                    <i class="bi bi-bullseye"></i>
                </div>
                <div class="section-kicker">Mission</div>
                <h2 class="mission-vision-card__title">Deliver reliable packaging solutions with practical value</h2>
                <p class="mission-vision-card__copy">To provide high-quality, reliable, and cost-effective packaging solutions that ensure hygiene, safety, and convenience.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="mission-vision-card">
                <div class="mission-vision-card__icon">
                    <i class="bi bi-eye"></i>
                </div>
                <div class="section-kicker">Vision</div>
                <h2 class="mission-vision-card__title">Build a trusted packaging brand for the long term</h2>
                <p class="mission-vision-card__copy">To become a leading packaging brand known for innovation, sustainability, and customer trust.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Core Strengths</div>
        <h2 class="section-title">Five practical reasons businesses work with Pollmarket</h2>
    </div>
    <div class="about-feature-grid">
        <div class="about-feature-card">
            <div class="about-feature-card__icon"><i class="bi bi-box-seam"></i></div>
            <h3 class="about-feature-card__title">Bulk Supply</h3>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-card__icon"><i class="bi bi-sliders"></i></div>
            <h3 class="about-feature-card__title">Custom Sizes</h3>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-card__icon"><i class="bi bi-shield-check"></i></div>
            <h3 class="about-feature-card__title">Reliable Quality</h3>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-card__icon"><i class="bi bi-truck"></i></div>
            <h3 class="about-feature-card__title">Fast Delivery</h3>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-card__icon"><i class="bi bi-people"></i></div>
            <h3 class="about-feature-card__title">Client Support</h3>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Industries Served</div>
        <h2 class="section-title">Supporting packaging needs across everyday commercial environments</h2>
    </div>
    <div class="industries-served-grid">
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-shop"></i></div>
            <h3 class="industries-served-card__title">Retail Stores</h3>
        </article>
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-boxes"></i></div>
            <h3 class="industries-served-card__title">Warehousing</h3>
        </article>
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-basket"></i></div>
            <h3 class="industries-served-card__title">Food Packaging</h3>
        </article>
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-building"></i></div>
            <h3 class="industries-served-card__title">Corporate Supply</h3>
        </article>
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-truck"></i></div>
            <h3 class="industries-served-card__title">Logistics</h3>
        </article>
        <article class="industries-served-card">
            <div class="industries-served-card__icon"><i class="bi bi-house-check"></i></div>
            <h3 class="industries-served-card__title">Household Use</h3>
        </article>
    </div>
</section>

<section class="py-4">
    <div class="about-cta-banner">
        <div>
            <div class="section-kicker text-white">Ready to Connect?</div>
            <h2 class="about-cta-banner__title">Let’s plan the right packaging solution for your business requirements.</h2>
        </div>
        <div class="about-cta-banner__actions">
            <a class="btn btn-light btn-lg" href="<?php echo site_url('frontend/contact'); ?>">Get Quote</a>
            <a class="btn btn-outline-light btn-lg" href="https://wa.me/919175141468" target="_blank" rel="noopener noreferrer">WhatsApp</a>
            <a class="btn btn-outline-light btn-lg" href="<?php echo site_url('frontend/categories'); ?>">View Categories</a>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Product Showcase</div>
        <h2 class="section-title">Built around practical packaging lines for everyday supply needs</h2>
    </div>
    <div class="about-showcase-grid">
        <?php foreach ($about_showcase as $index => $item): ?>
            <article class="about-showcase-card fade-up delay-<?php echo min($index + 1, 3); ?>">
                <div class="about-showcase-card__media">
                    <img src="<?php echo html_escape($item['image']); ?>" alt="<?php echo html_escape($item['title']); ?>">
                </div>
                <div class="about-showcase-card__overlay"></div>
                <div class="about-showcase-card__title"><?php echo html_escape($item['title']); ?></div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="py-4">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="info-card">
                <div class="fw-bold mb-1">Wholesale first</div>
                <p class="text-muted mb-0">Designed around repeat purchasing and bulk-friendly product ranges for Indian buyers.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="fw-bold mb-1">Operational clarity</div>
                <p class="text-muted mb-0">Pricing in INR, stock cues, and categories are front and center.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="fw-bold mb-1">Trusted sourcing</div>
                <p class="text-muted mb-0">Made for products like RFID seals, foil rolls, and paper packaging.</p>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
