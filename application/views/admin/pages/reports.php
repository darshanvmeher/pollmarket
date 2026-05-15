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
                    <select class="form-select" id="salesDateRange" name="date_range">
                        <option name="today" value="today">Today</option>
                        <option name="week" value="week">Last 7 Days</option>
                        <option name="month" value="month">This Month</option>
                        <option name="custom" value="custom">Custom Range</option>
                    </select>
                </div>
                 <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">Apply Filters</button>
                </div>


                
                
                
                <div class="col-md-9">
                <label class="form-label">Order Status</label>

                <select class="form-select" id="orderStatus" name="order_status">
                    <option value="all">All Orders</option>
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
             <!--   <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">Apply Filters</button>
                </div>-->
            </div>
           <!-- <div class="row g-3 mt-1 d-none" id="customRangeFields">
                <div class="col-md-6">
                    <label class="form-label">From Date</label>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">Apply Filters</button>
                </div>
            </div>-->
           <div class="row g-3 mt-1 d-none" id="customRangeFields">
                <div class="col-md-6">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" id="fromDate"
                        value="<?php echo $start_date; ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" id="toDate"
                        value="<?php echo $end_date; ?>">
                </div>
            </div>
        </div>

      <!--  <div class="sales-report-summary mb-4">
           <?php foreach ($summary_cards as $card): ?>
                <div class="sales-report-summary-card">
                    <div class="sales-report-summary-card__label"><?php echo html_escape($card['label']); ?></div>
                    <div class="sales-report-summary-card__value"><?php echo html_escape($card['value']); ?></div>
                    <p class="sales-report-summary-card__note"><?php echo html_escape($card['note']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>-->

        <div class="sales-report-summary mb-4">

    <div class="sales-report-summary-card">
        <div class="sales-report-summary-card__label">Orders</div>
        <div class="sales-report-summary-card__value" id="ordersCount">
            <?php echo $kpis['orders'] ?? 0; ?>
        </div>
    </div>

    <div class="sales-report-summary-card">
        <div class="sales-report-summary-card__label">Items</div>
        <div class="sales-report-summary-card__value" id="itemsCount">
            <?php echo $kpis['items'] ?? 0; ?>
        </div>
    </div>

    <div class="sales-report-summary-card">
        <div class="sales-report-summary-card__label">Gross Sales</div>
        <div class="sales-report-summary-card__value" id="grossSales">
            ₹<?php echo $kpis['gross'] ?? 0; ?>
        </div>
    </div>

    <div class="sales-report-summary-card">
        <div class="sales-report-summary-card__label">Net Sales</div>
        <div class="sales-report-summary-card__value" id="netSales">
            ₹<?php echo $kpis['net'] ?? 0; ?>
        </div>
    </div>

</div>

        <div class="sales-report-panel">
            <div class="sales-report-panel__head">
                <div>
                    <div class="sales-report-panel__title">Daily Sales Datatable</div>
                    <p class="sales-report-panel__copy">A wider table layout with pagination enabled for reviewing sales rows.</p>
                </div>
                <?php
                $order_status = isset($order_status) ? $order_status : '';
                $date_range = isset($date_range) ? $date_range : '';
                ?>
                <div class="d-flex flex-wrap gap-2 justify-content-end">
                  <!--  <a class="btn btn-outline-primary btn-sm" href="#">
                        <i class="bi bi-file-earmark-excel me-1"></i>Export to Excel
                    </a>-->

                <!--   <a href="<?= base_url('Api_handler/export_excel?date_range='.$date_range.'&order_status='.$order_status) ?>" 
                    class="btn btn-success">  Export to Excel
                    </a>
           -->
                    <a id="exportExcelBtn" href="<?= base_url('Api_handler/export_excel') ?>"
                         class="btn btn-success">Export to Excel
                    </a>
                  <!--  <a class="btn btn-outline-secondary btn-sm" href="#">
                        <i class="bi bi-download me-1"></i>Download PDF
                    </a>-->

                    <a id="downloadPdfBtn" href="<?= base_url('index.php/Api_handler/download_pdf') ?>"
                    class="btn btn-secondary">Download PDF
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
                        
                        <?php if (!empty($sales_rows) && is_array($sales_rows)): ?>

                        <?php foreach ($sales_rows as $row): ?>
                            <tr>
                                <td><?php echo html_escape($row['date'] ?? '-'); ?></td>
                                <td><?php echo (int)($row['orders'] ?? 0); ?></td>
                                <td><?php echo (int)($row['items'] ?? 0); ?></td>
                                <td><?php echo html_escape($row['gross'] ?? 0); ?></td>
                                <td><?php echo html_escape($row['discount'] ?? 0); ?></td>
                                <td><?php echo html_escape($row['net'] ?? 0); ?></td>
                                <td><?php echo html_escape($row['channel'] ?? 'website'); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php else: ?>

                        <tr>
                            <td colspan="7" class="text-center">No sales data found</td>
                        </tr>

                        <?php endif; ?>

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

<!--js date range and order status-->
<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->


<!--
<script>

    $(document).ready(function () {

    $('.btn-primary').on('click', function () {

        let dateRange   = $('#salesDateRange').val();
        let orderStatus = $('#orderStatus').val();

        $.ajax({
            url: "<?=base_url('index.php/Api_handler/sales_report_by_today')?>",
            type: 'POST',
            dataType:'json',
            data: {
                date_range: dateRange,
                order_status: orderStatus
            },
            success: function (response) {
                $('#order_table').html(response);
            }
        });

    });

});

</script>

                        -->
                        
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


<script>

let table;

$(document).ready(function () {

    // Initialize DataTable only once
    table = $('#myTable').DataTable({

        pageLength: 5,

        lengthMenu: [5, 10, 12, 50, 100],

        ordering: true,

        searching: true,

        dom: 'Bfrtip',

      /*  buttons: [
            'copy',
            'csv',
            'excel',
            'pdf',
            'print'
        ]*/
    });

    // Apply Filters Button
    $('.btn-primary').on('click', function () {

        let dateRange = $('#salesDateRange').val();

        let orderStatus = $('#orderStatus').val();

        let startDate = $('#fromDate').val();

        let endDate = $('#toDate').val();

        // Request Object
        let requestData = {

            date_range: dateRange,

            order_status: orderStatus
        };

        // Custom Range
        if (dateRange == 'custom') {

            requestData.start_date = startDate;

            requestData.end_date = endDate;
        }

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/sales_report') ?>",

            type: 'POST',

            dataType: 'json',

            data: requestData,

            success: function (response) {

                console.log(response);

                // KPI Cards
                $('#ordersCount').text(
                    response.kpis.orders ?? 0
                );

                $('#itemsCount').text(
                    response.kpis.items ?? 0
                );

                $('#grossSales').text(
                    '₹' + (response.kpis.gross ?? 0)
                );

                $('#netSales').text(
                    '₹' + (response.kpis.net ?? 0)
                );

                // Clear old rows
                table.clear();

                // Add rows dynamically
                if (response.table_data && response.table_data.length > 0) {

                    response.table_data.forEach(function (row) {

                        table.row.add([

                            row.date ?? '-',

                            row.orders ?? 0,

                            row.items ?? 0,

                            row.gross ?? 0,

                            row.discount ?? 0,

                            row.net ?? 0,

                            row.channel ?? 'Website'
                        ]);
                    });

                } else {

                    table.row.add([

                        'No sales data found',

                        '',

                        '',

                        '',

                        '',

                        '',

                        ''
                    ]);
                }

                // Update PDF URL dynamically
              /*  let pdfUrl =
                "<?= base_url('index.php/Api_handler/download_pdf') ?>" +
                '?date_range=' + dateRange +
                '&order_status=' + orderStatus;
                '&start_date=' + startDate +
                '&end_date=' + endDate;


                $('#downloadPdfBtn').attr('href', pdfUrl);

                // Update Export Excel URL dynamically
                let exportUrl =
                "<?= base_url('index.php/Api_handler/export_excel') ?>" +
                '?date_range=' + dateRange +
                '&order_status=' + orderStatus;
                '&start_date=' + startDate +
                '&end_date=' + endDate;


                $('#exportExcelBtn').attr('href', exportUrl);

*/
                

                //new

                // Export Excel URL
                let exportUrl =
                "<?= base_url('index.php/Api_handler/export_excel') ?>" +
                '?date_range=' + dateRange +
                '&order_status=' + orderStatus;

                // PDF URL
                let pdfUrl =
                "<?= base_url('index.php/Api_handler/download_pdf') ?>" +
                '?date_range=' + dateRange +
                '&order_status=' + orderStatus;


                // ADD CUSTOM DATES
                if (dateRange == 'custom') {

                    exportUrl +=
                    '&start_date=' + startDate +
                    '&end_date=' + endDate;

                    pdfUrl +=
                    '&start_date=' + startDate +
                    '&end_date=' + endDate;
                }


                // SET BUTTON LINKS
                $('#exportExcelBtn').attr('href', exportUrl);

                $('#downloadPdfBtn').attr('href', pdfUrl);

                // Redraw table
                table.draw();
                // Redraw table
              //  table.draw();

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    });

});

</script>

<!--
<script>

   
$(document).ready(function () {

    $('.btn-primary').on('click', function () {

        let dateRange   = $('#salesDateRange').val();
        let orderStatus = $('#orderStatus').val();

        $.ajax({
            url: "<?= base_url('index.php/Api_handler/sales_report_by_today') ?>",
            type: 'POST',
            dataType: 'json',

            data: {
                date_range: dateRange,
                order_status: orderStatus
            },

            success: function (response) {

                console.log(response);

                // ✅ Update KPI Cards
                $('#ordersCount').text(response.data.orders);
                $('#itemsCount').text(response.data.items);
                $('#grossSales').text('₹' + response.data.gross);
                $('#netSales').text('₹' + response.data.net);

            },

            error: function (xhr, status, error) {
                console.log(error);
            }

        });

    });

});

                        </script>
                        -->


 <!--                       <script>

$(document).ready(function () {

    // Initialize DataTable first time
  //  $('#myTable').DataTable();

    $('.btn-primary').on('click', function () {

        let dateRange = $('#salesDateRange').val();

        let orderStatus = $('#orderStatus').val();

        let startDate = $('#fromDate').val();

        let endDate = $('#toDate').val();

        // Request Object
        let requestData = {

            date_range: dateRange,

            order_status: orderStatus
        };

        // Only for custom range
        if (dateRange == 'custom') {

            requestData.start_date = startDate;

            requestData.end_date = endDate;
        }

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/sales_report') ?>",

            type: 'POST',

            dataType: 'json',

            data: requestData,

            success: function (response) {

                console.log(response);

                // KPI Cards

                $('#ordersCount').text(
                    response.kpis.orders ?? 0
                );

                $('#itemsCount').text(
                    response.kpis.items ?? 0
                );

                $('#grossSales').text(
                    '₹' + (response.kpis.gross ?? 0)
                );

                $('#netSales').text(
                    '₹' + (response.kpis.net ?? 0)
                );

                // Table Rows

                let tbody = '';

              //  if (response.table_data.length > 0) 
              if (response.table_data && response.table_data.length > 0){

                    response.table_data.forEach(function (row) {

                        tbody += `
                            <tr>
                                <td>${row.date}</td>
                                <td>${row.orders}</td>
                                <td>${row.items}</td>
                                <td>${row.gross}</td>
                                <td>${row.discount}</td>
                                <td>${row.net}</td>
                                <td>${row.channel}</td>
                            </tr>
                        `;
                    });

                } else {

                    tbody = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No sales data found
                            </td>
                        </tr>
                    `;
                }

                // Destroy Old DataTable
               

//                if ($.fn.DataTable.isDataTable('#myTable')) {

  //                  $('#myTable').DataTable().destroy();
    //            }

                // Replace Table Body


      //          $('#myTable tbody').empty();

        //        $('#myTable tbody').html(tbody);

                // Reinitialize DataTable

          //      $('#myTable').DataTable({
                 if ($.fn.DataTable.isDataTable('#myTable')) {

                    $('#myTable').DataTable().clear().destroy();
                }

                $('#myTable tbody').empty();

                $('#myTable tbody').append(tbody);

                $('#myTable').DataTable({  
                
                destroy: true,
                pageLength: 5,
               lengthMenu: [5, 10, 12, 50, 100],
                 //lengthMenu:[2, 5, 10, 25, 50],
                ordering: true,
                searching: true,

                dom: 'Bfrtip',

                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print'
                ]
            });

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    });

});

</script>-->
<!--
                        <script>

$(document).ready(function () {

    $('.btn-primary').on('click', function () {

        let dateRange   = $('#salesDateRange').val();

        let orderStatus = $('#orderStatus').val();

        let startDate = $('#fromDate').val();

        let endDate   = $('#toDate').val();

        // Request object
        let requestData = {

            date_range: dateRange,

            order_status: orderStatus
        };

        // Only custom range sends dates
        if (dateRange == 'custom') {

            requestData.start_date = startDate;

            requestData.end_date = endDate;
        }

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/sales_report') ?>",

            type: 'POST',

            dataType: 'json',

            data: requestData,

            success: function (response) {

                console.log(response);

                $('#ordersCount').text(response.kpis.orders ?? 0);

                $('#itemsCount').text(response.kpis.items ?? 0);

                $('#grossSales').text('₹' + (response.kpis.gross ?? 0));

                $('#netSales').text('₹' + (response.kpis.net ?? 0));

                let tbody = '';

                if (response.table_data.length > 0) {

                    response.table_data.forEach(function (row) {

                        tbody += `
                            <tr>
                                <td>${row.date}</td>
                                <td>${row.orders}</td>
                                <td>${row.items}</td>
                                <td>${row.gross}</td>
                                <td>${row.discount}</td>
                                <td>${row.net}</td>
                                <td>${row.channel}</td>
                            </tr>
                        `;
                    });

                } else {

                    tbody = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No sales data found
                            </td>
                        </tr>
                    `;
                }

                $('#myTable tbody').html(tbody);

            },

            error: function (xhr) {

                console.log(xhr.responseText);

            }

        });

    });

});

