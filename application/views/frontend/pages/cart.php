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
                            <input id="qty-cart-<?php echo html_escape($index); ?>" class="form-control text-center cart-qty-input"  value="<?php echo html_escape($item['quantity'] ?? 1); ?>">
                            <button class="btn btn-outline-dark btn-sm" data-qty-action="increase" data-qty-target="#qty-cart-<?php echo html_escape($index); ?>">+</button>
                        </div>
                        <!--<button 
                        class="btn btn-link text-danger cart-remove-btn"
                        data-product-id="<?= $item['product_id']; ?>"
                        type="button">
                        <i class="bi bi-trash3 me-1"></i>Remove
                    </button>-->
                     <!--   <button 
    class="btn btn-link text-danger cart-remove-btn"
    data-cart-id="<?= $item['cart_id']; ?>"
    type="button">
    <i class="bi bi-trash3 me-1"></i>Remove
</button>-->

<button 
    class="btn btn-link text-danger cart-remove-btn"
    data-product-id="<?= $item['product_id']; ?>" 
    type="button">
    <i class="bi bi-trash3 me-1"></i>Remove
</button>


                           </div>
                    <!--<div class="fw-bold"><?php echo html_escape($item['subtotal'] ?? ($item['price'] ?? 0) * ($item['qty'] ?? 1)); ?></div>-->
                    <div class="fw-bold cart-item-total"> ₹<?= ($item['price'] ?? 0) * ($item['quantity'] ?? 1); ?>
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
             <!--   <div class="coupon-box mb-3">
    <label class="form-label fw-semibold">Discount coupon</label>

    <div class="d-flex gap-2">
        <input id="coupon_code" class="form-control" placeholder="Enter coupon code">
        <button id="apply_coupon" class="btn btn-outline-dark">Apply</button>
    </div>

    <p id="coupon_msg" class="mt-2"></p>

    <div class="text-muted small mt-2">
        Use your promo code before checkout.
    </div>
</div>-->
<!--
<div class="coupon-box mb-3">
    <label class="form-label fw-semibold">Discount coupon</label>

    <div class="d-flex gap-2">
        <input 
            id="coupon_code" 
            class="form-control" 
            placeholder="Enter coupon code"
            value="<?= !empty($coupon) ? $coupon['coupon_code'] : '' ?>"
        >

        <button id="apply_coupon" class="btn btn-outline-dark">
            <?= !empty($coupon) ? 'Applied' : 'Apply' ?>
        </button>
    </div>

  

    <?php if (!empty($coupon)) : ?>
        <small class="text-success">✅ Coupon already applied</small>
    <?php endif; ?>

    
</div>

    -->

    <div class="coupon-box mb-3">
    <label class="form-label fw-semibold">Discount coupon</label>

    <div class="d-flex gap-2">
        <input 
            id="coupon_code" 
            class="form-control" 
            placeholder="Enter coupon code"
            value="<?= !empty($coupon) ? $coupon['coupon_code'] : '' ?>"
            <?= !empty($coupon) ? 'readonly' : '' ?>
        >

        <button id="apply_coupon" class="btn btn-outline-dark">
            <?= !empty($coupon) ? 'Applied' : 'Apply' ?>
        </button>
    </div>

    <?php if (!empty($coupon)) : ?>
        <small class="text-success d-block mt-2">
            ✅ Coupon already applied
        </small>

        <!-- 🔥 ADD REMOVE BUTTON HERE -->
        <button id="remove_coupon" class="btn btn-sm btn-danger mt-2">
            Remove Coupon
        </button>
    <?php endif; ?>
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
<!--
<div class="d-flex justify-content-between py-2">
    <span>Subtotal</span>
    <strong id="cart-subtotal">₹0</strong>
</div>
-->
<!-- DISCOUNT 
<div class="d-flex justify-content-between py-2">
    <span>Discount</span>
    <strong class="text-success">-₹<span id="discount">0</span></strong>
</div>-->

