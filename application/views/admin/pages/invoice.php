<style>
.invoice-shell {
    background: linear-gradient(135deg, #f6f8fc 0%, #edf2f9 100%);
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 20px;
    padding: 24px;
}

.invoice-paper {
    background: #fff;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
}

.invoice-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e5e7eb;
}

.invoice-brand {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: #0f172a;
}

.invoice-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    border-radius: 999px;
    background: #fff7ed;
    color: #c2410c;
    font-weight: 700;
}

.invoice-block {
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 18px;
    height: 100%;
}

.invoice-block--soft {
    background: #f8fafc;
}

.invoice-block__label {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 10px;
}

.invoice-block__title {
    font-size: 1.1rem;
    font-weight: 800;
}

.invoice-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.invoice-table tbody td {
    border-color: #eef2f7;
    padding-top: 16px;
    padding-bottom: 16px;
}

.invoice-summary {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px;
}

.invoice-footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 12px;
    padding-top: 18px;
    border-top: 1px solid #e5e7eb;
}

@media print {
    .sidebar, .topbar, .panel-card .btn, .btn, .sidebar-overlay {
        display: none !important;
    }

    .panel-card {
        border: 0;
        box-shadow: none;
        padding: 0;
        margin: 0;
    }

    .invoice-shell {
        background: transparent;
        border: 0;
        padding: 0;
    }

    .invoice-paper {
        box-shadow: none;
        padding: 0;
    }
}
</style>

<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h2 class="panel-title mb-1">Invoice Generator</h2>
            <p class="page-subtitle mb-0"><?php echo html_escape($subtitle ?? 'Design-only invoice preview for admin use.'); ?></p>
        </div>
        <div class="d-flex gap-2 flex-wrap no-print">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-printer me-1"></i>Print Invoice
            </button>
           <!-- <button class="btn btn-primary">
                <i class="bi bi-file-earmark-arrow-down me-1"></i>Download PDF
            </button>
            -->
            <button type="button"
                class="btn btn-success"
                onclick="downloadInvoicePdf(<?= $invoice_meta['invoice_id']; ?>)">Download PDF
            </button>
            <a href="javascript:void(0);"
                class="btn btn-success"
                onclick="saveInvoice(<?= $invoice_meta['invoice_id']; ?>)">Save Invoice</a>
        </div>
    </div>

    <div class="invoice-shell">
        <div class="invoice-paper">
            <div class="invoice-header">
                <div>
                    <div class="invoice-brand">PackMart Wholesale</div>
                    <div class="text-muted small">Industrial packaging and business supply</div>
                </div>
                <div class="text-end">
                    <div class="invoice-badge">Draft Invoice</div>
                    <div class="text-muted small mt-2">Invoice #<?php echo html_escape($invoice_meta['invoice_no']); ?></div>
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-md-6">
                    <div class="invoice-block">
                        <div class="invoice-block__label">Bill To</div>
                        <h3 class="invoice-block__title mb-1"><?php echo html_escape($billing['company_name']); ?></h3>
                        <p class="mb-1"><?php echo html_escape($billing['customer_name']); ?></p>
                        <p class="mb-1 text-muted"><?php echo html_escape($billing['address']); ?></p>
                        <p class="mb-1 text-muted"><?php echo html_escape($billing['phone']); ?></p>
                        <p class="mb-0 text-muted"><?php echo html_escape($billing['email']); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="invoice-block invoice-block--soft">
                        <div class="invoice-block__label">Invoice Info</div>
                        <div class="d-flex justify-content-between gap-3">
                            <span class="text-muted">Invoice No</span>
                            <strong><?php echo html_escape($invoice_meta['invoice_no']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between gap-3 mt-2">
                            <span class="text-muted">Order No</span>
                            <strong><?php echo html_escape($invoice_meta['order_no']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between gap-3 mt-2">
                            <span class="text-muted">Invoice Date</span>
                            <strong><?php echo html_escape($invoice_meta['invoice_date']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between gap-3 mt-2">
                            <span class="text-muted">Due Date</span>
                            <strong><?php echo html_escape($invoice_meta['due_date']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between gap-3 mt-2">
                            <span class="text-muted">Status</span>
                            <span class="status-pill status-low"><?php echo html_escape($invoice_meta['status']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table invoice-table align-middle">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Rate</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item['sku']); ?></td>
                                <td>
                                    <div class="fw-semibold"><?php echo html_escape($item['name']); ?></div>
                                </td>
                                <td class="text-center"><?php echo (int) $item['qty']; ?></td>
                                <td class="text-end"><?php echo html_escape($item['rate']); ?></td>
                                <td class="text-end fw-semibold"><?php echo html_escape($item['amount']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-lg-5">
                    <div class="invoice-summary">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Sub Total</span>
                            <strong><?php echo html_escape($summary['sub_total']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Discount</span>
                            <strong><?php echo html_escape($summary['discount']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Tax</span>
                            <strong><?php echo html_escape($summary['tax']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Shipping</span>
                            <strong><?php echo html_escape($summary['shipping']); ?></strong>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">Grand Total</span>
                            <span class="h4 mb-0 text-primary"><?php echo html_escape($summary['grand_total']); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-footer mt-4">
                <div>
                    <strong>GSTIN:</strong> <?php echo html_escape($billing['gst']); ?>
                </div>
                <div class="text-muted small">
                    This is a design-only invoice layout. No generation logic is connected yet.
                </div>
            </div>
        </div>
    </div>
</section>

<!--
<script>

function saveInvoice(order_id)
{
    $.ajax({

        url: "<?= base_url('index.php/Api_handler/insert_invoice'); ?>",

        type: "POST",

      //  headers: {
        //    Authorization: "Bearer YOUR_TOKEN"
        //},

        data: {
            order_id: order_id
        },

        success: function(response)
        {
            let res = JSON.parse(response);

            if (res.status) {

                alert(res.message);

            } else {

                alert(res.message);
            }
        }
    });
}

</script>
                        -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function saveInvoice(order_id)
{
    $.ajax({

        url: "<?= base_url('index.php/Api_handler/insert_invoice'); ?>",

        type: "POST",

        data: {
            order_id: order_id
        },

        success: function(response)
        {
            let res = JSON.parse(response);

            if (res.status) {

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: 'Invoice insert successfully',

                    confirmButtonText: 'OK'

                }).then(() => {

                    window.location.href =
                        "<?= base_url('admin/orders'); ?>";
                });

            } else {

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: res.message
                });
            }
        }
    });
}

</script>


<script>

function downloadInvoicePdf(order_id)
{
    Swal.fire({

        icon: 'success',

        title: 'Success',

        text: 'PDF generated successfully',

        confirmButtonText: 'Download'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href =
                "<?= base_url('index.php/Api_handler/download_invoice_pdf/'); ?>" +
                order_id;
        }
    });
}

</script>