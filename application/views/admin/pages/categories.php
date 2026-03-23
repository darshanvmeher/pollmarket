<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="panel-title mb-0">Saved Categories</h2>
            <p class="page-subtitle mt-1">Manage category masters with modal-based add, edit, and delete actions.</p>
        </div>
        <button
            class="btn btn-primary btn-sm"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#categoryFormModal"
            data-category-mode="add"
        >
            <i class="bi bi-plus-lg me-1"></i>Add New Category
        </button>
    </div>
    <div class="table-responsive">
        
        <table class="table align-middle">
            <thead>
            <tr>
                <th>Category</th>
                <th>Description</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($categories) && is_array($categories)): ?>
            <?php foreach ($categories as $category): ?>                
            <?php
              $status = $category['status'] ?? '';

                $status_class = 'status-live';

                if ($status === 'Review') {
                    $status_class = 'status-low';
                } elseif ($status === 'Draft') {
                    $status_class = 'status-out';
                }
                ?>
                <tr>
                    <td>
                        <div class="fw-semibold"><?php echo html_escape($category['category_name']?? 'N/A'); ?></div>
                    </td>
                    <td>
                        <div class="small text-muted"><?php echo html_escape($category['description']?? ' '); ?></div>
                    </td>
                    
                    <td><span class="status-pill <?php echo $status_class; ?>"><?php echo html_escape($category['status']?? ' '); ?></span></td>
                    <td class="text-end">
                        <button
                            class="btn btn-sm btn-light me-1"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#categoryFormModal"
                            data-category-mode="edit"
                        data-category-id="<?php echo $category['id'] ?? ''; ?>"
                        data-category-name="<?php echo html_escape($category['category_name'] ?? ''); ?>"
                        data-category-status="<?php echo html_escape($status); ?>"
                        data-category-description="<?php echo html_escape($category['description'] ?? ''); ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#categoryDeleteModal"
                            data-category-id="<?php echo $category['id'] ?? ''; ?>"
                            data-category-name="<?php echo html_escape($category['name'] ?? ''); ?>"
                            data-category-products="0"
                        >
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
          <?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="4">No categories found</td>
</tr>
<?php endif; ?>
</tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="categoryFormModal" tabindex="-1" aria-hidden="true">
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

         </div>


         
            
        </form>
        
    </div>
</div>

<div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content category-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">Delete Category</h5>
                    <p class="text-muted small mb-0">This is a UI demo confirmation only.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="delete-state">
                    <div class="delete-icon"><i class="bi bi-trash3"></i></div>
                    <div>
                        <div class="fw-semibold mb-1" data-category-delete-name>Category Name</div>
                        <p class="text-muted mb-0">This category currently maps to <span data-category-delete-products>0</span> products.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger">Delete Category</button>
            </div>
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
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('categoriesForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // ⛔ stop normal submit

    


        const formData = new FormData(this);
        const id = document.getElementById('categories_id').value;

        // ADD or UPDATE
        const url = id
            ? "<?= base_url('index.php/middle/updating_categories'); ?>"
            : "<?= base_url('index.php/middle/adding_categories'); ?>";

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                showUpdatePopup(data.message || "Success ✅");

                // refresh table after success
                setTimeout(() => {
                    window.location.href = "<?= base_url('index.php/admin/categories'); ?>";
                }, 1200);

            } else {
                showUpdatePopup(data.message || "Failed ❌", true);
            }
        })
        .catch(() => {
            showUpdatePopup("Server error ❌", true);
        });
    });

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

}); // ✅ IMPORTANT
</script>