<div class="d-flex justify-content-between py-2">
    <span>Subtotal</span>
    <strong>₹<?= $cart_summary['subtotal']; ?></strong>
</div>

<!-- DISCOUNT -->
<div class="d-flex justify-content-between py-2">
    <span>Discount</span>
    <strong class="text-success">-₹<?= $cart_summary['discount']; ?></strong>
</div>

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
</div>-->

<!-- IGST -
<div id="igst-row" style="display:none;">
    <div class="d-flex justify-content-between small text-muted">
        <span>IGST (5%)</span>
        <span id="igst">₹0</span>
    </div>
            </div   >
            

GST TOTAL 
<tr>
    <td>GST (5%)</td>
    <td>₹ <span id="gst">0</span></td>
</tr>
            -->
<!-- CGST 
<tr id="cgst-row" style="font-size: 13px; color: gray;">
    <td>&nbsp;&nbsp;CGST (2.5%)</td>
    <td>₹ <span id="cgst">0</span></td>
</tr>-->

<!-- SGST 
<tr id="sgst-row" style="font-size: 13px; color: gray;">
    <td>&nbsp;&nbsp;SGST (2.5%)</td>
    <td>₹ <span id="sgst">0</span></td>
</tr>-->

<!-- IGST 
<tr id="igst-row" style="font-size: 13px; color: gray; display:none;">
    <td>&nbsp;&nbsp;IGST (5%)</td>
    <td>₹ <span id="igst">0</span></td>
</tr>-->

<!--
<div class="summary-row d-flex justify-content-between">
    <span>GST (5%)</span>
    <span><span id="gst">0</span></span>
</div>

<div id="cgst-row" class="summary-sub text-muted small d-flex justify-content-between">
    <span style="padding-left:20px;">CGST (2.5%)</span>
    <span><span id="cgst">0</span></span>
</div>

<div id="sgst-row" class="summary-sub text-muted small d-flex justify-content-between">
    <span style="padding-left:20px;">SGST (2.5%)</span>
    <span><span id="sgst">0</span></span>
</div>

<div id="igst-row" class="summary-sub text-muted small d-flex justify-content-between" style="display:none;">
    <span style="padding-left:20px;">IGST (5%)</span>
    <span><span id="igst">0</span></span>
</div>-->


<div class="summary-row d-flex justify-content-between">
    <span>GST (5%)</span>
    <span>₹<?= $cart_summary['gst']; ?></span>
</div>

<?php if ($cart_summary['igst'] > 0): ?>

    <!-- IGST -->
    <div class="summary-sub text-muted small d-flex justify-content-between">
        <span style="padding-left:20px;">IGST (5%)</span>
        <span>₹<?= $cart_summary['igst']; ?></span>
    </div>

<?php else: ?>

    <!-- CGST + SGST -->
    <div class="summary-sub text-muted small d-flex justify-content-between">
        <span style="padding-left:20px;">CGST (2.5%)</span>
        <span>₹<?= $cart_summary['cgst']; ?></span>
    </div>

    <div class="summary-sub text-muted small d-flex justify-content-between">
        <span style="padding-left:20px;">SGST (2.5%)</span>
        <span>₹<?= $cart_summary['sgst']; ?></span>
    </div>

<?php endif; ?>


<!-- SHIPPING -->
<div class="d-flex justify-content-between py-2">
    <span>Shipping</span>
    <strong>₹99</strong>
</div>

<hr>
<div class="d-flex justify-content-between py-2">
    <span>Total</span>
    <strong>₹<?= $cart_summary['total']; ?></strong>
</div>

<!--

<div class="d-flex justify-content-between py-2">
    <span>Total</span>
    <strong><span id="cart-total">0</span></strong>
</div>-->
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

<!--
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

-->

