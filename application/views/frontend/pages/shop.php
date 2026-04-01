<?php $this->load->view('frontend/partials/header'); ?>

<section class="mb-4">
    <div class="section-heading">
        <div class="section-kicker">Shop</div>
        <h1 class="section-title">Browse every product with an easy filter-first layout</h1>
        <p class="section-copy">Built for fast product discovery across packaging, stationery, and security supplies.</p>
    </div>
    <div class="chip-row mb-4">
        <?php foreach ($categories as $index => $category): ?>
            <a class="chip <?php echo $index === 0 ? 'active' : ''; ?>" href="#"><?php echo html_escape($category); ?></a>
        <?php endforeach; ?>
    </div>
    <div class="row g-3">
        <div class="col-lg-3">
            <div class="surface-card p-3">
                <h2 class="h6 fw-bold">Filters</h2>
                <label class="form-label mt-2">Category</label>
                <select class="form-select"><option>All</option><option>Plastic Bags</option><option>Stationery</option></select>
                <label class="form-label mt-3">Price Range</label>
                <input class="form-range" type="range">
                <label class="form-label mt-3">Sort</label>
                <select class="form-select"><option>Featured</option><option>Price Low to High</option><option>Newest</option></select>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row g-3">
                <?php foreach ($products as $index => $product): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="product-card">
                            <div class="product-thumb d-flex flex-column justify-content-between">
                                <div class="product-photo">
                                    <img src="<?php echo html_escape($product['image_url']); ?>" alt="<?php echo html_escape($product['name']); ?>">
                                </div>
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="product-pill"><?php echo html_escape($product['badge']); ?></span>
                                    <span class="product-pill"><i class="bi bi-star-fill"></i> <?php echo html_escape($product['rating']); ?></span>
                                </div>
                                <div>
                                    <div class="text-white-50 small"><?php echo html_escape($product['category']); ?></div>
                                    <h3 class="h5 mt-1 mb-0"><?php echo html_escape($product['name']); ?></h3>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price"><?php echo html_escape($product['price']); ?></span>
                                        <span class="price-old ms-2"><?php echo html_escape($product['old_price']); ?></span>
                                    </div>
                                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('frontend/product/' . $product['image']); ?>">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
