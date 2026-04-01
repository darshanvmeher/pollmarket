<?php $this->load->view('frontend/partials/header'); ?>

<div class="row g-4">
    <div class="col-lg-3">
        <div class="surface-card p-3">
            <div class="fw-bold mb-3">Account</div>
            <div class="d-grid gap-2">
                <a class="chip active" href="#">Dashboard</a>
                <a class="chip" href="#">Orders</a>
                <a class="chip" href="#">Addresses</a>
                <a class="chip" href="#">Payments</a>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="section-heading">
            <div class="section-kicker">My Account</div>
            <h1 class="section-title">Personal dashboard and order history</h1>
        </div>
        <div class="row g-3">
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Orders</div><div class="display-6 fw-bold">24</div></div></div>
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Wishlist</div><div class="display-6 fw-bold">8</div></div></div>
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Saved Addresses</div><div class="display-6 fw-bold">3</div></div></div>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