<!--
<script>
function updateCartTotal() {
    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    // ✅ get discount (from UI or default 0)
    let discount = parseFloat($('#discount').text()) || 0;

    let afterDiscount = subtotal - discount;

    // ✅ GST after discount
    let gst = (afterDiscount * 5) / 100;

    let shipping = 99;

    let total = afterDiscount + gst + shipping;

    // ✅ update UI
    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text(discount.toFixed(2));
    $('#gst').text(gst.toFixed(2));
    $('#cart-total').text('₹' + total.toLocaleString());
}
</script>
-->

<!--
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
             //   $('#cart-subtotal').text('₹' + data.subtotal);
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
</script>    -->


<!--
<script>

let appliedCoupon = null;

// 🔥 MAIN CALCULATION
function calculateSummary() {

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    // ✅ DISCOUNT
    let discount = 0;

    if (appliedCoupon) {

        if (appliedCoupon.type === 'percent') {
            discount = (subtotal * appliedCoupon.value) / 100;
        } else {
            discount = appliedCoupon.value;
        }

        if (discount > subtotal) discount = subtotal;
    }

    let afterDiscount = subtotal - discount;

    // ✅ GST
    let gst = afterDiscount * 0.05;

    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    // ✅ UI UPDATE
    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('-₹' + Math.round(discount));
    $('#gst-total').text('₹' + Math.round(gst));
    $('#cart-total').text('₹' + Math.round(total));
}

// 🔥 APPLY COUPON
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

    // ✅ USE BACKEND VALUES DIRECTLY
    $('#cart-subtotal').text('₹' + data.subtotal);
    $('#discount').text('-₹' + data.discount);

    // ✅ GST SPLIT
    $('#cgst').text('₹' + data.cgst);
    $('#sgst').text('₹' + data.sgst);

    // (optional)
    $('#gst').text('₹' + data.gst);

    $('#cart-total').text('₹' + data.final_total);
}
        }
    });

});

// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {
   // calculateSummary();
});

// 🔥 PAGE LOAD
$(document).ready(function () {
    //calculateSummary();
        $('#apply_coupon').click();


});

</script>

-->


<!--

<script>

let appliedCoupon = null;
let couponApplied = false; // ✅ ADD

// 🔥 MAIN CALCULATION (ONLY WHEN NO COUPON)
function calculateSummary() {

    if (couponApplied) return; // ✅ STOP if coupon applied

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    let discount = 0;
    let afterDiscount = subtotal;

    let gst = (afterDiscount * 5) / 100;

    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('-₹0');
    $('#gst').text('₹' + Math.round(gst)); // ✅ FIX ID
    $('#cart-total').text('₹' + Math.round(total));
}


// 🔥 APPLY COUPON
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

                couponApplied = true; // ✅ ADD

                $('#coupon_msg').html("✅ " + data.message);

                $('#cart-subtotal').text('₹' + data.subtotal);
                $('#discount').text('-₹' + data.discount);

                $('#cgst').text('₹' + data.cgst);
                $('#sgst').text('₹' + data.sgst);

              //  $('#gst').text('₹' + data.gst); // ✅ FIX ID

                $('#cart-total').text('₹' + data.final_total);
            }
        }
    });

});


// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {

    if (couponApplied) {
        $('#apply_coupon').click(); // ✅ backend recalc
    } else {
        calculateSummary(); // ✅ normal calc
    }
});


// 🔥 PAGE LOAD
$(document).ready(function () {

    let code = $('#coupon_code').val();

    if (code) {
        $('#apply_coupon').click(); // only if coupon exists
    } else {
        calculateSummary(); // ✅ IMPORTANT
    }
});

</script>
-->


<!--


<script>

let couponApplied = false;

// 🔥 MAIN CALCULATION (NO COUPON)
function calculateSummary() {

    if (couponApplied) return;

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    let afterDiscount = subtotal;

    let gst = (afterDiscount * 5) / 100;
    let half = gst / 2;

    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('-₹0');
    $('#gst').text('₹' + Math.round(gst));

    // ✅ ADD HERE
    $('#igst-row').hide();
    $('#cgst-row').show();
    $('#sgst-row').show();

    $('#cgst').text('₹' + Math.round(half));
    $('#sgst').text('₹' + Math.round(half));

    $('#cart-total').text('₹' + Math.round(total));
}

