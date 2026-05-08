<style>
.sales-report-shell {
    background: linear-gradient(135deg, #f8fafc 0%, #eef4fb 100%);
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 24px;
    padding: 24px;
}

.sales-report-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #334155 100%);
    color: #fff;
    border-radius: 22px;
    padding: 28px;
    position: relative;
    overflow: hidden;
}

.sales-report-hero::after {
    content: '';
    position: absolute;
    inset: auto -50px -50px auto;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
}

.sales-report-hero__eyebrow {
    text-transform: uppercase;
    letter-spacing: 0.14em;
    font-size: 0.74rem;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.72);
}

.sales-report-hero__title {
    font-size: clamp(1.8rem, 2vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.04em;
    margin: 0.4rem 0 0.75rem;
}

.sales-report-hero__copy {
    max-width: 60rem;
    color: rgba(255, 255, 255, 0.74);
}

.sales-report-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.04);
}

.sales-report-panel__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 14px;
}

.sales-report-panel__title {
    font-size: 1.05rem;
    font-weight: 800;
    margin-bottom: 0.15rem;
}

.sales-report-panel__copy {
    color: #64748b;
    margin-bottom: 0;
}

.sales-report-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}

.sales-report-summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px;
}

.sales-report-summary-card__label {
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 700;
}

.sales-report-summary-card__value {
    margin: 6px 0 4px;
    font-size: 1.35rem;
    font-weight: 800;
}

.sales-report-summary-card__note {
    color: #94a3b8;
    font-size: 0.82rem;
    margin: 0;
}

.sales-report-table th {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    border-bottom: 1px solid #e5e7eb !important;
}

.sales-report-table td {
    border-color: #eef2f7;
    vertical-align: middle;
}

.report-bar {
    height: 10px;
    background: #e2e8f0;
    border-radius: 999px;
    overflow: hidden;
}

.report-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #0f172a 0%, #3b82f6 100%);
}

.sales-report-channel {
    display: grid;
    gap: 12px;
}

.sales-report-channel__row {
    display: grid;
    grid-template-columns: 90px 1fr 48px;
    gap: 12px;
    align-items: center;
}

@media (max-width: 1200px) {
    .sales-report-summary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .sales-report-shell {
        padding: 16px;
    }

    .sales-report-hero {
        padding: 20px;
    }

    .sales-report-summary {
        grid-template-columns: 1fr;
    }

    .sales-report-channel__row {
        grid-template-columns: 72px 1fr 44px;
    }
}
</style>

<section class="panel-card mt-3">
    <div class="sales-report-shell">
        <div class="sales-report-hero mb-4">
            <div class="sales-report-hero__eyebrow">Sales Report</div>
            <h2 class="sales-report-hero__title mb-0">See sales performance and export it to Excel</h2>
            <p class="sales-report-hero__copy mt-3 mb-4">
                A focused ecommerce sales report design with date filters, channel breakdown, and detailed rows ready for export.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-light btn-sm" href="#">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export to Excel
                </a>
                <button class="btn btn-outline-light btn-sm" type="button">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
                <button class="btn btn-outline-light btn-sm" type="button">
                    <i class="bi bi-funnel me-1"></i>Filters
                </button>
            </div>
        </div>

        <div class="sales-report-panel mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label class="form-label">Date Range</label>
                    <select class="form-select" id="salesDateRange">
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
            <div class="row g-3 mt-1 d-none" id="customRangeFields">
                <div class="col-md-6">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="fromDate">
                </div>
                <div class="col-md-6">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="toDate">
                </div>
            </div>
        </div>

        <div class="sales-report-summary mb-4">
            <?php foreach ($summary_cards as $card): ?>
                <div class="sales-report-summary-card">
                    <div class="sales-report-summary-card__label"><?php echo html_escape($card['label']); ?></div>
                    <div class="sales-report-summary-card__value"><?php echo html_escape($card['value']); ?></div>
                    <p class="sales-report-summary-card__note"><?php echo html_escape($card['note']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="sales-report-panel">
            <div class="sales-report-panel__head">
                <div>
                    <div class="sales-report-panel__title">Daily Sales Datatable</div>
                    <p class="sales-report-panel__copy">A wider table layout with pagination enabled for reviewing sales rows.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-end">
                    <a class="btn btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-file-earmark-excel me-1"></i>Export to Excel
                    </a>
                    <a class="btn btn-outline-secondary btn-sm" href="#">
                        <i class="bi bi-download me-1"></i>Download CSV
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table sales-report-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Orders</th>
                            <th>Items</th>
                            <th>Gross Sales</th>
                            <th>Discount</th>
                            <th>Net Sales</th>
                            <th>Channel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales_rows as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?php echo html_escape($row['date']); ?></td>
                                <td><?php echo (int) $row['orders']; ?></td>
                                <td><?php echo (int) $row['items']; ?></td>
                                <td><?php echo html_escape($row['gross']); ?></td>
                                <td><?php echo html_escape($row['discount']); ?></td>
                                <td class="fw-semibold"><?php echo html_escape($row['net']); ?></td>
                                <td><span class="status-pill status-live"><?php echo html_escape($row['channel']); ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-3 pt-3 border-top">
                <div class="text-muted small">
                    Showing 1 to <?php echo count($sales_rows); ?> of <?php echo count($sales_rows); ?> entries
                </div>
                <div class="quick-chip">
                    <i class="bi bi-layers me-1"></i>Pagination enabled
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rangeSelect = document.getElementById('salesDateRange');
    const customFields = document.getElementById('customRangeFields');

    if (!rangeSelect || !customFields) {
        return;
    }

    const toggleCustomFields = function () {
        if (rangeSelect.value === 'custom') {
            customFields.classList.remove('d-none');
        } else {
            customFields.classList.add('d-none');
        }
    };

    rangeSelect.addEventListener('change', toggleCustomFields);
    toggleCustomFields();
});
</script>
