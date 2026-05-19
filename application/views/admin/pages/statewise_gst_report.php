<style>
.statewise-report-shell {
    background: linear-gradient(135deg, #f8fafc 0%, #eef4fb 100%);
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 24px;
    padding: 24px;
}

.statewise-report-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #334155 100%);
    color: #fff;
    border-radius: 22px;
    padding: 28px;
    position: relative;
    overflow: hidden;
}

.statewise-report-hero::after {
    content: '';
    position: absolute;
    inset: auto -50px -50px auto;
    width: 210px;
    height: 210px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
}

.statewise-report-hero__eyebrow {
    text-transform: uppercase;
    letter-spacing: 0.14em;
    font-size: 0.74rem;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.72);
}

.statewise-report-hero__title {
    font-size: clamp(1.8rem, 2vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.04em;
    margin: 0.4rem 0 0.75rem;
}

.statewise-report-hero__copy {
    max-width: 60rem;
    color: rgba(255, 255, 255, 0.74);
}

.statewise-report-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.04);
}

.statewise-report-panel__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 14px;
}

.statewise-report-panel__title {
    font-size: 1.05rem;
    font-weight: 800;
    margin-bottom: 0.15rem;
}

.statewise-report-panel__copy {
    color: #64748b;
    margin-bottom: 0;
}

.statewise-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}

.statewise-summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px;
}

.statewise-summary-card__label {
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 700;
}

.statewise-summary-card__value {
    margin: 6px 0 4px;
    font-size: 1.35rem;
    font-weight: 800;
}

.statewise-summary-card__note {
    color: #94a3b8;
    font-size: 0.82rem;
    margin: 0;
}

.statewise-bars {
    display: grid;
    gap: 12px;
}

.statewise-row {
    display: grid;
    grid-template-columns: 160px 1fr 80px;
    gap: 12px;
    align-items: center;
}

.statewise-bar {
    height: 10px;
    border-radius: 999px;
    background: #e2e8f0;
    overflow: hidden;
}

.statewise-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #0f172a 0%, #0d9488 100%);
}

.statewise-report-table th {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    border-bottom: 1px solid #e5e7eb !important;
}

.statewise-report-table td {
    border-color: #eef2f7;
    vertical-align: middle;
}

.statewise-filter-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.04);
}

@media (max-width: 1200px) {
    .statewise-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .statewise-report-shell {
        padding: 16px;
    }

    .statewise-report-hero {
        padding: 20px;
    }

    .statewise-summary-grid {
        grid-template-columns: 1fr;
    }

    .statewise-row {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="panel-card mt-3">
    <div class="statewise-report-shell">
        <div class="statewise-report-hero mb-4">
            <div class="statewise-report-hero__eyebrow">GST Report</div>
            <h2 class="statewise-report-hero__title mb-0">Statewise GST Report</h2>
            <p class="statewise-report-hero__copy mt-3 mb-4">
                Separate design-only page for reviewing GST collection by state with export-ready presentation.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-light btn-sm" href="#">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export to Excel
                </a>
                <button class="btn btn-outline-light btn-sm" type="button">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
        </div>

        <div class="statewise-summary-grid mb-4">
            <?php foreach ($summary_cards as $card): ?>
                <div class="statewise-summary-card">
                    <div class="statewise-summary-card__label"><?php echo html_escape($card['label']); ?></div>
                    <div class="statewise-summary-card__value"><?php echo html_escape($card['value']); ?></div>
                    <p class="statewise-summary-card__note"><?php echo html_escape($card['note']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="statewise-filter-card mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-7">
                    <label class="form-label">Date Range</label>
                    <select class="form-select" id="statewiseDateRange" name="date_range">
                        <option value="today" <?php echo (($date_range ?? '') === 'today') ? 'selected' : ''; ?>>Today</option>
                        <option value="week" <?php echo (($date_range ?? '') === 'week') ? 'selected' : ''; ?>>Last 7 Days</option>
                        <option value="month" <?php echo (($date_range ?? '') === 'month') ? 'selected' : ''; ?>>This Month</option>
                        <option value="custom" <?php echo (($date_range ?? '') === 'custom') ? 'selected' : ''; ?>>Custom Range</option>
                    </select>
                </div>
                <div class="col-md-5 d-grid">
                    <button class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
            <div class="row g-3 mt-1 d-none" id="statewiseCustomRange">
                <div class="col-md-6">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="statewiseFromDate" value="<?php echo html_escape($start_date ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="statewiseToDate" value="<?php echo html_escape($end_date ?? ''); ?>">
                </div>
            </div>
        </div>

        <div class="statewise-report-panel">
            <div class="statewise-report-panel__head">
                <div>
                    <div class="statewise-report-panel__title">Statewise GST Datatable</div>
                    <p class="statewise-report-panel__copy">Detailed state list for GST review with export-friendly table format.</p>
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
                <table id="myTable" class="table statewise-report-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Taxable Value</th>
                            <th>GST Collected</th>
                            <th>Invoices</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($state_wise_rows as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?php echo html_escape($row['state']); ?></td>
                                <td><?php echo html_escape($row['taxable']); ?></td>
                                <td><?php echo html_escape($row['gst']); ?></td>
                                <td><?php echo html_escape($row['invoices']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rangeSelect = document.getElementById('statewiseDateRange');
    const customFields = document.getElementById('statewiseCustomRange');

    if (!rangeSelect || !customFields) {
        return;
    }

    const toggleCustomFields = function () {
        customFields.classList.toggle('d-none', rangeSelect.value !== 'custom');
    };

    rangeSelect.addEventListener('change', toggleCustomFields);
    toggleCustomFields();
});
</script>