// 🔥 APPLY COUPON
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

        couponApplied = true;

        $('#coupon_msg').html("✅ " + data.message);

        // ✅ Subtotal & Discount
        $('#cart-subtotal').text('₹' + data.subtotal);
        $('#discount').text('-₹' + data.discount);

        // ✅ GST TOTAL
        $('#gst').text('₹' + data.gst);

        // 🔥 IGST / CGST LOGIC (FINAL)
        if (data.igst > 0) {

            // 👉 OTHER STATE → IGST
            $('#cgst-row').hide();
            $('#sgst-row').hide();

            $('#igst-row').show();
            $('#igst').text('₹' + data.igst);

            // reset others
            $('#cgst').text('₹0');
            $('#sgst').text('₹0');

        } else {

            // 👉 MAHARASHTRA → CGST + SGST
            $('#igst-row').hide();

            $('#cgst-row').show();
            $('#sgst-row').show();

            $('#cgst').text('₹' + data.cgst);
            $('#sgst').text('₹' + data.sgst);

            // reset igst
            $('#igst').text('₹0');
        }

        // ✅ TOTAL
        $('#cart-total').text('₹' + data.final_total);
    }
}
        
    });

});


// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {

    const btn = $(this);
    const input = $(btn.data('qty-target'));
    const row = input.closest('.cart-line');

    let qty = parseInt(input.val()) || 1;

    if (btn.data('qty-action') === 'increase') qty++;
    else if (qty > 1) qty--;

    input.val(qty);

    let product_id = row.data('product-id'); // ✅ FIX

    let token = localStorage.getItem("token");

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            product_id: product_id,   // ✅ IMPORTANT
            quantity: qty
        },
        success: function () {

            if (couponApplied) {
                $('#apply_coupon').click();
            } else {
                calculateSummary();
            }
        }
    });
});


// 🔥 PAGE LOAD
$(document).ready(function () {

    let code = $('#coupon_code').val();

    if (code) {
        $('#apply_coupon').click();
    } else {
        calculateSummary();
    }
});

</script>


-->


<!--
<script>

let couponApplied = false;


// 🔥 MAIN CALCULATION (NO COUPON)
function calculateSummary() {

    if (couponApplied) return;

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    let gst = (subtotal * 5) / 100;
    let half = gst / 2;

    let shipping = 99;
    let total = subtotal + gst + shipping;

    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('-₹0');
    $('#gst').text('₹' + Math.round(gst));

    // ✅ Default CGST + SGST
    $('#igst-row').hide();
    $('#cgst-row').show();
    $('#sgst-row').show();

    $('#cgst').text('₹' + Math.round(half));
    $('#sgst').text('₹' + Math.round(half));

    $('#cart-total').text('₹' + Math.round(total));
}


// 🔥 APPLY COUPON
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

                couponApplied = true;

                $('#coupon_msg').html("✅ " + data.message);

                $('#cart-subtotal').text('₹' + data.subtotal);
                $('#discount').text('-₹' + data.discount);
                $('#gst').text('₹' + data.gst);

                // 🔥 IGST / CGST
                if (data.igst > 0) {

                    $('#cgst-row').hide();
                    $('#sgst-row').hide();

                    $('#igst-row').show();
                    $('#igst').text('₹' + data.igst);

                } else {

                    $('#igst-row').hide();

                    $('#cgst-row').show();
                    $('#sgst-row').show();

                    $('#cgst').text('₹' + data.cgst);
                    $('#sgst').text('₹' + data.sgst);
                }

                $('#cart-total').text('₹' + data.final_total);
            }
        }
    });

});


// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {

    const btn = $(this);
    const input = $(btn.data('qty-target'));
    const row = input.closest('.cart-line');

    let qty = parseInt(input.val()) || 1;

    if (btn.data('qty-action') === 'increase') qty++;
    else if (qty > 1) qty--;

    input.val(qty);

    let product_id = row.data('product-id');
    let token = localStorage.getItem("token");

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            product_id: product_id,
            quantity: qty
        },
        success: function () {

            if (couponApplied) {
                $('#apply_coupon').click();
            } else {
                calculateSummary();
            }
        }
    });
});


// 🔥 PAGE LOAD
$(document).ready(function () {

    let code = $('#coupon_code').val();

    if (code) {
        $('#apply_coupon').click();
    } else {
        calculateSummary();
    }
});

</script>
-->

<!--
<script>

let couponApplied = false;


// 🔥 APPLY COUPON (ONLY UI UPDATE, NO GST CALCULATION)
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

                couponApplied = true;

                $('#coupon_msg').html("✅ " + data.message);

                // 🔥 simplest & safest
                location.reload(); // ✅ reload to use PHP summary
            }
        }
    });

});


// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {

    const btn = $(this);
    const input = $(btn.data('qty-target'));
    const row = input.closest('.cart-line');

    let qty = parseInt(input.val()) || 1;

    if (btn.data('qty-action') === 'increase') qty++;
    else if (qty > 1) qty--;

    input.val(qty);

    let product_id = row.data('product-id');
    let token = localStorage.getItem("token");

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            product_id: product_id,
            quantity: qty
        },
        success: function () {
            location.reload(); // ✅ always reload (correct totals)
        }
    });

});


// 🔥 PAGE LOAD (NO JS CALCULATION)
$(document).ready(function () {
    // nothing needed now
});

</script>

-->

<script>

let couponApplied = false;


// 🔥 APPLY COUPON
$('#apply_coupon').click(function () {

    let code = $('#coupon_code').val().trim();
    let token = localStorage.getItem("token");
    let state = "<?= $user_state ?? 'Other' ?>";

    if (!code) {
        $('#coupon_msg').html("❌ Enter coupon code");
        return;
    }

    if (!token) {
        alert("Please login first");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/api_handler/apply_coupon') ?>",
        type: "POST",
        dataType: "json", // ✅ FIX 1 (no need JSON.parse)
       // headers: {
         //   "Authorization": "Bearer " + token
        //},
        data: {
            coupon_code: code,
            state: state
        },

        success: function (data) {

            if (data.status) {

                $('#coupon_msg').html("✅ " + data.message);

                // ✅ reload to use session + PHP summary
                location.reload();

            } else {
                $('#coupon_msg').html("❌ " + data.message);
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText); // 🔥 debug
            alert("Something went wrong");
        }
    });

});


// 🔥 QTY CHANGE
$(document).on('click', '[data-qty-action]', function () {

    const btn = $(this);
    const input = $(btn.data('qty-target'));
    const row = input.closest('.cart-line');

    let qty = parseInt(input.val()) || 1;

    if (btn.data('qty-action') === 'increase') qty++;
    else if (qty > 1) qty--;

    input.val(qty);

    let product_id = row.data('product-id');
    let token = localStorage.getItem("token");

    if (!token) {
        alert("Please login first");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/update_cart_quantity') ?>",
        type: "POST",
        dataType: "json", // ✅ FIX 2
        headers: {
            "Authorization": "Bearer " + token
        },
        data: {
            product_id: product_id,
            quantity: qty
        },

        success: function (res) {
            if (res.status) {
                location.reload(); // ✅ correct totals
            } else {
                alert(res.message);
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Update failed");
        }
    });

});

</script>
<script>
$(document).on('click', '.cart-remove-btn', function () {

    let product_id = $(this).data('product-id'); // ✅ correct

    if (!product_id) {
        console.log("Product ID missing");
        return;
    }

    if (!confirm("Remove this item?")) return;

    let token = localStorage.getItem("token");

    if (!token) {
        alert("Please login first");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/remove_from_cart') ?>",
        type: "POST",
        dataType: "json",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: { product_id: product_id }, // ✅ correct

        success: function (res) {
            if (res.status) {
                location.reload();
            } else {
                alert(res.message);
            }
        }
    });
});
</script>

