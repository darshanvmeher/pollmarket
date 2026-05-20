<style>
.gst-report-shell {
    background: linear-gradient(135deg, #f8fafc 0%, #eef4fb 100%);
    border: 1px solid rgba(15, 23, 42, 0.08);
    border-radius: 24px;
    padding: 24px;
}

.gst-report-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #334155 100%);
    color: #fff;
    border-radius: 22px;
    padding: 28px;
    position: relative;
    overflow: hidden;
}

.gst-report-hero::after {
    content: '';
    position: absolute;
    inset: auto -50px -50px auto;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
}

.gst-report-hero__eyebrow {
    text-transform: uppercase;
    letter-spacing: 0.14em;
    font-size: 0.74rem;
    font-weight: 800;
    color: rgba(255, 255, 255, 0.72);
}

.gst-report-hero__title {
    font-size: clamp(1.8rem, 2vw, 2.5rem);
    font-weight: 800;
    letter-spacing: -0.04em;
    margin: 0.4rem 0 0.75rem;
}

.gst-report-hero__copy {
    max-width: 60rem;
    color: rgba(255, 255, 255, 0.74);
}

.gst-report-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.04);
}

.gst-report-panel__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 14px;
}

.gst-report-panel__title {
    font-size: 1.05rem;
    font-weight: 800;
    margin-bottom: 0.15rem;
}

.gst-report-panel__copy {
    color: #64748b;
    margin-bottom: 0;
}

.gst-summary-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
}

.gst-summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 16px;
}

.gst-summary-card__label {
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 700;
}

.gst-summary-card__value {
    margin: 6px 0 4px;
    font-size: 1.35rem;
    font-weight: 800;
}

.gst-summary-card__note {
    color: #94a3b8;
    font-size: 0.82rem;
    margin: 0;
}

.gst-report-table th {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #64748b;
    border-bottom: 1px solid #e5e7eb !important;
}

.gst-report-table td {
    border-color: #eef2f7;
    vertical-align: middle;
}

.gst-statewise-grid {
    display: grid;
    gap: 12px;
}

.gst-statewise-row {
    display: grid;
    grid-template-columns: 140px 1fr 70px;
    gap: 12px;
    align-items: center;
}

.gst-statewise-bar {
    height: 10px;
    border-radius: 999px;
    background: #e2e8f0;
    overflow: hidden;
}

