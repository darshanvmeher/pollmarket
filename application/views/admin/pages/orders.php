<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="panel-title mb-0"><?php echo html_escape($table_title ?? 'Orders'); ?></h2>
            <p class="page-subtitle mt-1">See every order in one listing, then open a dedicated page to review full details and update status.</p>
        </div>
        <span class="quick-chip"><i class="bi bi-receipt me-1"></i><?php echo count($rows ?? array()); ?> Orders</span>
    </div>

    <div class="table-responsive">
        <table id="myTable" class="table align-middle">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Products</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $status = strtolower(trim((string) ($row['Status'] ?? 'pending')));
                        $status_class = 'status-low';
                        if (in_array($status, array('delivered', 'confirmed', 'shipped'), true)) {
                            $status_class = 'status-live';
                        } elseif (in_array($status, array('cancelled', 'returned'), true)) {
                            $status_class = 'status-out';
                        }
                        ?>
                        <tr>
                            <td>
                                <div class="fw-semibold">#PM-<?php echo str_pad((int) ($row['Order'] ?? 0), 4, '0', STR_PAD_LEFT); ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo html_escape($row['Customer'] ?? 'Customer'); ?></div>
                            </td>
                            <td>
                                Rs. <?php echo number_format((float) ($row['Amount'] ?? 0), 2); ?>
                            </td>
                            <td>
                                <div class="small text-muted" style="max-width: 300px;">
                                    <?php echo html_escape($row['Products'] ?? ''); ?>
                                </div>
                            </td>
                            <td>
                                <?php echo (int) ($row['Items'] ?? 0); ?>
                            </td>
                            <td>
                                <span class="status-pill <?php echo $status_class; ?>">
                                    <?php echo html_escape(ucfirst($status)); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo !empty($row['Date']) ? date('d M Y, h:i A', strtotime($row['Date'])) : 'N/A'; ?>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-primary" href="<?php echo site_url('admin/orders/' . (int) ($row['Order'] ?? 0)); ?>">
                                    <i class="bi bi-eye me-1"></i>View Order
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
