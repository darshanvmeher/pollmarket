<?php $this->load->view('frontend/partials/header'); ?>

<!--<style>
[data-wishlist-empty] {
    display: none;
}
</style>-->

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    let token = localStorage.getItem("token");

    if (!token) {
        alert("Please login first");
        return;
    }

    const grid = $("[data-wishlist-grid]");
    const emptyState = $("[data-wishlist-empty]");
    const template = $("#wishlist-card-template").html();

    emptyState.hide();
    grid.html("<p>Loading...</p>");

    // ✅ LIST API
    $.ajax({
        url: "<?=base_url('index.php/Api_handler/wishlist')?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        dataType: "json",

        success: function (response) {

            grid.html("");

            if (response.status && response.data && response.data.length > 0) {

                emptyState.hide();

                $.each(response.data, function (i, item) {

                    let card = $(template);

                    card.find("img").attr("src", item.product_image);
                    card.find("h3").text(item.product_name);
                    card.find(".price").text("₹" + item.price);
                    card.find(".product-pill").text("Saved");

                    card.find("a").attr("href", "product/" + item.product_id);
                    
                    card.find("[data-wishlist-remove]").off("click").on("click", function (e) {

    e.preventDefault();
    e.stopImmediatePropagation(); // 🔥 VERY IMPORTANT

    let btn = $(this);

    // 🚫 HARD BLOCK (prevents double click 100%)
    if (btn.data("processing")) return;

    btn.data("processing", true);

    btn.prop("disabled", true);
    btn.text("Removing...");
    btn.css("opacity", "0.6");

    let cardElement = btn.closest(".col-md-6, .col-xl-4");

    // ✅ REMOVE IMMEDIATELY
    cardElement.fadeOut(200, function () {
    $(this).remove();
    });
    if ($("[data-wishlist-grid] [class*='col-']").length === 0) {
        $("[data-wishlist-empty]").show();
    }

    // API call
    removeWishlist(item.product_id, btn);
    updateWishlistCount();
    
});
                    
                     
                    grid.append(card);
                });

            } else {
                emptyState.show();
            }
        },

        error: function (err) {
            console.log("List Error:", err);
        }
    });

});
</script>

<script>
function removeWishlist(product_id, btn) {

    let token = localStorage.getItem("token");

    $.ajax({
        url: "<?=base_url('index.php/Api_handler/remove_from_wishlist')?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            product_id: product_id
        },
        dataType: "json",

        success: function (res) {
            console.log(res.message);

            // ✅ NOW update count AFTER DB update
            updateWishlistCount();
        },

        error: function () {
            location.reload();
        }
    });
}
</script>

<script>
   function updateWishlistCount() {

    let token = localStorage.getItem("token");

    $.ajax({
        url: "<?=base_url('index.php/Api_handler/wishlist')?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (res) {
            $("#wishlist-count").text(res.data.length);
        }
    });
}
</script>