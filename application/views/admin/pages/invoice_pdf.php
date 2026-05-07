<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice PDF</title>
</head>

<body style="font-family:sans-serif;
             background:#f4f7fb;
             padding:20px;
             color:#1e293b;
             font-size:12px;">

<div style="background:#fff;
            border:1px solid #cbd5e1;
            border-radius:16px;
            padding:20px;">

    <!-- Header -->

    <table width="100%">

        <tr>

            <td width="60%">

                <h2 style="margin:0;
                           color:#0f172a;
                           font-size:24px;">

                    PackMart Wholesale

                </h2>

                <p style="margin-top:5px;
                          color:#64748b;
                          font-size:12px;">

                    Industrial packaging and business supply

                </p>

            </td>

            <td width="40%" align="right">

                <div style="
                    background:#fff7ed;
                    color:#ea580c;
                    display:inline-block;
                    padding:5px 10px;
                    border-radius:20px;
                    font-size:11px;
                    margin-bottom:8px;">

                    <?= $invoice_meta['status']; ?>

                </div>

                <br>

                <span style="color:#64748b;">

                    Invoice #

                </span>

                <strong>

                    <?= $invoice_meta['invoice_no']; ?>

                </strong>

            </td>

        </tr>

    </table>

    <hr style="margin:20px 0;
               border-color:#cbd5e1;">

    <!-- Top Section -->

    <table width="100%" cellpadding="8">

        <tr>

            <!-- Bill To -->

            <td width="55%"
                valign="top"
                style="border:1px solid #cbd5e1;
                       border-radius:10px;">

                <div style="
                    font-size:11px;
                    color:#64748b;
                    font-weight:bold;
                    margin-bottom:8px;">

                    BILL TO

                </div>

                <strong style="font-size:15px;">

                    <?= $billing['customer_name']; ?>

                </strong>

                <br><br>

                <span style="color:#475569;">

                    <?= $billing['address']; ?>

                </span>

                <br><br>

                <span style="color:#475569;">

                    <?= $billing['phone']; ?>

                </span>

                <br><br>

                <span style="color:#475569;">

                    <?= $billing['email']; ?>

                </span>

            </td>

            <td width="5%"></td>

            <!-- Invoice Info -->

            <td width="40%"
                valign="top"
                style="border:1px solid #cbd5e1;
                       border-radius:10px;
                       background:#f8fafc;">

                <div style="
                    font-size:11px;
                    color:#64748b;
                    font-weight:bold;
                    margin-bottom:8px;">

                    INVOICE INFO

                </div>

                <table width="100%">

                    <tr>

                        <td style="color:#64748b;">
                            Invoice No
                        </td>

                        <td align="right">

                            <strong>

                                <?= $invoice_meta['invoice_no']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="padding-top:6px;
                                   color:#64748b;">

                            Order No

                        </td>

                        <td align="right"
                            style="padding-top:6px;">

                            <strong>

                                <?= $invoice_meta['order_no']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="padding-top:6px;
                                   color:#64748b;">

                            Invoice Date

                        </td>

                        <td align="right"
                            style="padding-top:6px;">

                            <strong>

                                <?= $invoice_meta['invoice_date']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="padding-top:6px;
                                   color:#64748b;">

                            Due Date

                        </td>

                        <td align="right"
                            style="padding-top:6px;">

                            <strong>

                                <?= $invoice_meta['due_date']; ?>

                            </strong>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <br><br>

    <!-- Product Table -->

    <table width="100%"
           cellpadding="8"
           cellspacing="0"
           style="border-collapse:collapse;">

        <thead>

            <tr style="background:#f1f5f9;">

                <th align="left"
                    style="border-bottom:1px solid #cbd5e1;
                           padding:10px 8px;">

                    SKU

                </th>

                <th align="left"
                    style="border-bottom:1px solid #cbd5e1;
                           padding:10px 8px;">

                    Item

                </th>

                <th align="center"
                    style="border-bottom:1px solid #cbd5e1;
                           padding:10px 8px;">

                    Qty

                </th>

                <th align="right"
                    style="border-bottom:1px solid #cbd5e1;
                           padding:10px 8px;">

                    Rate

                </th>

                <th align="right"
                    style="border-bottom:1px solid #cbd5e1;
                           padding:10px 8px;">

                    Amount

                </th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($items as $item): ?>

                <tr>

                    <td style="border-bottom:1px solid #cbd5e1;
                               padding:10px 8px;">

                        <?= $item['sku']; ?>

                    </td>

                    <td style="border-bottom:1px solid #cbd5e1;
                               padding:10px 8px;">

                        <?= $item['name']; ?>

                    </td>

                    <td align="center"
                        style="border-bottom:1px solid #cbd5e1;
                               padding:10px 8px;">

                        <?= $item['qty']; ?>

                    </td>

                    <td align="right"
                        style="border-bottom:1px solid #cbd5e1;
                               padding:10px 8px;">

                        <?= $item['rate']; ?>

                    </td>

                    <td align="right"
                        style="border-bottom:1px solid #cbd5e1;
                               padding:10px 8px;
                               font-weight:bold;">

                        <?= $item['amount']; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

    <br><br>

    <!-- Bottom -->

    <table width="100%">

        <tr>

            <!-- GSTIN -->

            <td width="55%" valign="bottom">

                <strong>

                    GSTIN:

                </strong>

                <?= $billing['gst']; ?>

            </td>

            <!-- Summary -->

            <td width="45%">

                <table width="100%"
                       cellpadding="8"
                       style="border:1px solid #cbd5e1;
                              border-radius:10px;
                              background:#f8fafc;">

                    <tr>

                        <td style="color:#64748b;">
                            Sub Total
                        </td>

                        <td align="right">

                            <strong>

                                <?= $summary['sub_total']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="color:#64748b;">
                            Discount
                        </td>

                        <td align="right">

                            <strong>

                                <?= $summary['discount']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="color:#64748b;">
                            Tax
                        </td>

                        <td align="right">

                            <strong>

                                <?= $summary['tax']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td style="color:#64748b;">
                            Shipping
                        </td>

                        <td align="right">

                            <strong>

                                <?= $summary['shipping']; ?>

                            </strong>

                        </td>

                    </tr>

                    <tr>

                        <td colspan="2">

                            <hr style="border-color:#cbd5e1;">

                        </td>

                    </tr>

                    <tr>

                        <td>

                            <strong>

                                Grand Total

                            </strong>

                        </td>

                        <td align="right"
                            style="font-size:20px;
                                   color:#2563eb;
                                   font-weight:bold;">

                            <?= $summary['grand_total']; ?>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</div>

</body>

</html>