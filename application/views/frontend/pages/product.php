<?php $this->load->view('frontend/partials/header'); ?>

<section class="row g-4 align-items-start">
    <div class="col-lg-6">
        <div class="product-gallery surface-card p-3 p-lg-4">
            <div class="product-gallery-main">
                <img
                   
                src="<?= base_url($product['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                alt="<?= html_escape($product['product_name']) ?>"
                    data-product-gallery-main>
            </div>
            <div class="product-gallery-thumbs mt-3">
                 <?php foreach (($product['media'] ?? []) as $index => $media): ?>
    <button
        class="product-gallery-thumb <?= $index === 0 ? 'active' : ''; ?>"
        type="button"
        data-product-gallery-thumb
        data-gallery-src="<?= base_url($media['media_path']); ?>"
        aria-label="View image <?= $index + 1; ?>">

        <img src="<?= base_url($media['media_path']); ?>"
             alt="<?= html_escape($product['product_name']); ?> image <?= $index + 1; ?>">
    </button>
<?php endforeach; ?>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="mini-stat">
                        <span class="text-white-50">Product</span>
                        <strong><?php echo html_escape($product['product_name']); ?></strong>
                        <small class="text-white-50"><?php echo html_escape($product['category_name']); ?></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mini-stat">
                        <span class="text-white-50">Quick View</span>
                        <strong><?php echo html_escape($product['rating']); ?> rating</strong>
                        <small class="text-white-50"><?php echo html_escape($product['stock']); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="surface-card p-4">
            <div class="eyebrow"><i class="bi bi-bag-check"></i> Product detail</div>
            <h1 class="section-title"><?php echo html_escape($product['product_name']); ?></h1>
            <p class="text-muted"><?php echo html_escape($product['description']); ?></p>
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="price"><?php echo html_escape($product['price']); ?></span>
                <span class="price-old"><?php echo html_escape($product['strike_price']); ?></span>
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
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary btn-lg">Add to Cart</button>
                <button
                    class="btn btn-outline-dark btn-lg"
                    type="button"
                    data-wishlist-add
                    data-product-id="<?php echo html_escape($product['id']); ?>"
                    data-product-name="<?php echo html_escape($product['product_name']); ?>"
                    data-product-category="<?php echo html_escape($product['category_name']); ?>"
                    data-product-price="<?php echo html_escape($product['price']); ?>"
                    data-product-image="<?= base_url($product['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                    title="Add to wishlist">
                    <i class="bi bi-suit-heart"></i>
                </button>
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
        <?php foreach (array_slice($related_products ?? [], 0, 4) as $product_item): ?>
            <div class="col-md-6 col-xl-3">
                <div class="product-card">
                    
                    <div class="product-thumb d-flex flex-column justify-content-between">

                        <!-- IMAGE -->
                        <div class="product-photo">
                            <img src="<?= base_url($product_item['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                                alt="<?= html_escape($product_item['product_name']); ?>">
                        </div>

                        <!-- BADGE -->
                        <span class="product-pill"><?php echo html_escape($product_item['badge']); ?></span>
                                        
                        <div>
                            <div class="text-white-50 small"><?php echo html_escape($product_item['category_name']); ?></div>
                            <h3 class="h5 mt-1 mb-0"><?php echo html_escape($product_item['product_name']); ?></h3>
                        </div>
                    </div>
                    <div class="p-3 d-flex justify-content-between align-items-center gap-2">
                        <span class="price"><?php echo html_escape($product_item['price']); ?></span>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-sm btn-outline-dark"
                                type="button"
                                data-wishlist-add
                                data-product-id="<?= $product_item['id']; ?>"
                                data-product-name="<?php echo html_escape($product_item['product_name']); ?>"
                                data-product-category="<?php echo html_escape($product_item['category_name']); ?>"
                                data-product-price="<?php echo html_escape($product_item['price']); ?>"
                                data-product-image="<?= base_url($product_item['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                                title="Add to wishlist">
                                <i class="bi bi-suit-heart"></i>
                            </button>
                            <a class="btn btn-sm btn-primary" href="<?php echo site_url('frontend/product/' . $product_item['id']); ?>">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>
