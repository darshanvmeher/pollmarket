<?php
$order_code = '#PM-' . str_pad((int) ($order['id'] ?? 0), 4, '0', STR_PAD_LEFT);
$status = strtolower(trim((string) ($order['order_status'] ?? 'pending')));
$status_class = 'status-low';
if (in_array($status, array('delivered', 'confirmed', 'shipped'), true)) {
    $status_class = 'status-live';
} elseif (in_array($status, array('cancelled', 'returned'), true)) {
    $status_class = 'status-out';
}

$customer_name = trim((string) ($order['customer_name'] ?? ''));
if ($customer_name === '') {
    $customer_name = 'Customer';
}

$address_parts = array_filter(array(
    $order['address'] ?? '',
    $order['city'] ?? '',
    $order['state'] ?? '',
    $order['pincode'] ?? '',
    $order['country'] ?? ''
));
?>

<style>
.order-detail-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.45fr) minmax(320px, 0.95fr);
    gap: 1.25rem;
}

.order-detail-hero {
    padding: 1.35rem;
    border-radius: 24px;
    background: linear-gradient(135deg, #0f1720 0%, #163246 44%, #0d9488 100%);
    color: #fff;
}

.order-detail-hero__top {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.2rem;
}

.order-detail-hero__code {
    font-size: 1.55rem;
    font-weight: 800;
}

.order-detail-hero__meta {
    color: rgba(255,255,255,0.74);
    font-size: 0.92rem;
}

.order-detail-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.85rem;
}

.order-detail-stat {
    padding: 0.85rem 0.95rem;
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.08);
}

.order-detail-stat span {
    display: block;
    color: rgba(255,255,255,0.7);
    font-size: 0.76rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

.order-detail-stat strong {
    display: block;
    margin-top: 0.35rem;
    font-size: 1rem;
}

.order-detail-stack {
    display: grid;
    gap: 1rem;
}

.order-item-list {
    display: grid;
    gap: 0.85rem;
}

.order-item-card {
    display: grid;
    grid-template-columns: 72px minmax(0, 1fr) auto;
    gap: 0.9rem;
    align-items: center;
    padding: 0.9rem;
    border: 1px solid #e5edf3;
    border-radius: 20px;
    background: #fff;
}

.order-item-thumb {
    width: 72px;
    height: 72px;
    border-radius: 16px;
    overflow: hidden;
    background: #eef4f8;
}

.order-item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.order-item-name {
    font-weight: 800;
    color: #102029;
}

.order-item-sub {
    color: #6b7f8c;
    font-size: 0.88rem;
}

.order-item-total {
    text-align: right;
    font-weight: 800;
    color: #102029;
}

.order-kv {
    display: grid;
    gap: 0.8rem;
}

.order-kv-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    font-size: 0.92rem;
}

.order-kv-row span:first-child {
    color: #6b7f8c;
}

.order-kv-row span:last-child {
    color: #102029;
    text-align: right;
    font-weight: 700;
}

.order-status-form {
    display: grid;
    gap: 0.9rem;
}

.order-status-form .form-select {
    font-weight: 700;
}

.order-status-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

@media (max-width: 1199.98px) {
    .order-detail-layout {
        grid-template-columns: 1fr;
    }

    .order-detail-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 767.98px) {
    .order-detail-hero__top,
    .order-kv-row,
    .order-item-card {
        grid-template-columns: 1fr;
        flex-direction: column;
        align-items: flex-start;
    }

    .order-detail-stats {
        grid-template-columns: 1fr;
    }

    .order-item-total,
    .order-kv-row span:last-child {
        text-align: left;
    }
}
</style>

<section class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
    <div>
        <h1 class="page-title mb-1"><?php echo html_escape($title); ?></h1>
        <p class="page-subtitle mb-0"><?php echo html_escape($subtitle); ?></p>
    </div>
    <a class="btn btn-light" href="<?php echo site_url('admin/orders'); ?>">
        <i class="bi bi-arrow-left me-1"></i>Back to Orders
    </a>
</section>

<!-- <?php if (!empty($updated)): ?>
    <div class="alert alert-success mt-3 mb-0">Order status updated successfully.</div>
<?php endif; ?> -->



<?php if (!empty($updated)): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Order status updated successfully!',
        confirmButtonColor: '#3085d6'
    });
});
</script>
<?php endif; ?>


