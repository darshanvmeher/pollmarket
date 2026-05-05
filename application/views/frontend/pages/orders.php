<?php $this->load->view('frontend/partials/header'); ?>

<?php
$customer_name = trim(($customer['firstname'] ?? '') . ' ' . ($customer['lastname'] ?? ''));
if ($customer_name === '') {
    $customer_name = $customer['email'] ?? 'Customer';
}
?>

<div class="row g-4">
    <div class="col-lg-3">
        <div class="surface-card p-3">
            <div class="fw-bold mb-1"><?php echo html_escape($customer_name); ?></div>
            <div class="text-muted small mb-3">Customer account</div>
            <div class="d-grid gap-2">
                <a class="chip" href="<?php echo site_url('frontend/account'); ?>">Dashboard</a>
                <a class="chip active" href="<?php echo site_url('frontend/orders'); ?>">Orders</a>
                <a class="chip" href="<?php echo site_url('frontend/checkout'); ?>">Checkout</a>
                <a class="chip" href="<?php echo site_url('frontend/contact'); ?>">Support</a>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="section-heading">
            <div class="section-kicker">Order History</div>
            <h1 class="section-title">All orders placed from your Pollmarket account</h1>
            <p class="section-copy">Review every order, see line items, check statuses, and keep a clean history of what has already been requested or purchased.</p>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="orders-history-grid">
                <?php foreach ($orders as $order): ?>
                    <?php
                    $status = strtolower(trim((string) ($order['order_status'] ?? 'pending')));
                    $status_class = 'is-pending';
                    if (in_array($status, array('confirmed', 'shipped', 'delivered'), true)) {
                        $status_class = 'is-success';
                    } elseif (in_array($status, array('cancelled', 'returned'), true)) {
                        $status_class = 'is-danger';
                    } elseif ($status === 'packed') {
                        $status_class = 'is-info';
                    }

                    $address_parts = array_filter(array(
                        $order['address'] ?? '',
                        $order['city'] ?? '',
                        $order['state'] ?? '',
                        $order['pincode'] ?? '',
                        $order['country'] ?? ''
                    ));
                    ?>
                    <article class="surface-card orders-history-card p-4">
                        <div class="orders-history-card__top">
                            <div>
                                <div class="orders-history-card__code">#PM-<?php echo str_pad((int) ($order['id'] ?? 0), 4, '0', STR_PAD_LEFT); ?></div>
                                <div class="text-muted small">
                                    <?php echo !empty($order['created_at']) ? date('d M Y, h:i A', strtotime($order['created_at'])) : 'N/A'; ?>
                                </div>
                            </div>
                            <span class="orders-history-status <?php echo $status_class; ?>">
                                <?php echo html_escape(ucfirst($status)); ?>
                            </span>
                        </div>

                        <div class="orders-history-summary">
                            <div class="orders-history-summary__item">
                                <span>Total Amount</span>
                                <strong>Rs. <?php echo number_format((float) ($order['total_amount'] ?? 0), 2); ?></strong>
                            </div>
                            <div class="orders-history-summary__item">
                                <span>Total Items</span>
                                <strong><?php echo (int) ($order['total_quantity'] ?? 0); ?></strong>
                            </div>
                            <div class="orders-history-summary__item">
                                <span>Payment</span>
                                <strong><?php echo html_escape($order['payment_status'] ?? 'Pending'); ?></strong>
                            </div>
                        </div>

                        <div class="orders-history-meta-grid">
                            <div class="orders-history-meta-card">
                                <div class="orders-history-meta-card__label">Products</div>
                                <div class="orders-history-meta-card__value">
                                    <?php echo html_escape($order['product_names'] ?? 'No products listed'); ?>
                                </div>
                            </div>
                            <div class="orders-history-meta-card">
                                <div class="orders-history-meta-card__label">Shipping Address</div>
                                <div class="orders-history-meta-card__value">
                                    <?php echo html_escape(!empty($address_parts) ? implode(', ', $address_parts) : 'Address details unavailable'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="orders-history-items">
                            <?php if (!empty($order['items'])): ?>
                                <?php foreach ($order['items'] as $item): ?>
                                    <div class="orders-history-item">
                                        <div class="orders-history-item__thumb">
                                            <img src="<?php echo base_url($item['image_url'] ?? 'assets/no-image.png'); ?>" alt="<?php echo html_escape($item['product_name'] ?? 'Product'); ?>">
                                        </div>
                                        <div class="orders-history-item__content">
                                            <div class="orders-history-item__name"><?php echo html_escape($item['product_name'] ?? 'Product'); ?></div>
                                            <div class="orders-history-item__sub">
                                                Qty <?php echo (int) ($item['quantity'] ?? 0); ?>
                                                <?php if (!empty($item['badge'])): ?>
                                                    <span class="orders-history-item__dot">•</span>
                                                    <?php echo html_escape($item['badge']); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="orders-history-item__price">
                                            Rs. <?php echo number_format((float) ($item['price'] ?? 0), 2); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="surface-card p-4 p-lg-5 orders-history-empty">
                <div class="orders-history-empty__icon"><i class="bi bi-bag-x"></i></div>
                <h2 class="h4 fw-bold mb-2">No orders yet</h2>
                <p class="text-muted mb-4">Once you place your first order, it will appear here with status, products, and order details.</p>
                <a class="btn btn-primary" href="<?php echo site_url('frontend/shop'); ?>">Start Shopping</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
