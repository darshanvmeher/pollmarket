<?php $this->load->view('frontend/partials/header'); ?>

<div class="row g-4">
    <div class="col-lg-3">
        <div class="surface-card p-3">
            <div class="fw-bold mb-3">Account</div>
            <div class="d-grid gap-2">
                <a class="chip active" href="<?php echo site_url('frontend/account'); ?>">Dashboard</a>
                <a class="chip" href="<?php echo site_url('frontend/orders'); ?>">Orders</a>
                <a class="chip" href="<?php echo site_url('frontend/checkout'); ?>">Addresses</a>
                <a class="chip" href="<?php echo site_url('frontend/contact'); ?>">Support</a>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="section-heading">
            <div class="section-kicker">My Account</div>
            <h1 class="section-title">Personal dashboard and order history</h1>
        </div>
        <div class="row g-3">
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Orders</div><div class="display-6 fw-bold"><?php echo (int) ($orders_count ?? 0); ?></div></div></div>
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Wishlist</div><div class="display-6 fw-bold wishlist-count">0</div></div></div>
            <div class="col-md-4"><div class="info-card"><div class="text-muted small">Saved Addresses</div><div class="display-6 fw-bold"><?php echo (int) ($saved_addresses_count ?? 0); ?></div></div></div>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>


<script>
$(document).ready(function () {

    let token = localStorage.getItem("token");
    if (!token) return;

    fetch("http://localhost/pollmarket/index.php/Api_handler/wishlist_count", {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token
        }
    })
    .then(res => res.json())
    .then(data => {
        let count = data.count || 0;

        // Update dashboard count
        $(".wishlist-count").text(count);
    });

});
</script>