</script>
                        -->

<!--
                        <script>

$(document).ready(function () {

    $('.btn-primary').on('click', function () {

        let dateRange   = $('#salesDateRange').val();
        let orderStatus = $('#orderStatus').val();

        // ADD THESE
        let startDate = $('#fromDate').val();
        let endDate   = $('#toDate').val();

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/sales_report') ?>",
            type: 'POST',
            dataType: 'json',

            data: {
                date_range: dateRange,
                order_status: orderStatus,
                start_date: startDate,
                end_date: endDate
            },

            success: function (response) {

                console.log(response);

                $('#ordersCount').text(response.kpis.orders ?? 0);

                $('#itemsCount').text(response.kpis.items ?? 0);

                $('#grossSales').text('₹' + (response.kpis.gross ?? 0));

                $('#netSales').text('₹' + (response.kpis.net ?? 0));

                let tbody = '';

                if (response.table_data.length > 0) {

                    response.table_data.forEach(function (row) {

                        tbody += `
                            <tr>
                                <td>${row.date}</td>
                                <td>${row.orders}</td>
                                <td>${row.items}</td>
                                <td>${row.gross}</td>
                                <td>${row.discount}</td>
                                <td>${row.net}</td>
                                <td>${row.channel}</td>
                            </tr>
                        `;

                    });

                } else {

                    tbody = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No sales data found
                            </td>
                        </tr>
                    `;
                }

                $('#myTable tbody').html(tbody);

            },

            error: function (xhr, status, error) {

                console.log(xhr.responseText);

            }

        });

    });

});

</script>
                        -->
                        <!--
<script>

$(document).ready(function () {

    $('.btn-primary').on('click', function () {

        let dateRange   = $('#salesDateRange').val();
        let orderStatus = $('#orderStatus').val();
        

        $.ajax({

            url: "<?= base_url('index.php/Api_handler/sales_report_by_custom_date_range') ?>",
            type: 'POST',
            dataType: 'json',

            data: {
                date_range: dateRange,
                order_status: orderStatus
            },

            success: function (response) {

                console.log(response);

                // ✅ KPI Cards
                $('#ordersCount').text(response.kpis.orders ?? 0);

                $('#itemsCount').text(response.kpis.items ?? 0);

                $('#grossSales').text('₹' + (response.kpis.gross ?? 0));

                $('#netSales').text('₹' + (response.kpis.net ?? 0));

                // ✅ Update Table
                let tbody = '';

                if (response.table_data.length > 0) {

                    response.table_data.forEach(function (row) {

                        tbody += `
                            <tr>
                                <td>${row.date}</td>
                                <td>${row.orders}</td>
                                <td>${row.items}</td>
                                <td>${row.gross}</td>
                                <td>${row.discount}</td>
                                <td>${row.net}</td>
                                <td>${row.channel}</td>
                            </tr>
                        `;

                    });

                } else {

                    tbody = `
                        <tr>
                            <td colspan="7" class="text-center">
                                No sales data found
                            </td>
                        </tr>
                    `;
                }

                // ✅ Replace table body
                $('#myTable tbody').html(tbody);

            },

            error: function (xhr, status, error) {

                console.log(error);

            }

        });

    });

});


</script>
                        -->



