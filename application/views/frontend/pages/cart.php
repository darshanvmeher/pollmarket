<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Cart</div>
    <h1 class="section-title">Your cart is designed for quick bulk edits</h1>
    <p class="section-copy">Update quantities, review totals, and continue straight to checkout.</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="surface-card p-3">
            <?php foreach ($items as $index => $item): ?>
                <div class="cart-line border-bottom py-3">
                    <div class="cart-line-info">
                        <div class="cart-thumb">
                            <img src="<?php echo html_escape($item['image_url']); ?>" alt="<?php echo html_escape($item['name']); ?>">
                        </div>
                        <div>
                            <div class="fw-bold"><?php echo html_escape($item['name']); ?></div>
                            <div class="text-muted small"><?php echo html_escape($item['category']); ?></div>
                            <div class="text-muted small">Unit price: <?php echo html_escape($item['price']); ?></div>
                        </div>
                    </div>
                    <div class="cart-line-actions">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-outline-dark btn-sm" data-qty-action="decrease" data-qty-target="#qty-cart-<?php echo html_escape($index); ?>">-</button>
                            <input id="qty-cart-<?php echo html_escape($index); ?>" class="form-control text-center cart-qty-input" value="<?php echo html_escape($item['qty']); ?>">
                            <button class="btn btn-outline-dark btn-sm" data-qty-action="increase" data-qty-target="#qty-cart-<?php echo html_escape($index); ?>">+</button>
                        </div>
                        <button class="btn btn-link text-danger cart-remove-btn" type="button">
                            <i class="bi bi-trash3 me-1"></i>Remove
                        </button>
                    </div>
                    <div class="fw-bold"><?php echo html_escape($item['subtotal']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="cart-summary-sticky">
            <div class="surface-card p-4">
                <h2 class="h5 fw-bold mb-3">Order summary</h2>
                <div class="coupon-box mb-3">
                    <label class="form-label fw-semibold">Discount coupon</label>
                    <div class="d-flex gap-2">
                        <input class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-outline-dark">Apply</button>
                    </div>
                    <div class="text-muted small mt-2">Use your promo code before checkout.</div>
                </div>
                <div class="d-flex justify-content-between py-2"><span>Subtotal</span><strong>₹2,697</strong></div>
                <div class="d-flex justify-content-between py-2"><span>Shipping</span><strong>₹99</strong></div>
                <div class="d-flex justify-content-between py-2"><span>Discount</span><strong class="text-success">-₹0</strong></div>
                <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3"><span>Total</span><strong>₹2,796</strong></div>
                <a class="btn btn-primary w-100 mt-3" href="<?php echo site_url('frontend/checkout'); ?>">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
