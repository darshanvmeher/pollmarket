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
                <!--<div class="cart-line border-bottom py-3" data-price="<?= $item['price']; ?>"-->
                <div class="cart-line border-bottom py-3"
                        data-price="<?= $item['price']; ?>"
                        data-product-id="<?= $item['product_id']; ?>">

                    <div class="cart-line-info">
                        <div class="cart-thumb">
                           <!-- <img src="<?php echo html_escape($item['image_url']); ?>" alt="<?php echo html_escape($item['product_name']); ?>">
                            <img src="<?php echo html_escape($item['image_url'] ?? base_url('assets/images/default.png')); ?>">
                          
                            <img src="<?= base_url($item['media'][0]['media_path'] ?? 'assets/no-image.png') ?>"
                                alt="<?= html_escape($item['product_name']); ?>"-->
                                <img src="<?= base_url($item['image_url'] ?? 'assets/no-image.png') ?>">
                        </div>
                        <div>
                            <div class="fw-bold"><?php echo html_escape($item['product_name']); ?></div>
                            <div class="text-muted small"><?php echo html_escape($item['category_name']); ?></div>
                            <div class="text-muted small">Unit price:  ₹<?php echo html_escape($item['price']); ?></div>
                            
                        </div>
                    </div>
                    <div class="cart-line-actions">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-outline-dark btn-sm" data-qty-action="decrease" data-qty-target="#qty-cart-<?php echo html_escape($index); ?>">-</button>
                            <input id="qty-cart-<?php echo html_escape($index); ?>" class="form-control text-center cart-qty-input"  value="<?php echo html_escape($item['qty'] ?? 1); ?>">
                            <button class="btn btn-outline-dark btn-sm" data-qty-action="increase" data-qty-target="#qty-cart-<?php echo html_escape($index); ?>">+</button>
                        </div>
                        <!--<button 
                        class="btn btn-link text-danger cart-remove-btn"
                        data-product-id="<?= $item['product_id']; ?>"
                        type="button">
                        <i class="bi bi-trash3 me-1"></i>Remove
                    </button>-->
                        <button 
    class="btn btn-link text-danger cart-remove-btn"
    data-cart-id="<?= $item['cart_id']; ?>"
    type="button">
    <i class="bi bi-trash3 me-1"></i>Remove
</button>


                           </div>
                    <!--<div class="fw-bold"><?php echo html_escape($item['subtotal'] ?? ($item['price'] ?? 0) * ($item['qty'] ?? 1)); ?></div>-->
                    <div class="fw-bold cart-item-total"> ₹<?= ($item['price'] ?? 0) * ($item['qty'] ?? 1); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="cart-summary-sticky">
            <div class="surface-card p-4">
                <h2 class="h5 fw-bold mb-3">Order summary</h2>
               <!-- <div class="coupon-box mb-3">
                    <label class="form-label fw-semibold">Discount coupon</label>
                    <div class="d-flex gap-2">
                        <input class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-outline-dark">Apply</button>
                    </div>
                    <div class="text-muted small mt-2">Use your promo code before checkout.</div>
                </div>-->
                <div class="coupon-box mb-3">
    <label class="form-label fw-semibold">Discount coupon</label>

    <div class="d-flex gap-2">
        <input id="coupon_code" class="form-control" placeholder="Enter coupon code">
        <button id="apply_coupon" class="btn btn-outline-dark">Apply</button>
    </div>

    <p id="coupon_msg" class="mt-2"></p>

    <div class="text-muted small mt-2">
        Use your promo code before checkout.
    </div>
</div>
<!--
<p>Subtotal: ₹<span id="subtotal">0</span></p>
<p>Discount: ₹<span id="discount">0</span></p>
<p>Total: ₹<span id="total">0</span></p>-->
                <!--<div class="d-flex justify-content-between py-2"><span>Subtotal</span><strong>₹2,697</strong></div>
                <div class="d-flex justify-content-between py-2"><span>Shipping</span><strong>₹99</strong></div>
                <div class="d-flex justify-content-between py-2"><span>Discount</span><strong class="text-success">-₹0</strong></div>
                <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3"><span>Total</span><strong>₹2,796</strong></div>-->
                <!--<div class="d-flex justify-content-between py-2">
                    <span>Subtotal</span>
                    <strong id="cart-subtotal">₹</strong>
                </div>

                <div class="d-flex justify-content-between py-2">
                    <span>Shipping</span>
                    <strong>₹99</strong>
                </div>

                 <div class="d-flex justify-content-between py-2">
                    <span>GST</span>
                    <strong id="cart-gst">5%</strong>
                </div>

                <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3">
                    <span>Total</span>
                    <strong id="cart-total">₹0</strong>
                </div>-->
             <!--   <div class="d-flex justify-content-between py-2">
    <span>Subtotal</span>
    <strong id="cart-subtotal">₹0</strong>
