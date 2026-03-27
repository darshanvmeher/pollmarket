<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="panel-title mb-0">Saved Products</h2>
            <p class="page-subtitle mt-1">Manage product masters with modal-based add, edit, and delete actions.</p>
        </div>
        <button
            class="btn btn-primary btn-sm"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#productFormModal"
            data-mode="add" 
        >
            <i class="bi bi-plus-lg me-1"></i>Add New Product
        </button>
    </div>
    <div class="table-responsive">
        
        <table id="myTable"class="table align-middle">
            <thead>
            <tr>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
<?php if (!empty($products) && is_array($products)): ?>
<?php foreach ($products as $product): ?>

<?php
$status = $product['status'] ?? '';

$status_class = 'status-live';
if ($status == 0) {
    $status_class = 'status-out';
}
?>

<tr>
     <!-- category -->
    <td>
        <div class="fw-semibold">
            <?php echo html_escape($product['category_name'] ?? 'N/A'); ?>
        </div>
    </td>
    <!-- Subcategory -->
    <td>
        <div class="fw-semibold">
            <?php echo html_escape($product['sub_category_name'] ?? 'N/A'); ?>
        </div>
    </td>

    
    <!-- Product Name -->
    <td>
        <?php echo html_escape($product['product_name']); ?>
    </td>

    <!-- Price -->
    <td>
        ₹<?php echo html_escape($product['price']); ?>
    </td>

    <!-- Description -->
    <td>
        <?php echo html_escape($product['description']); ?>
    </td>

    <!-- Stock -->
    <td>
        <?php echo html_escape($product['stock']); ?>
    </td>

    <!-- Status -->
    <td>
        <span class="status-pill <?php echo $status_class; ?>">
            <?php echo $status ? 'Active' : 'Inactive'; ?>
        </span>
    </td>

    <!-- Actions -->
    <td class="text-end">

        <!-- Edit -->
        <button
            class="btn btn-sm btn-light me-1"
            data-bs-toggle="modal"
            data-bs-target="#productFormModal"
            data-mode="edit"

            data-id="<?= $product['id']; ?>"
            data-name="<?= html_escape($product['product_name']); ?>"
            data-price="<?= $product['price']; ?>"
            data-stock="<?= $product['stock']; ?>"
            data-description="<?= html_escape($product['description']); ?>"
            data-status="<?= $product['status']; ?>"
        >
            <i class="bi bi-pencil-square"></i>
            Edit
        </button>

        <!-- Delete -->
        <button
            class="btn btn-sm btn-outline-danger delete-product-btn"
            data-id="<?= $product['id']; ?>"
            data-name="<?= html_escape($product['product_name']); ?>"
        >
            <i class="bi bi-trash"></i>
            Delete
        </button>

    </td>
</tr>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7">No products found</td>
</tr>
<?php endif; ?>
</tbody>
        </table>
    </div>
</section>

