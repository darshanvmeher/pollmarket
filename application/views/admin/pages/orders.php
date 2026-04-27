
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <?php foreach ($headers as $header): ?>
                <th><?= $header ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                   
                    <!-- <td>#<?= $row['Order'] ?></td> -->
                    <td>#PM-<?= str_pad($row['Order'], 4, '0', STR_PAD_LEFT) ?></td>
                    <td><?= $row['Customer'] ?></td>
                    <td>₹<?= $row['Amount'] ?></td>
                    <td><?= $row['Products'] ?></td>
                    <td><?= $row['Items'] ?></td>
                    <td><?= $row['Status'] ?></td>
                   <!-- <td><?= $row['Date'] ?></td>-->
                    <td><?= date('d M Y, h:i A', strtotime($row['Date'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No Orders Found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
