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
                <th>Slug</th>
                <th>Subcategories</th>
                <th>Products</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <?php
                $status_class = 'status-live';
                if ($category['status'] === 'Review')
                {
                    $status_class = 'status-low';
                }
                elseif ($category['status'] === 'Draft')
                {
                    $status_class = 'status-out';
                }
                ?>
                <tr>
                    <td>
                        <div class="fw-semibold"><?php echo html_escape($category['name']); ?></div>
                        <div class="small text-muted"><?php echo html_escape($category['description']); ?></div>
                    </td>
                    <td><?php echo html_escape($category['slug']); ?></td>
                    <td><?php echo html_escape($category['subcategories']); ?></td>
                    <td><?php echo html_escape($category['products']); ?></td>
                    <td><span class="status-pill <?php echo $status_class; ?>"><?php echo html_escape($category['status']); ?></span></td>
                    <td class="text-end">
                        <button
                            class="btn btn-sm btn-light me-1"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#categoryFormModal"
                            data-category-mode="edit"
                            data-category-name="<?php echo html_escape($category['name']); ?>"
                            data-category-status="<?php echo html_escape($category['status']); ?>"
                            data-category-description="<?php echo html_escape($category['description']); ?>"
                        >
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#categoryDeleteModal"
                            data-category-name="<?php echo html_escape($category['name']); ?>"
                            data-category-products="<?php echo html_escape($category['products']); ?>"
                        >
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade" id="categoryFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content category-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" data-category-modal-title>Add Category</h5>
                    <p class="text-muted small mb-0" data-category-modal-subtitle>Create a new category master for the catalog.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <form class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" data-category-input="name" placeholder="Paper Bags">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" data-category-input="status">
                            <?php foreach ($status_options as $status_option): ?>
                                <option value="<?php echo html_escape($status_option); ?>"><?php echo html_escape($status_option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" data-category-input="description" placeholder="Short category summary"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-category-submit-label>Save Category</button>
            </div>
        </div>
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
