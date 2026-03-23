<section class="row g-3 mt-1">
    <?php foreach ($kpis as $kpi): ?>
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card">
                <div class="d-flex justify-content-between">
                    <div class="metric-title"><?php echo html_escape($kpi['title']); ?></div>
                    <span class="kpi-badge <?php echo html_escape($kpi['trend_class']); ?>"><?php echo html_escape($kpi['trend']); ?></span>
                </div>
                <p class="metric-value"><?php echo html_escape($kpi['value']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<section class="row g-3 mt-1">
    <div class="col-xl-8">
        <div class="panel-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="panel-title mb-0">Top Selling Products</h2>
                <a href="<?php echo site_url('admin/products'); ?>" class="btn btn-sm btn-outline-secondary">View all</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td>Heavy Duty Garbage Bag 50L</td><td>Plastic Bags</td><td>$4.20</td><td>2,480</td><td><span class="status-pill status-live">In Stock</span></td></tr>
                    <tr><td>RFID Tamper Seal - Pack of 100</td><td>RFID Seals</td><td>$29.00</td><td>110</td><td><span class="status-pill status-low">Low Stock</span></td></tr>
                    <tr><td>Silver Foil Sheet Roll 1kg</td><td>Silver Foil</td><td>$12.70</td><td>0</td><td><span class="status-pill status-out">Out of Stock</span></td></tr>
                    <tr><td>A4 Copier Paper Bundle</td><td>Stationery</td><td>$7.95</td><td>420</td><td><span class="status-pill status-live">In Stock</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="panel-card">
            <h2 class="panel-title mb-3">Recent Activity</h2>
            <div class="list-item"><strong>Order #PM-2901 shipped</strong><p class="text-muted mb-0 small">2 minutes ago</p></div>
            <div class="list-item"><strong>New supplier quote uploaded</strong><p class="text-muted mb-0 small">17 minutes ago</p></div>
            <div class="list-item"><strong>RFID seal stock adjusted (+500)</strong><p class="text-muted mb-0 small">43 minutes ago</p></div>
            <div class="list-item"><strong>Coupon BULK5 activated</strong><p class="text-muted mb-0 small">1 hour ago</p></div>
        </div>
    </div>
</section>
