<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Cart</div>
    <h1 class="section-title">Your cart is designed for quick bulk edits</h1>
    <p class="section-copy">Update quantities, review totals, and continue straight to checkout.</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="surface-card p-3">
            <?php foreach ($items as $item): ?>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom py-3 gap-3">
                    <div>
                        <div class="fw-bold"><?php echo html_escape($item['name']); ?></div>
                        <div class="text-muted small">Unit price: <?php echo html_escape($item['price']); ?></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-dark btn-sm" data-qty-action="decrease" data-qty-target="#qty-<?php echo html_escape($item['name']); ?>">-</button>
                        <input id="qty-<?php echo html_escape($item['name']); ?>" class="form-control text-center" style="width: 70px;" value="<?php echo html_escape($item['qty']); ?>">
                        <button class="btn btn-outline-dark btn-sm" data-qty-action="increase" data-qty-target="#qty-<?php echo html_escape($item['name']); ?>">+</button>
                    </div>
                    <div class="fw-bold"><?php echo html_escape($item['subtotal']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="surface-card p-4">
            <h2 class="h5 fw-bold">Order summary</h2>
            <div class="d-flex justify-content-between py-2"><span>Subtotal</span><strong>₹2,697</strong></div>
            <div class="d-flex justify-content-between py-2"><span>Shipping</span><strong>₹99</strong></div>
            <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3"><span>Total</span><strong>₹2,796</strong></div>
            <a class="btn btn-primary w-100 mt-3" href="<?php echo site_url('frontend/checkout'); ?>">Proceed to Checkout</a>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
