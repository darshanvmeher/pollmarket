<?php $this->load->view('frontend/partials/header'); ?>

<section class="row g-4 align-items-start">
    <div class="col-lg-6">
        <div class="hero-media" style="min-height: 520px;">
            <div class="card-stack">
                <div class="hero-aside-card" style="padding:0; overflow:hidden;">
                    <img src="<?php echo html_escape($product['image_url'] ?? ''); ?>" alt="<?php echo html_escape($product['name']); ?>" style="width:100%; height:240px; object-fit:cover; display:block;">
                </div>
                <div class="mini-stat">
                    <span class="text-white-50">Product</span>
                    <strong><?php echo html_escape($product['name']); ?></strong>
                    <small class="text-white-50"><?php echo html_escape($product['category']); ?></small>
                </div>
                <div class="mini-stat">
                    <span class="text-white-50">Quick View</span>
                    <strong><?php echo html_escape($product['rating']); ?> rating</strong>
                    <small class="text-white-50"><?php echo html_escape($product['stock']); ?></small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="surface-card p-4">
            <div class="eyebrow"><i class="bi bi-bag-check"></i> Product detail</div>
            <h1 class="section-title"><?php echo html_escape($product['name']); ?></h1>
            <p class="text-muted"><?php echo html_escape($product['description']); ?></p>
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="price"><?php echo html_escape($product['price']); ?></span>
                <span class="price-old"><?php echo html_escape($product['old_price']); ?></span>
                <span class="rating"><i class="bi bi-star-fill"></i> <?php echo html_escape($product['rating']); ?></span>
            </div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="soft-badge"><i class="bi bi-truck"></i> Dispatch 24 hrs</span>
                <span class="soft-badge"><i class="bi bi-shield-check"></i> Quality checked</span>
            </div>
            <div class="input-group mb-3" style="max-width: 220px;">
                <button class="btn btn-outline-dark" type="button" data-qty-action="decrease" data-qty-target="#qty">-</button>
                <input id="qty" class="form-control text-center" value="1">
                <button class="btn btn-outline-dark" type="button" data-qty-action="increase" data-qty-target="#qty">+</button>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-lg">Add to Cart</button>
                <button class="btn btn-outline-dark btn-lg"><i class="bi bi-suit-heart"></i></button>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="section-heading">
        <div class="section-kicker">Related</div>
        <h2 class="section-title">Products customers usually buy together</h2>
    </div>
    <div class="row g-3">
        <?php foreach ($related_products as $product_item): ?>
            <div class="col-md-6 col-xl-3">
                <div class="product-card">
                    <div class="product-thumb d-flex flex-column justify-content-between">
                        <span class="product-pill"><?php echo html_escape($product_item['badge']); ?></span>
                        <div>
                            <div class="text-white-50 small"><?php echo html_escape($product_item['category']); ?></div>
                            <h3 class="h5 mt-1 mb-0"><?php echo html_escape($product_item['name']); ?></h3>
                        </div>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center">
                        <span class="price"><?php echo html_escape($product_item['price']); ?></span>
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('frontend/product/' . $product_item['image']); ?>">View</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