<!--<div class="modal fade" id="categoryFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form id="categoriesForm" class="row g-3">

        <div class="modal-content category-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" data-category-modal-title>Add Category</h5>
                    <p class="text-muted small mb-0" data-category-modal-subtitle>Create a new category master for the catalog.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body pt-3">
                    <input type="hidden" name="id" id="categories_id">
                    <div class="col-12">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" data-category-input="name" name="category_name"placeholder="Paper Bags">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" data-category-input="status" name="status">
                            <?php foreach ($status_options as $status_option): ?>
                                <option value="<?php echo html_escape($status_option); ?>"><?php echo html_escape($status_option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" data-category-input="description"name="description" placeholder="Short category summary"></textarea>
                    </div>

            
           

        </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-category-submit-label>Save Category</button>
            </div>

                        



                         
            
        </form>
        
        </div>
    </div>

   
</div>-->
<div class="modal fade" id="productFormModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content product-modal">

            <form id="productForm" enctype="multipart/form-data" class="row g-3">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="productModalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="product_id">

                    <!-- category -->
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c['id']; ?>">
                                    <?= html_escape($c['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Subcategory -->
                    <div class="col-md-6">
                        <label class="form-label">Subcategory</label>
                        <select name="sub_category_id" class="form-select" required>
                            <?php foreach ($subcategories as $sc): ?>
                                <option value="<?= $sc['id']; ?>">
                                    <?= html_escape($sc['sub_category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                  

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" required>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label class="form-label">Stock</label>
                        <input type="text" name="stock" class="form-control" required>                   

                    </div>

                    <!-- Status (ENUM FIX) -->
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Review">Review</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    <!-- Media -->
                    <div class="col-12">
                        <label class="form-label">Product Images / Videos</label>
                        <input type="file" name="media[]" multiple class="form-control">
                    </div>

                    <!-- Attributes -->
                    <div class="col-12">
                        <label class="form-label">Attributes</label>

                        <div id="attributesContainer">
                            <div class="row mb-2">
                                <div class="col-md-5">
                                    <select name="attributes[0][attribute_id]" class="form-select">
                                        <?php foreach ($attributes as $attr): ?>
                                            <option value="<?= $attr['id']; ?>">
                                                <?= $attr['attribute_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <input type="text" name="attributes[0][value]" class="form-control" placeholder="Value">
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger removeAttr">X</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-primary" id="addAttributeBtn">
                            + Add Attribute
                        </button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>

            </form>

        </div>
    </div>
</div>

  <div id="updatePopup" style="
    position: fixed;
    top: 20px;
    right: 20px;
    background: #0d6efd;
    color: #fff;
    padding: 12px 20px;
    border-radius: 5px;
    display: none;
    z-index: 9999;">
</div>

  <script>
function showUpdatePopup(message, error = false) {
    const popup = document.getElementById('updatePopup');
    if (!popup) return;

    popup.innerText = message;
    popup.style.background = error ? '#dc3545' : '#1f8a39';
    popup.style.display = 'block';

    setTimeout(() => {
        popup.style.display = 'none';
    }, 2000);
}
</script>

<script>
    document.getElementById('productForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const id = document.getElementById('product_id').value;

    const url = id
        ? "<?= base_url('index.php/middle/updating_product'); ?>"
        : "<?= base_url('index.php/middle/adding_product'); ?>";

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            showUpdatePopup(data.message);
            setTimeout(() => location.reload(), 1200);
        } else {
            showUpdatePopup(data.message, true);
        }
    });
});
</script>
<script>
    const modal = document.getElementById('productFormModal');

modal.addEventListener('show.bs.modal', function (event) {

    const btn = event.relatedTarget;
    const mode = btn.getAttribute('data-mode');

    const form = document.getElementById('productForm');
    form.reset();

    if (mode === 'edit') {
        document.getElementById('productModalTitle').innerText = "Edit Product";

        document.getElementById('product_id').value = btn.dataset.id;
        form.product_name.value = btn.dataset.name;
        form.price.value = btn.dataset.price;
        form.stock.value = btn.dataset.stock;
        form.description.value = btn.dataset.description;
        form.status.value = btn.dataset.status;
    } else {
        document.getElementById('productModalTitle').innerText = "Add Product";
    }
});
</script>

<script>
    let attrIndex = 1;

document.getElementById('addAttributeBtn').addEventListener('click', function () {

    const container = document.getElementById('attributesContainer');

    const html = `
    <div class="row mb-2">
        <div class="col-md-5">
            <select name="attributes[${attrIndex}][attribute_id]" class="form-select">
                <?php foreach ($attributes as $attr): ?>
                    <option value="<?= $attr['id']; ?>">
                        <?= $attr['attribute_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-5">
            <input type="text" name="attributes[${attrIndex}][value]" class="form-control">
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger removeAttr">X</button>
        </div>
    </div>`;

    container.insertAdjacentHTML('beforeend', html);
    attrIndex++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('removeAttr')) {
        e.target.closest('.row').remove();
    }
});
</script>

<script>
const modal = document.getElementById('categoryFormModal');

modal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const mode = button.getAttribute('data-category-mode');
    const name = button.getAttribute('data-category-name');
    const status = button.getAttribute('data-category-status');
    const description = button.getAttribute('data-category-description');
    const id = button.getAttribute('data-category-id');

    const nameInput = document.querySelector('[name="category_name"]');
    const statusInput = document.querySelector('[name="status"]');
    const descInput = document.querySelector('[name="description"]');
    const idInput = document.getElementById('categories_id');

    if (mode === 'edit') {
        nameInput.value = name;
        statusInput.value = status;
        descInput.value = description;
        idInput.value = id;
    } else {
        nameInput.value = "";
        statusInput.selectedIndex = 0;
        descInput.value = "";
        idInput.value = "";
    }

}); 
</script>

<!--delete script-->

<script>
document.addEventListener('DOMContentLoaded', function () {

    let deleteCategoryId = null;

    // When delete button clicked → open modal
    document.querySelectorAll('.delete-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            deleteCategoryId = this.dataset.id;

            // Set category name
            document.querySelector('[data-category-delete-name]').textContent =
                this.dataset.name || 'Category';

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('categoryDeleteModal'));
            modal.show();
        });

    });

    // Confirm delete button (use ID instead of class)
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {

        if (!deleteCategoryId) return;

        fetch("<?= base_url('index.php/middle/deleting_categories'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + deleteCategoryId
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {

                showUpdatePopup('Category deleted successfully ✅');

                // Remove row
                document.querySelector(`.delete-btn[data-id="${deleteCategoryId}"]`)
                    ?.closest('tr').remove();

                // Close modal
                bootstrap.Modal.getInstance(
                    document.getElementById('categoryDeleteModal')
                ).hide();
                document.body.focus();

            } else {
                showUpdatePopup(data.message || 'Delete failed ❌', true);
            }
        })
        .catch(() => {
            showUpdatePopup('Server error ❌', true);
        });

    });

});
</script>

