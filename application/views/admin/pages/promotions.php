<section class="panel-card mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="panel-title mb-0">Saved Coupons</h2>
            <p class="page-subtitle mt-1">Create, edit, and remove coupon codes from a single modal workflow.</p>
        </div>
        <button
            class="btn btn-primary btn-sm"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#couponFormModal"
            data-coupon-mode="add"
        >
            <i class="bi bi-plus-lg me-1"></i>Add New Coupon
        </button>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>Coupon Code</th>
                <th>Type</th>
                <th>Discount</th>
                <th>Validity</th>
                <th>Usage</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($coupons as $coupon): ?>
                <?php
                $status_class = 'status-live';
                if ($coupon['status'] === 'Scheduled')
                {
                    $status_class = 'status-low';
                }
                elseif ($coupon['status'] === 'Expired' || $coupon['status'] === 'Draft')
                {
                    $status_class = 'status-out';
                }
                ?>
                <tr>
                    <td>
                        <div class="fw-semibold"><?php echo html_escape($coupon['code']); ?></div>
                        <div class="small text-muted"><?php echo html_escape($coupon['description']); ?></div>
                    </td>
                    <td><?php echo html_escape($coupon['type']); ?></td>
                    <td><?php echo html_escape($coupon['discount']); ?></td>
                    <td><?php echo html_escape($coupon['validity']); ?></td>
                    <td><?php echo html_escape($coupon['usage']); ?></td>
                    <td><span class="status-pill <?php echo $status_class; ?>"><?php echo html_escape($coupon['status']); ?></span></td>
                    <td class="text-end">
                        <button
                            class="btn btn-sm btn-light me-1"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#couponFormModal"
                            data-coupon-mode="edit"
                            data-coupon-code="<?php echo html_escape($coupon['code']); ?>"
                            data-coupon-type="<?php echo html_escape($coupon['type']); ?>"
                            data-coupon-discount="<?php echo html_escape($coupon['discount']); ?>"
                            data-coupon-validity="<?php echo html_escape($coupon['validity']); ?>"
                            data-coupon-status="<?php echo html_escape($coupon['status']); ?>"
                            data-coupon-description="<?php echo html_escape($coupon['description']); ?>"
                        >
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button
                            class="btn btn-sm btn-outline-danger"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#couponDeleteModal"
                            data-coupon-code="<?php echo html_escape($coupon['code']); ?>"
                            data-coupon-usage="<?php echo html_escape($coupon['usage']); ?>"
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

<div class="modal fade" id="couponFormModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content category-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" data-coupon-modal-title>Add Coupon</h5>
                    <p class="text-muted small mb-0" data-coupon-modal-subtitle>Create a new coupon code for promotions.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <form class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" data-coupon-input="code" placeholder="SUMMER10">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Coupon Type</label>
                        <select class="form-select" data-coupon-input="type">
                            <?php foreach ($coupon_types as $coupon_type): ?>
                                <option value="<?php echo html_escape($coupon_type); ?>"><?php echo html_escape($coupon_type); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Discount</label>
                        <input type="text" class="form-control" data-coupon-input="discount" placeholder="10% or $5 off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Validity</label>
                        <input type="text" class="form-control" data-coupon-input="validity" placeholder="Mar 01 - Mar 31">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" data-coupon-input="status">
                            <?php foreach ($coupon_status_options as $coupon_status): ?>
                                <option value="<?php echo html_escape($coupon_status); ?>"><?php echo html_escape($coupon_status); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="4" data-coupon-input="description" placeholder="Coupon usage notes"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-coupon-submit-label>Save Coupon</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="couponDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content category-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">Delete Coupon</h5>
                    <p class="text-muted small mb-0">This confirmation is for UI flow only.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="delete-state">
                    <div class="delete-icon"><i class="bi bi-ticket-perforated"></i></div>
                    <div>
                        <div class="fw-semibold mb-1" data-coupon-delete-code>Coupon Code</div>
                        <p class="text-muted mb-0">This coupon has been used <span data-coupon-delete-usage>0</span> times.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger">Delete Coupon</button>
            </div>
        </div>
    </div>
</div>
