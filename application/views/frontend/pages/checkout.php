<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Checkout</div>
    <h1 class="section-title">A clean checkout built for repeat wholesale customers</h1>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="surface-card p-4">
            <h2 class="h5 fw-bold mb-3">Shipping details</h2>
            <div class="row g-3">
                <div class="col-md-6"><input class="form-control" placeholder="First name"></div>
                <div class="col-md-6"><input class="form-control" placeholder="Last name"></div>
                <div class="col-12"><input class="form-control" placeholder="Company name"></div>
                <div class="col-12"><input class="form-control" placeholder="Address"></div>
                <div class="col-md-6"><input class="form-control" placeholder="City"></div>
                <div class="col-md-6"><input class="form-control" placeholder="State"></div>
                <div class="col-md-6"><input class="form-control" placeholder="PIN Code"></div>
                <div class="col-md-6"><input class="form-control" placeholder="Phone"></div>
                <div class="col-12"><input class="form-control" placeholder="GSTIN / Company GST number"></div>
            </div>
            <h2 class="h5 fw-bold mt-4 mb-3">Payment method</h2>
            <div class="d-grid gap-2">
                <label class="surface-card p-3 d-flex justify-content-between align-items-center"><span><i class="bi bi-credit-card me-2"></i> Card</span><input type="radio" name="pay" checked></label>
                <label class="surface-card p-3 d-flex justify-content-between align-items-center"><span><i class="bi bi-cash-stack me-2"></i> Cash on delivery</span><input type="radio" name="pay"></label>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="surface-card p-4">
            <h2 class="h5 fw-bold">Order summary</h2>
            <div class="d-flex justify-content-between py-2"><span>Items</span><strong>2</strong></div>
            <div class="d-flex justify-content-between py-2"><span>Subtotal</span><strong>₹2,697</strong></div>
            <div class="d-flex justify-content-between py-2"><span>GST</span><strong>₹486</strong></div>
            <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3"><span>Total</span><strong>₹3,183</strong></div>
            <button class="btn btn-primary w-100 mt-3">Place Order</button>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