</div>-->


<!-- GST TOTAL 
<div class="d-flex justify-content-between py-2">
    <span>GST (5%)</span>
    <strong id="gst-total">₹0</strong>
</div>-->

<!-- CGST + SGST 
<div id="cgst-sgst-row" style="display:none;">
    <div class="d-flex justify-content-between small text-muted">
        <span>CGST (2.5%)</span>
        <span id="cgst-amount">₹0</span>
    </div>
    <div class="d-flex justify-content-between small text-muted">
        <span>SGST (2.5%)</span>
        <span id="sgst-amount">₹0</span>
    </div>
</div>
            -->

<!-- IGST 
<div id="igst-row" style="display:none;">
    <div class="d-flex justify-content-between small text-muted">
        <span>IGST (5%)</span>
        <span id="igst-amount">₹0</span>
    </div>
</div>-->

<!-- SHIPPING 
<div class="d-flex justify-content-between py-2">
    <span>Shipping</span>
    <strong>₹99</strong>
</div>

<hr>

<div class="d-flex justify-content-between py-2">
    <span>Total</span>
    <strong id="cart-total">₹0</strong>
</div>-->

<div class="d-flex justify-content-between py-2">
    <span>Subtotal</span>
    <strong id="cart-subtotal">₹0</strong>
</div>

<!-- DISCOUNT -->
<div class="d-flex justify-content-between py-2">
    <span>Discount</span>
    <strong class="text-success">-₹<span id="discount">0</span></strong>
</div>

<!-- GST TOTAL -->
<div class="d-flex justify-content-between py-2">
    <span>GST (5%)</span>
    <strong id="gst-total">₹0</strong>
</div>

<!-- CGST + SGST -->
<div id="cgst-sgst-row" style="display:none;">
    <div class="d-flex justify-content-between small text-muted">
        <span>CGST (2.5%)</span>
        <span id="cgst-amount">₹0</span>
    </div>
    <div class="d-flex justify-content-between small text-muted">
        <span>SGST (2.5%)</span>
        <span id="sgst-amount">₹0</span>
    </div>
</div>

<!-- IGST -->
<div id="igst-row" style="display:none;">
    <div class="d-flex justify-content-between small text-muted">
        <span>IGST (5%)</span>
        <span id="igst-amount">₹0</span>
    </div>
</div>

<!-- SHIPPING -->
<div class="d-flex justify-content-between py-2">
    <span>Shipping</span>
    <strong>₹99</strong>
</div>

<hr>

<div class="d-flex justify-content-between py-2">
    <span>Total</span>
    <strong id="cart-total">₹0</strong>
</div>
                <a class="btn btn-primary w-100 mt-3" href="<?php echo site_url('frontend/checkout'); ?>">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('frontend/partials/footer'); ?>
<!--
<script>
    $(document).ready(function () {
        $('[data-qty-action]').on('click', function () {
            const action = $(this).data('qty-action');
            const targetInput = $($(this).data('qty-target'));
            let currentValue = parseInt(targetInput.val()) || 1;

            if (action === 'increase') {
                currentValue++;
            } else if (action === 'decrease' && currentValue > 1) {
                currentValue--;
            }

            targetInput.val(currentValue);
        });
    });
    </script>   

    <script>
