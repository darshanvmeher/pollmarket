<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h2 class="panel-title mb-0"><?php echo html_escape($table_title); ?></h2>
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add New</button>
    </div>

    <div class="table-responsive">
        <table  id="myTable" class="table align-middle">
            <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?php echo html_escape($header); ?></th>
                <?php endforeach; ?>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?php echo html_escape($cell); ?></td>
                    <?php endforeach; ?>
                    <td class="text-end">
                        <button class="btn btn-sm btn-light me-1"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
                            
            </tbody>
        </table>
    </div>
</section>


