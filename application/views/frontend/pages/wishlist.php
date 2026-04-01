<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Wishlist</div>
    <h1 class="section-title">Save products for later comparison</h1>
</div>

<div class="row g-3">
    <?php foreach ($items as $item): ?>
        <div class="col-md-6 col-xl-4">
            <div class="product-card">
                <div class="product-thumb d-flex flex-column justify-content-between">
                    <div class="product-photo">
                        <img src="<?php echo html_escape($item['image_url']); ?>" alt="<?php echo html_escape($item['name']); ?>">
                    </div>
                    <span class="product-pill"><?php echo html_escape($item['badge']); ?></span>
                    <div>
                        <div class="text-white-50 small"><?php echo html_escape($item['category']); ?></div>
                        <h3 class="h5 mt-1 mb-0"><?php echo html_escape($item['name']); ?></h3>
                    </div>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <span class="price"><?php echo html_escape($item['price']); ?></span>
                    <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-outline-dark" href="#">Remove</a>
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('frontend/product/' . $item['image']); ?>">View</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