$(document).ready(function () {

    // 🔥 CALCULATE TOTAL
    function updateCartTotal() {
        let subtotal = 0;

        $('.cart-line').each(function () {
            let price = parseFloat($(this).find('.text-muted.small').last().text().replace(/[^0-9]/g,'')) || 0;
            let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

            subtotal += price * qty;
        });

        $('#cart-subtotal').text('₹' + subtotal);
        $('#cart-gst').text('₹' + (subtotal * 0.05));
        $
        $('#cart-total').text('₹' + (subtotal + 99 + (subtotal * 0.05)));

    }

    updateCartTotal();

    // 🔥 UPDATE QTY UI + TOTAL
   $('[data-qty-action]').on('click', function () {
    const action = $(this).data('qty-action');
    const input = $($(this).data('qty-target'));
    const row = input.closest('.cart-line');

    let qty = parseInt(input.val()) || 1;
    let price = parseFloat(row.data('price')) || 0;

    if (action === 'increase') qty++;
    else if (action === 'decrease' && qty > 1) qty--;

    input.val(qty);

    // 🔥 UPDATE PRODUCT TOTAL
    let total = price * qty;
    row.find('.cart-item-total').text("₹" + total);
                
    // 🔥 UPDATE CART TOTAL
    updateCartTotal();
});

    // 🔥 REMOVE ITEM
    $('.cart-remove-btn').on('click', function () {
        let btn = $(this);
        let product_id = btn.data('product-id');
        let token = localStorage.getItem("token");

        if (!token) {
            alert("Please login");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/remove_from_cart') ?>",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: { product_id: product_id },

            success: function () {
                // remove UI
                btn.closest('.cart-line').remove();

                // update total
                updateCartTotal();

                // update badge
                if (typeof loadCartCount === "function") {
                    loadCartCount();
                }

                alert("Item removed");
            },
            error: function () {
                alert("Error removing item");
            }
        });
    });

});
</script>-->
<!--
<script>
$(document).ready(function () {

    // 🔥 UPDATE TOTAL + GST
    function updateCartTotal() {
        let subtotal = 0;

        $('.cart-line').each(function () {
            let price = parseFloat($(this).data('price')) || 0;
            let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

            subtotal += price * qty;
        });

        let shipping = 99;
        let state = "<?= $user_state ?? 'Other' ?>";

        let cgst = 0, sgst = 0, igst = 0, gst = 0;

        if (state === "Maharashtra") {

            cgst = subtotal * 0.025;
            sgst = subtotal * 0.025;
            gst = cgst + sgst;

            $('#cgst-sgst-row').show();
            $('#igst-row').hide();

            $('#cgst-amount').text('₹' + cgst.toLocaleString());
            $('#sgst-amount').text('₹' + sgst.toLocaleString());

        } else {

            igst = subtotal * 0.05;
            gst = igst;

            $('#igst-row').show();
            $('#cgst-sgst-row').hide();

            $('#igst-amount').text('₹' + igst.toLocaleString());
        }

        let total = subtotal + gst + shipping;

        $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
        $('#gst-total').text('₹' + gst.toLocaleString());
        $('#cart-total').text('₹' + total.toLocaleString());
    }

    // ✅ INITIAL LOAD
    updateCartTotal();


    // 🔥 QTY INCREASE / DECREASE
    $(document).on('click', '[data-qty-action]', function () {

    const action = $(this).data('qty-action');
    const input = $($(this).data('qty-target'));
    const row = input.closest('.cart-line');

    let productId = row.find('.cart-remove-btn').data('product-id'); // ✅ get product_id
    let token = localStorage.getItem("token");

    let qty = parseInt(input.val()) || 1;
    let price = parseFloat(row.data('price')) || 0;

    if (action === 'increase') {
        qty++;
    } else if (action === 'decrease' && qty > 1) {
        qty--;
    }

    // 🔥 CALL API TO UPDATE DB
    $.ajax({
        url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
        type: "POST",
        data: {
            product_id: productId,
            quantity: qty
        },
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function () {

            // ✅ UPDATE UI AFTER SUCCESS
            input.val(qty);

            let total = price * qty;
            row.find('.cart-item-total').text('₹' + total.toLocaleString());

            updateCartTotal();
        },
        error: function () {
            alert("Error updating quantity");
        }
    });

});
    // 🔥 REMOVE FROM CART
    $(document).on('click', '.cart-remove-btn', function () {

        let btn = $(this);
        let productId = btn.data('product-id');
        let row = btn.closest('.cart-line');
        let token = localStorage.getItem("token");

        if (!token) {
            alert("Please login");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/remove_from_cart') ?>",
            type: "POST",
            data: { product_id: productId },
            headers: {
                "Authorization": "Bearer " + token
            },

            success: function () {

                // ✅ REMOVE ITEM FROM UI
                row.remove();

                // ✅ UPDATE TOTAL
                updateCartTotal();

                // ✅ UPDATE CART BADGE
                if (typeof loadCartCount === "function") {
                    loadCartCount();
                }

                alert("Item removed");
            },

            error: function () {
                alert("Error removing item");
            }
        });

    });

});
</script>-->

