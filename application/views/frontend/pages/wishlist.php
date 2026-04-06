<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Wishlist</div>
    <h1 class="section-title">Save products for later comparison</h1>
</div>

<div class="row g-3" data-wishlist-grid>
    <div class="col-12" data-wishlist-empty>
        <div class="surface-card p-4 text-center">
            <h2 class="h5 fw-bold mb-2">Your wishlist is empty</h2>
            <p class="text-muted mb-0">Add products from the product page to see them here.</p>
        </div>
    </div>
</div>

<template id="wishlist-card-template">
    <div class="col-md-6 col-xl-4">
        <div class="product-card">
            <div class="product-thumb d-flex flex-column justify-content-between">
                <div class="product-photo">
                    <img src="" alt="">
                </div>
                <span class="product-pill"></span>
                <div>
                    <div class="text-white-50 small"></div>
                    <h3 class="h5 mt-1 mb-0"></h3>
                </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center">
                <span class="price"></span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-dark" type="button" data-wishlist-remove>Remove</button>
                    <a class="btn btn-sm btn-primary" href="#">View</a>
                </div>
            </div>
        </div>
    </div>
</template>

<?php $this->load->view('frontend/partials/footer'); ?>