<!--
<script>
$(document).on('click', '.cart-remove-btn', function () {

    let cart_id = $(this).data('cart-id');

    if (!cart_id) {
        console.log("Cart ID missing");
        return;
    }

    if (!confirm("Remove this item?")) return;

    // ✅ FIX: define token
    let token = localStorage.getItem("token");

    if (!token) {
        alert("Please login first");
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/Api_handler/remove_from_cart') ?>", // ⚠️ also fix API
        type: "POST",
        dataType: "json",
        headers: {
            "Authorization": "Bearer " + token
        },
        data: { product_id: cart_id }, // ⚠️ see note below

        success: function (res) {

            if (res.status) {
                location.reload();
            } else {
                alert(res.message);
            }
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Server error");
        }
    });

});
</script>
-->
<!--

<script>

function calculateSummary() {

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    let discount = 0;
    let afterDiscount = subtotal - discount;

    let gst = afterDiscount * 0.05;
    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#gst-total').text('₹' + Math.round(gst));
    $('#cart-total').text('₹' + Math.round(total));
}

// ✅ CALL OUTSIDE FUNCTION
$(document).ready(function () {
    calculateSummary();
});

</script>-->
<!--
<script>
function calculateSummary() {

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    // ✅ DISCOUNT CALCULATION
    let discount = 0;

    if (appliedCoupon) {
        if (appliedCoupon.type === 'percent') {
            discount = (subtotal * appliedCoupon.value) / 100;
        } else {
            discount = appliedCoupon.value;
        }

        if (discount > subtotal) discount = subtotal;
    }

    let afterDiscount = subtotal - discount;

    // ✅ GST
    let gst = afterDiscount * 0.05;

    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    // ✅ UI UPDATE
    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#discount').text('-₹' + Math.round(discount));
    $('#gst-total').text('₹' + Math.round(gst));
    $('#cart-total').text('₹' + Math.round(total));
}
</script>
-->
<!--
<script>
function calculateSummary() {

    let subtotal = 0;

    $('.cart-line').each(function () {
        let price = parseFloat($(this).data('price')) || 0;
        let qty = parseInt($(this).find('.cart-qty-input').val()) || 1;

        subtotal += price * qty;
    });

    let discount = parseFloat($('#discount').text().replace('₹','')) || 0;

    let afterDiscount = subtotal - discount;

    let gst = afterDiscount * 0.05;
    let shipping = 99;
    let total = afterDiscount + gst + shipping;

    $('#cart-subtotal').text('₹' + subtotal.toLocaleString());
    $('#gst-total').text('₹' + Math.round(gst));
    $('#cart-total').text('₹' + Math.round(total));
}

$(document).ready(function () {
    calculateSummary();
       // $('#apply_coupon').click();

});

</script>
-->

<!--
<script>


function updateGSTUI(data, state) {

    $('#gst-total').text('₹' + data.gst);

    if (state.toLowerCase().trim() === "maharashtra") {

        $('#cgst-sgst-row').show();
        $('#igst-row').hide();

        $('#cgst-amount').text('₹' + data.cgst);
        $('#sgst-amount').text('₹' + data.sgst);

    } else {

        $('#cgst-sgst-row').hide();
        $('#igst-row').show();

        $('#igst-amount').text('₹' + data.igst);
    }
}
    </script>


-->


<script>
    $('#remove_coupon').click(function () {

    $.ajax({
        url: "<?= base_url('index.php/api_handler/remove_coupon') ?>",
        type: "POST",
        success: function (res) {

            let data = (typeof res === "string") ? JSON.parse(res) : res;

            if (data.status) {
                alert(data.message); // or Swal
                location.reload();  // ✅ refresh cart
            }
        }
    });

});
</script>