.gst-statewise-bar span {
    display: block;
    height: 100%;
    border-radius: inherit;
    background: linear-gradient(90deg, #0f172a 0%, #0d9488 100%);
}

@media (max-width: 1200px) {
    .gst-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .gst-report-shell {
        padding: 16px;
    }

    .gst-report-hero {
        padding: 20px;
    }

    .gst-summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="panel-card mt-3">
    <div class="gst-report-shell">
        <div class="gst-report-hero mb-4">
            <div class="gst-report-hero__eyebrow">GST Report</div>
            <h2 class="gst-report-hero__title mb-0">GST Sales Summary</h2>
            <p class="gst-report-hero__copy mt-3 mb-4">
                Design-only GST summary report for ecommerce sales showing tax breakup, invoice totals, and state-wise performance.
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

        <div class="gst-report-panel mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-7">
                    <label class="form-label">Date Range</label>
                    <select class="form-select" id="salesDateRange" name="date_range">
                        <option value="today" <?php echo (($date_range ?? '') === 'today') ? 'selected' : ''; ?>>Today</option>
                        <option value="week" <?php echo (($date_range ?? '') === 'week') ? 'selected' : ''; ?>>Last 7 Days</option>
                        <option value="month" <?php echo (($date_range ?? '') === 'month') ? 'selected' : ''; ?>>This Month</option>
                        <option value="custom" <?php echo (($date_range ?? '') === 'custom') ? 'selected' : ''; ?>>Custom Range</option>
                    </select>
                </div>
                <div class="col-md-5 d-grid">
                    <button class="btn btn-primary" id="applyFilter">Apply Filters</button>
                </div>
            </div>

            <div class="row g-3 mt-1 d-none" id="customRangeFields">
                <div class="col-md-6">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="fromDate" value="<?php echo html_escape($start_date ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="toDate" value="<?php echo html_escape($end_date ?? ''); ?>">
                </div>
            </div>
        </div>

        <div class="gst-summary-grid mb-4">
            <?php foreach ($kpis as $card): ?>
                <div class="gst-summary-card">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <div class="gst-summary-card__label"><?php echo html_escape($card['title']); ?></div>
                            <div class="gst-summary-card__value"><?php echo html_escape($card['value']); ?></div>
                        </div>
                        <span class="kpi-badge <?php echo html_escape($card['trend_class']); ?>"><?php echo html_escape($card['trend']); ?></span>
                    </div>
                    <p class="gst-summary-card__note">GST summary metric</p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="gst-report-panel">
            <div class="gst-report-panel__head">
                <div>
                    <div class="gst-report-panel__title">GST Invoice Register</div>
                    <p class="gst-report-panel__copy">Large, export-ready datatable for GST review and reconciliation.</p>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-end">
                   <!-- <a class="btn btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-file-earmark-excel me-1"></i>Export to Excel
                    </a>-->
                   


                     <a
                    href="javascript:void(0)"
                    id="exportExcel"
                    class="btn btn-outline-secondary btn-sm">

                    <i class="bi bi-download me-1"></i>

                  Export to Excel

                </a>
                  <!--  <a class="btn btn-outline-secondary btn-sm" href="#">
                        <i class="bi bi-download me-1"></i>Download CSV
                    </a>-->
                <!--    <a
                    href="<?= base_url('index.php/Api_handler/download_gst_pdf'); ?>"

                    class="btn btn-outline-secondary btn-sm">

                    <i class="bi bi-download me-1"></i>

                    Download PDF

                </a>-->

                <a
                    href="javascript:void(0)"
                    id="downloadPdf"
                    class="btn btn-outline-secondary btn-sm">

                    <i class="bi bi-download me-1"></i>

                    Download PDF

                </a>

                </div>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table gst-report-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>State</th>
                            <th>Taxable Value</th>
                            <th>GST</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gst_invoice_rows as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?php echo html_escape($row['invoice']); ?></td>
                                <td><?php echo html_escape($row['date']); ?></td>
                                <td><?php echo html_escape($row['customer']); ?></td>
                                <td><?php echo html_escape($row['state']); ?></td>
                                <td><?php echo html_escape($row['taxable']); ?></td>
                                <td><?php echo html_escape($row['gst']); ?></td>
                                <td class="fw-semibold"><?php echo html_escape($row['total']); ?></td>

                                
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
    const rangeSelect = document.getElementById('salesDateRange');
    const customFields = document.getElementById('customRangeFields');

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


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!--
<script>
    $(document).ready(function () {

    $('#applyFilter').click(function () {

        let date_range = $('#salesDateRange').val();

        let start_date = $('#fromDate').val();

        let end_date = $('#toDate').val();

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/gst_sales_summary') ?>",

            type: 'GET',

            dataType: 'json',

            data: {

                date_range: date_range,

                start_date: start_date,

                end_date: end_date
            },

            beforeSend: function () {

                $('#myTable tbody').html(`
                    <tr>
                        <td colspan="7" class="text-center">
                            Loading...
                        </td>
                    </tr>
                `);
            },

            success: function (response) {

                console.log(response);

                let html = '';

                // KPI UPDATE
            

                $('.kpi-taxable').text(
                    response.summary.taxable_value
                    );

                    $('.kpi-cgst').text(
                        response.summary.cgst
                    );

                    $('.kpi-sgst').text(
                        response.summary.sgst
                    );

                    $('.kpi-igst').text(
                        response.summary.igst
                    );

                // TABLE DATA
                if (response.data.length > 0) {

                    $.each(response.data, function (i, row) {

                            html += `
                <tr>

                    <td class="fw-semibold">
                        ${row.invoice_no}
                    </td>

                    <td>
                        ${row.invoice_date}
                    </td>

                    <td>
                        ${row.customer_name}
                    </td>

                    <td>
                        ${row.state}
                    </td>

                    <td>
                        ₹${parseFloat(row.sub_total).toFixed(2)}
                    </td>

                    <td>
                        ₹${parseFloat(row.tax).toFixed(2)}
                    </td>

                    <td class="fw-semibold">
                        ₹${parseFloat(row.grand_total).toFixed(2)}
                    </td>

                </tr>
                `;
                        
                    });

                } else {

                    html = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No Records Found
                            </td>
                        </tr>
                    `;
                }

                $('#myTable tbody').html(html);
            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Something went wrong');
            }
        });

    });

});
</script>

-->

<script>

$(document).ready(function () {

    // APPLY FILTER
    $('#applyFilter').click(function () {

        let date_range = $('#salesDateRange').val();

        let start_date = $('#fromDate').val();

        let end_date = $('#toDate').val();

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/gst_sales_summary') ?>",

            type: 'GET',

            dataType: 'json',

            data: {

                date_range: date_range,

                start_date: start_date,

                end_date: end_date
            },

            beforeSend: function () {

                $('#myTable tbody').html(`
                    <tr>
                        <td colspan="7" class="text-center">
                            Loading...
                        </td>
                    </tr>
                `);
            },

            success: function (response) {

                console.log(response);

                let html = '';

                // KPI UPDATE
                $('.kpi-taxable').text(
                    response.summary.taxable_value
                );

                $('.kpi-cgst').text(
                    response.summary.cgst
                );

                $('.kpi-sgst').text(
                    response.summary.sgst
                );

                $('.kpi-igst').text(
                    response.summary.igst
                );

                // TABLE DATA
                if (response.data.length > 0) {

                    $.each(response.data, function (i, row) {

                        html += `
                            <tr>

                                <td class="fw-semibold">
                                    ${row.invoice_no}
                                </td>

                                <td>
                                    ${row.invoice_date}
                                </td>

                                <td>
                                    ${row.customer_name}
                                </td>

                                <td>
                                    ${row.state}
                                </td>

                                <td>
                                    ₹${parseFloat(row.sub_total).toFixed(2)}
                                </td>

                                <td>
                                    ₹${parseFloat(row.tax).toFixed(2)}
                                </td>

                                <td class="fw-semibold">
                                    ₹${parseFloat(row.grand_total).toFixed(2)}
                                </td>

                            </tr>
                        `;
                    });

                } else {

                    html = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No Records Found
                            </td>
                        </tr>
                    `;
                }

                $('#myTable tbody').html(html);
            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert('Something went wrong');
            }
        });

    });



    // PDF DOWNLOAD
    $('#downloadPdf').click(function () {

        let date_range =
            $('#salesDateRange').val();

        let start_date =
            $('#fromDate').val();

        let end_date =
            $('#toDate').val();

        window.location.href =
            "<?= base_url(
                'index.php/Api_handler/download_gst_pdf'
            ); ?>"

            + "?date_range=" + date_range

            + "&start_date=" + start_date

            + "&end_date=" + end_date;
    });


    // EXCEL DOWNLOAD
$('#exportExcel').click(function () {

    let date_range =
        $('#salesDateRange').val();

    let start_date =
        $('#fromDate').val();

    let end_date =
        $('#toDate').val();

    window.location.href =
        "<?= base_url('index.php/Api_handler/export_gst_excel'); ?>"

        + "?date_range=" + date_range

        + "&start_date=" + start_date

        + "&end_date=" + end_date;
});

});

</script>