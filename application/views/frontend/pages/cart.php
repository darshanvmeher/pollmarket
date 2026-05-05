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