<section class="order-detail-layout mt-3">
    <div class="order-detail-stack">
        <div class="panel-card order-detail-hero">
            <div class="order-detail-hero__top">
                <div>
                    <div class="order-detail-hero__code"><?php echo html_escape($order_code); ?></div>
                    <div class="order-detail-hero__meta">
                        <?php echo !empty($order['created_at']) ? date('d M Y, h:i A', strtotime($order['created_at'])) : 'N/A'; ?>
                    </div>
                </div>
                <span class="status-pill <?php echo $status_class; ?>"><?php echo html_escape(ucfirst($status)); ?></span>
            </div>

            <div class="order-detail-stats">
                <div class="order-detail-stat">
                    <span>Customer</span>
                    <strong><?php echo html_escape($customer_name); ?></strong>
                </div>
                <div class="order-detail-stat">
                    <span>Total Amount</span>
                    <strong>Rs. <?php echo number_format((float) ($order['total_amount'] ?? 0), 2); ?></strong>
                </div>
                <div class="order-detail-stat">
                    <span>Payment</span>
                    <strong><?php echo html_escape($order['payment_status'] ?? 'Pending'); ?></strong>
                </div>
                <div class="order-detail-stat">
                    <span>Items</span>
                    <strong><?php echo count($order_items ?? array()); ?> lines</strong>
                </div>
            </div>
        </div>

        <section class="panel-card">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h2 class="panel-title mb-0">Order Items</h2>
                    <p class="page-subtitle mt-1 mb-0">Full item view for this particular order.</p>
                </div>
            </div>

            <div class="order-item-list">
                <?php if (!empty($order_items)): ?>
                    <?php foreach ($order_items as $item): ?>
                        <article class="order-item-card">
                            <div class="order-item-thumb">
                                <img src="<?php echo base_url($item['image_url'] ?? 'assets/no-image.png'); ?>" alt="<?php echo html_escape($item['product_name'] ?? 'Product'); ?>">
                            </div>
                            <div>
                                <div class="order-item-name"><?php echo html_escape($item['product_name'] ?? 'Product'); ?></div>
                                <div class="order-item-sub">Quantity: <?php echo (int) ($item['quantity'] ?? 0); ?></div>
                                <!-- <div class="order-item-sub">Product ID: <?php echo (int) ($item['product_id'] ?? 0); ?></div> -->
                            </div>
                            <div class="order-item-total">
                                Rs. <?php echo number_format((float) ($item['price'] ?? 0), 2); ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-muted">No items found for this order.</div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="order-detail-stack">
        <section class="panel-card">
            <h2 class="panel-title mb-3">Change Order Status</h2>
            <form method="post" class="order-status-form">
                <div>
                    <label class="form-label fw-semibold">Current Status</label>
                    <select class="form-select" name="order_status">
                        <?php foreach ($status_options as $status_option): ?>
                            <option value="<?php echo html_escape($status_option); ?>" <?php echo $status === $status_option ? 'selected' : ''; ?>>
                                <?php echo ucfirst($status_option); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="order-status-actions">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-check2-circle me-1"></i>Update Status
                    </button>
                    <a class="btn btn-light" href="<?php echo site_url('admin/orders'); ?>">Cancel</a>
                </div>
            </form>
        </section>

        <section class="panel-card">
            <h2 class="panel-title mb-3">Customer Details</h2>
            <div class="order-kv">
                <div class="order-kv-row">
                    <span>Name</span>
                    <span><?php echo html_escape($customer_name); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Email</span>
                    <span><?php echo html_escape($order['customer_email'] ?? 'N/A'); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Phone</span>
                    <span><?php echo html_escape($order['customer_phone'] ?? 'N/A'); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Shipping Address</span>
                    <span><?php echo html_escape(!empty($address_parts) ? implode(', ', $address_parts) : 'N/A'); ?></span>
                </div>
            </div>
        </section>

        <section class="panel-card">
            <h2 class="panel-title mb-3">Order Summary</h2>
            <div class="order-kv">
                <div class="order-kv-row">
                    <span>Subtotal</span>
                    <span>Rs. <?php echo number_format((float) ($order['subtotal'] ?? 0), 2); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Discount</span>
                    <span>Rs. <?php echo number_format((float) ($order['discount_value'] ?? 0), 2); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>GST</span>
                    <span>Rs. <?php echo number_format((float) ($order['gst'] ?? 0), 2); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Shipping</span>
                    <span>Rs. <?php echo number_format((float) ($order['shipping'] ?? 0), 2); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Total</span>
                    <span>Rs. <?php echo number_format((float) ($order['total_amount'] ?? 0), 2); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Payment Method</span>
                    <span><?php echo html_escape($order['payment_method'] ?? 'N/A'); ?></span>
                </div>
                <div class="order-kv-row">
                    <span>Transaction ID</span>
                    <span><?php echo html_escape($order['transaction_id'] ?? 'N/A'); ?></span>
                </div>
            </div>
        </section>
    </div>
</section>