<!--
<script>
$(document).ready(function () {
    let appliedDiscount = 0;

    

    // 🔥 UPDATE TOTAL + GST
    function updateCartTotal() {
        let subtotal = 0;

        $('.cart-line').each(function () {
            let price = parseFloat($(this).data('price')) || 0;
            let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

            subtotal += price * qty;
        });

        let shipping = 99;
        let state = "<?= $user_state ?? 'Other' ?>";

        let cgst = 0, sgst = 0, igst = 0, gst = 0;

        if (state === "Maharashtra") {
            cgst = subtotal * 0.025;
            sgst = subtotal * 0.025;
            gst = cgst + sgst;

            $('#cgst-sgst-row').show();
            $('#igst-row').hide();

            $('#cgst-amount').text('₹' + cgst.toLocaleString());
            $('#sgst-amount').text('₹' + sgst.toLocaleString());
        } else {
            igst = subtotal * 0.05;
            gst = igst;

            $('#igst-row').show();
            $('#cgst-sgst-row').hide();

            $('#igst-amount').text('₹' + igst.toLocaleString());
        }

        let total = subtotal + gst + shipping;

        $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
        $('#gst-total').text('₹' + gst.toLocaleString());
        $('#cart-total').text('₹' + total.toLocaleString());
    }

    // ✅ INITIAL LOAD
    updateCartTotal();


    // 🔥 QTY INCREASE / DECREASE (FINAL FIXED)
    $(document).on('click', '[data-qty-action]', function () {

        const btn = $(this);
        const action = btn.data('qty-action');
        const input = $(btn.data('qty-target'));
        const row = input.closest('.cart-line');

        let productId = row.data('product-id'); // ✅ FIXED
        let token = localStorage.getItem("token");

        if (!productId || !token) {
            alert("Something went wrong");
            return;
        }

        let qty = parseInt(input.val()) || 1;
        let price = parseFloat(row.data('price')) || 0;

        if (action === 'increase') {
            qty++;
        } else if (action === 'decrease' && qty > 1) {
            qty--;
        }

        // 🔒 prevent multiple clicks
        btn.prop('disabled', true);

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
            type: "POST",
            data: {
                product_id: productId,
                quantity: qty
            },
            headers: {
                "Authorization": "Bearer " + token
            },

            success: function () {
                // ✅ UPDATE UI AFTER DB SUCCESS
                input.val(qty);

                let total = price * qty;
                row.find('.cart-item-total').text('₹' + total.toLocaleString());

                updateCartTotal();
            },

            error: function () {
                alert("Error updating quantity");
            },

            complete: function () {
                btn.prop('disabled', false);
            }
        });

    });


    // 🔥 REMOVE FROM CART
    $(document).on('click', '.cart-remove-btn', function () {

        let btn = $(this);
        let row = btn.closest('.cart-line');
        let productId = row.data('product-id'); // ✅ FIXED
        let token = localStorage.getItem("token");

        if (!token) {
            alert("Please login");
            return;
        }

        btn.prop('disabled', true);

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/remove_from_cart') ?>",
            type: "POST",
            data: { product_id: productId },
            headers: {
                "Authorization": "Bearer " + token
            },

            success: function () {

                row.remove();
                updateCartTotal();

                if (typeof loadCartCount === "function") {
                    loadCartCount();
                }

                alert("Item removed");
            },

            error: function () {
                alert("Error removing item");
            },

            complete: function () {
                btn.prop('disabled', false);
            }
        });

    });

});
</script>-->

<!--
<script>
let appliedDiscount = 0;

$(document).ready(function () {

    // ✅ APPLY COUPON
    $('#apply_coupon').click(function () {

        let code = $('#coupon_code').val().trim();
        let token = localStorage.getItem("token");

        if (code === "") {
            $('#coupon_msg').html("❌ Enter coupon code");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/apply_coupon') ?>",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: { coupon_code: code },

            success: function (res) {

                let data = JSON.parse(res);

                if (data.status) {

                    $('#coupon_msg').html("✅ " + data.message);

                    // ✅ store discount globally
                    appliedDiscount = parseFloat(data.discount) || 0;

                    $('#discount').text(appliedDiscount);

                    updateFinalTotal(); // 🔥 update total

                } else {
                    $('#coupon_msg').html("❌ " + data.message);
                }
            },

            error: function () {
                $('#coupon_msg').html("❌ Server error");
            }
        });

    });

});


/* ✅ FUNCTION: UPDATE FINAL TOTAL */
function updateFinalTotal() {

    let subtotal = parseFloat($('#subtotal').text()) || 0;

    let final_total = subtotal - appliedDiscount;

    if (final_total < 0) final_total = 0;

    $('#total').text(final_total);
}


