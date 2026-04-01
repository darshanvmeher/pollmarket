<?php $this->load->view('frontend/partials/header'); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="surface-card p-4">
            <div class="section-kicker">Track Order</div>
            <h1 class="section-title">Check delivery status across India in seconds</h1>
            <div class="input-group mt-3">
                <input class="form-control" placeholder="Enter order number">
                <button class="btn btn-primary">Track</button>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-between border-bottom py-3"><span>Order placed</span><strong>Completed</strong></div>
                <div class="d-flex justify-content-between border-bottom py-3"><span>Packed</span><strong>Completed</strong></div>
                <div class="d-flex justify-content-between border-bottom py-3"><span>Shipped</span><strong>In progress</strong></div>
                <div class="d-flex justify-content-between py-3"><span>Delivered</span><strong>Pending</strong></div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