/* ✅ EXAMPLE: WHEN YOU UPDATE SUBTOTAL */
function updateCartSubtotal() {

    let subtotal = 0;

    $('.cart-line').each(function () {

        let price = parseFloat($(this).find('.price').text()) || 0;
        let qty = parseInt($(this).find('.qty').val()) || 0;

        subtotal += price * qty;
    });

    $('#summary_subtotal').text(subtotal);
    updateFinalTotal(); // 🔥 VERY IMPORTANT
}
</script>-->
<!--
<script>
$(document).ready(function () {

    // =========================
    // APPLY COUPON
    // =========================
    $('#apply_coupon').click(function () {

        let code = $('#coupon_code').val().trim();
        let token = localStorage.getItem("token");

        if (code === "") {
            $('#coupon_msg').html("❌ Enter coupon code");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: { coupon_code: code },

            success: function (res) {

                let data = JSON.parse(res);

                if (data.status) {

                    $('#coupon_msg').html("✅ " + data.message);

                    // ✅ SET DISCOUNT
                    $('#discount').text(data.discount);

                    // ✅ UPDATE TOTAL
                    updateFinalTotal();

                } else {
                    $('#coupon_msg').html("❌ " + data.message);
                }
            },

            error: function (xhr) {
                console.log(xhr.responseText);
                $('#coupon_msg').html("❌ Server error");
            }
        });

    });

    // =========================
    // INITIAL LOAD
    // =========================
    updateCartSubtotal();

});


// =========================
// CALCULATE SUBTOTAL
// =========================
function updateCartSubtotal() {

    let subtotal = 0;

    $('.cart-line').each(function () {

        let price = parseFloat($(this).find('.price').text().replace(/[^0-9]/g, '')) || 0;
        let qty = parseInt($(this).find('.qty').val()) || 0;

        subtotal += price * qty;
    });

    $('#subtotal').text(subtotal);

    updateFinalTotal();
}


// =========================
// FINAL TOTAL = SUBTOTAL - DISCOUNT
// =========================
function updateFinalTotal() {

    let subtotal = parseFloat($('#subtotal').text()) || 0;
    let discount = parseFloat($('#discount').text()) || 0;

    let total = subtotal - discount;

    if (total < 0) total = 0;

    $('#total').text(total);
}
</script>

<script>
$(document).ready(function () {

    // APPLY COUPON
    $('#apply_coupon').click(function () {

        let code = $('#coupon_code').val().trim();
        let token = localStorage.getItem("token");

        if (code === "") {
            $('#coupon_msg').html("❌ Enter coupon code");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: { coupon_code: code },

            success: function (res) {

                let data = JSON.parse(res);

                if (data.status) {

                    $('#coupon_msg').html("✅ " + data.message);

                    // store discount directly in UI
                    $('#discount').text(data.discount);

                    updateFinalTotal();

                } else {
                    $('#coupon_msg').html("❌ " + data.message);
                }
            }
        });

    });

});


// FINAL TOTAL = subtotal - discount
function updateFinalTotal() {

    let subtotal = parseFloat($('#subtotal').text()) || 0;
    let discount = parseFloat($('#discount').text()) || 0;

    let final_total = subtotal - discount;

    if (final_total < 0) final_total = 0;

    $('#total').text(final_total);
}
</script>

<script>
    function updateFinalTotal() {

    let subtotal = parseFloat($('#subtotal').text()) || 0;
    let discount = parseFloat($('#discount').text()) || 0;

    let final_total = subtotal - discount;

    if (final_total < 0) final_total = 0;

    $('#total').text(final_total);
}
</script>

<script>

$('#apply_coupon').on('click', function () {

    let coupon = $('#coupon_code').val();

    if (!coupon) {
        $('#coupon_msg').text('Enter coupon code').css('color', 'red');
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/api_handler/apply_coupon'); ?>",
        type: "POST",
        data: { coupon_code: coupon },

        success: function (res) {

            let data = (typeof res === "string") ? JSON.parse(res) : res;

            if (data.status) {

                $('#coupon_msg').text(data.message).css('color', 'green');

                // ✅ Update discount
                $('#discount').text(data.discount);

                // ✅ Update final total
                $('#total').text(data.final_total);

            } else {
                $('#coupon_msg').text(data.message).css('color', 'red');
            }
        },

        error: function () {
            $('#coupon_msg').text('Server error').css('color', 'red');
        }
    });
});

</script>-->

<!--
<script>

$(document).ready(function () {

    $('#apply_coupon').click(function () {

        let code = $('#coupon_code').val().trim();
        let token = localStorage.getItem("token");

        if (code === "") {
            $('#coupon_msg').html("❌ Enter coupon code");
            return;
        }

        $.ajax({
            url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
            type: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            data: { coupon_code: code },

            success: function (res) {

                let data = (typeof res === "string") ? JSON.parse(res) : res;

                if (data.status) {

                    $('#coupon_msg').html("✅ " + data.message);

                    // ✅ ONLY UPDATE UI FROM API
                    $('#discount').text(data.discount);
                    $('#cart-total').text('₹' + data.final_total);

                } else {
                    $('#coupon_msg').html("❌ " + data.message);
                }
            },

            error: function () {
                $('#coupon_msg').html("❌ Server error");
            }
        });

    });

});
</script>-->

<!--
<script>

$('#apply_coupon').click(function () {

    let code = $('#coupon_code').val().trim();
    let token = localStorage.getItem("token");

    if (code === "") {
        $('#coupon_msg').html("❌ Enter coupon code");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: { coupon_code: code },

        success: function (res) {

            let data = (typeof res === "string") ? JSON.parse(res) : res;

            if (data.status) {

                $('#coupon_msg').html("✅ " + data.message);

                // ✅ UPDATE UI FROM API
                $('#cart-subtotal').text('₹' + data.subtotal);
                $('#discount').text('₹' + data.discount);
                $('#gst-total').text('₹' + data.gst);
                $('#cart-total').text('₹' + data.final_total);

            } else {
                $('#coupon_msg').html("❌ " + data.message);
            }
        }
    });

});

</script>-->

<script>

$(document).ready(function () {

    function updateCartTotal() {
        let subtotal = 0;

        $('.cart-line').each(function () {
            let price = parseFloat($(this).data('price')) || 0;
            let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

            subtotal += price * qty;
        });

        $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    }

    // initial load
    updateCartTotal();

    // qty change
    $(document).on('click', '[data-qty-action]', function () {

        const btn = $(this);
        const input = $(btn.data('qty-target'));
        const row = input.closest('.cart-line');

        let qty = parseInt(input.val()) || 1;
        let price = parseFloat(row.data('price')) || 0;

        if (btn.data('qty-action') === 'increase') qty++;
        else if (qty > 1) qty--;

        input.val(qty);

        row.find('.cart-item-total')
            .text('₹' + (price * qty).toLocaleString());

        updateCartTotal();
    });

});
</script>


<script>

$('#apply_coupon').click(function () {

    let code = $('#coupon_code').val().trim();
    let token = localStorage.getItem("token");
    let state = "<?= $user_state ?? 'Other' ?>";

    if (!code) {
        $('#coupon_msg').html("❌ Enter coupon code");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            coupon_code: code,
            state: state
        },

        success: function (res) {

            let data = (typeof res === "string") ? JSON.parse(res) : res;

            if (data.status) {

                $('#coupon_msg').html("✅ " + data.message);

                // ✅ update all from API
                $('#cart-subtotal').text('₹' + data.subtotal);
                $('#discount').text(data.discount);
                $('#gst-total').text('₹' + data.gst);
                $('#cart-total').text('₹' + data.final_total);

                // GST display
                if (state === "Maharashtra") {
                    $('#cgst-sgst-row').show();
                    $('#igst-row').hide();

                    $('#cgst-amount').text('₹' + data.cgst);
                    $('#sgst-amount').text('₹' + data.sgst);

                } else {
                    $('#igst-row').show();
                    $('#cgst-sgst-row').hide();

                    $('#igst-amount').text('₹' + data.igst);
                }

            } else {
                $('#coupon_msg').html("❌ " + data.message);
            }
        }
    });

});
</script>    

<script>
$(document).on('click', '.cart-remove-btn', function () {

    let cart_id = $(this).data('cart-id');

    if (!cart_id) {
        console.log("Cart ID missing");
        return;
    }

    if (!confirm("Remove this item?")) return;

    $.ajax({
        url: base_url + "api_handler/remove_cart",
        type: "POST",
        data: { cart_id: cart_id },

        success: function (res) {
            let response = JSON.parse(res);

            if (response.status) {
                location.reload(); // refresh cart
            } else {
                alert(response.message);
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Server error");
        }
    });

});
</script>