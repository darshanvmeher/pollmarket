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
        <table id="myTable"class="table align-middle">
            <thead>
            <tr>
                <th>Coupon Code</th>
                <th>Type</th>
                <th>Discount Type</th>
                <th>Discount Value</th>
                <th>Validity</th>
                <th>Description</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($promotions as $promotion): ?>
                <?php
                $status_class = 'status-live';
                if ($promotion['status'] === 'Scheduled')
                {
                    $status_class = 'status-low';
                }
                elseif ($promotion['status'] === 'Expired' || $promotion['status'] === 'Draft')
                {
                    $status_class = 'status-out';
                }
                ?>
                <tr>
                    <td>
                        <div class="fw-semibold"><?php echo html_escape($promotion['coupon_code']); ?></div>

                    </td>
                 
                    <td><?php echo html_escape($promotion['coupon_type']); ?></td>
                    <td><?php echo html_escape($promotion['discount_type']); ?></td>
                    <td><?php echo html_escape($promotion['discount_value']); ?></td>
                    <td><?php echo html_escape($promotion['validity']); ?></td>
                    <td><?php echo html_escape($promotion['description']); ?></td>
                    <td><span class="status-pill <?php echo $status_class; ?>"><?php echo html_escape($promotion['status']); ?></span></td>
                    <td class="text-end">
                        <button
                            class="btn btn-sm btn-light me-1"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#couponFormModal"
                            data-coupon-mode="edit"
                            data-coupon-id="<?php echo $promotion['id']; ?>"
                            data-coupon-code="<?php echo html_escape($promotion['coupon_code']); ?>"
                            data-coupon-type="<?php echo html_escape($promotion['coupon_type']); ?>"
                            data-coupon-discount-type="<?php echo html_escape($promotion['discount_type']); ?>"
                            data-coupon-discount-value="<?php echo html_escape($promotion['discount_value']); ?>"
                            data-coupon-validity="<?php echo html_escape($promotion['validity']); ?>"
                            data-coupon-status="<?php echo html_escape($promotion['status']); ?>"
                            data-coupon-description="<?php echo html_escape($promotion['description']); ?>"
                        >
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button
                          
                                class="btn btn-sm btn-outline-danger delete-btn"
                                data-id="<?php echo $promotion['id']; ?>"
                                data-name="<?php echo html_escape($promotion['coupon_code']); ?>"
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
                        <form id="couponForm" class="row g-3">

                        <input type="hidden" id="coupon_id" name="id">
 

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" data-coupon-modal-title>Add Coupon</h5>
                    <p class="text-muted small mb-0" data-coupon-modal-subtitle>Create a new coupon code for promotions.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
    <div class="modal-body pt-3">

    <!-- Coupon Code -->
    <div class="col-md-6">
        <label class="form-label">Coupon Code</label>
        <input type="text" class="form-control" 
               data-coupon-input="code" 
               name="coupon_code" 
               placeholder="SUMMER10" required>
    </div>

    <!-- Coupon Type -->
    <div class="col-md-6">
        <label class="form-label">Coupon Type</label>
        <select class="form-select" 
                data-coupon-input="type" 
                name="coupon_type" required>
            <?php foreach ($coupon_types as $coupon_type): ?>
                <option value="<?php echo html_escape($coupon_type); ?>">
                    <?php echo html_escape($coupon_type); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Discount Type -->
    <div class="col-md-6">
        <label class="form-label">Discount Type</label>
        <select class="form-select" 
                data-coupon-input="discount_type" 
                name="discount_type" required>
            <option value="percent">Percentage</option>
            <option value="flat">Flat Amount</option>
        </select>
    </div>


    <!-- Discount Value -->
    <div class="col-md-6">
        <label class="form-label">Discount Value</label>
        <input type="number" class="form-control" 
               data-coupon-input="discount_value" 
               name="discount_value" 
               placeholder="10 or 100" required>
    </div>

            <!--Validity-->
    
            <div class="col-md-6">
    <label class="form-label">Validity</label>
    <input type="text" class="form-control" 
           data-coupon-input="validity" 
           name="validity" 
           placeholder="01May-20May" required>
</div>

    <!-- Status -->
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select class="form-select" 
                data-coupon-input="status" 
                name="status" required>
            <?php foreach ($coupon_status_options as $coupon_status): ?>
                <option value="<?php echo html_escape($coupon_status); ?>">
                    <?php echo html_escape($coupon_status); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Description -->
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control" rows="4" 
                  data-coupon-input="description" 
                  name="description"
                  placeholder="Describe this coupon"
                  required></textarea>
    </div>

</div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" data-coupon-submit-label>Save Coupon</button>
            </div>


              </form>    
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
                <button type="button" class="btn btn-outline-danger" id="confirmDeleteBtn">
                        Delete Coupon
                </button>
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

    const couponModal = document.getElementById('couponFormModal');

    if (!couponModal) return; // safety check

    couponModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const mode = button.getAttribute('data-coupon-mode');
        const code = button.getAttribute('data-coupon-code');
        const type = button.getAttribute('data-coupon-type');
        const discount_value = button.getAttribute('data-coupon-discount-value'); // ✅ new
        const discount_type = button.getAttribute('data-coupon-discount-type'); // ✅ new
        const validity = button.getAttribute('data-coupon-validity');
        const status = button.getAttribute('data-coupon-status');
        const description = button.getAttribute('data-coupon-description');

        const idInput = document.getElementById('coupon_id');
        const id = button.getAttribute('data-coupon-id');

        if (mode === 'edit') {
            document.querySelector('[name="coupon_code"]').value = code;
            document.querySelector('[name="coupon_type"]').value = type;
            document.querySelector('[name="discount_type"]').value = discount_type; // ✅ new
            document.querySelector('[name="discount_value"]').value = discount_value; // ✅ new
            document.querySelector('[name="validity"]').value = validity;
            document.querySelector('[name="status"]').value = status;
            document.querySelector('[name="description"]').value = description;

            idInput.value = id;
        } else {
            document.getElementById('couponForm').reset();
            idInput.value = "";
        }

    });

});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    let deletePromotionId = null;

    // When delete button clicked → open modal
    document.querySelectorAll('.delete-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            deletePromotionId = this.dataset.id;

            // Set promotion name
            document.querySelector('[data-coupon-delete-code]').textContent =
                this.dataset.name || 'Coupon';

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('couponDeleteModal'));
            modal.show();
        });

    });

    // Confirm delete button (use ID instead of class)
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {

        if (!deletePromotionId) return;

        fetch("<?= base_url('index.php/middle/deleting_promotion'); ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + deletePromotionId
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {

                showUpdatePopup('Coupon deleted successfully ✅');

                // Remove row
                document.querySelector(`.delete-btn[data-id="${deletePromotionId}"]`)
                    ?.closest('tr').remove();

                // Close modal
                bootstrap.Modal.getInstance(
                    document.getElementById('couponDeleteModal')
                ).hide();
                document.body.focus();
                document.activeElement.blur();

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


<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('couponForm');

    // ✅ EDIT BUTTON CLICK (SET DATA IN FORM)
    document.querySelectorAll('[data-coupon-mode="edit"]').forEach(btn => {
        btn.addEventListener('click', function () {

            document.getElementById('coupon_id').value = this.dataset.couponId || '';

            document.querySelector('[name="coupon_code"]').value = this.dataset.couponCode || '';
            document.querySelector('[name="discount_value"]').value = this.dataset.couponDiscountValue || '';
            document.querySelector('[name="discount_type"]').value = this.dataset.couponDiscountType || '';
            document.querySelector('[name="coupon_type"]').value = this.dataset.couponType || '';
            document.querySelector('[name="validity"]').value = this.dataset.couponValidity || '';
            document.querySelector('[name="status"]').value = this.dataset.couponStatus || '';
            document.querySelector('[name="description"]').value = this.dataset.couponDescription || '';
        });
    });

    // ✅ FORM SUBMIT
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        // ✅ GET ID SAFELY
        const id = document.getElementById('coupon_id')?.value?.trim();

        // ✅ DECIDE API
        const url = (id && id !== "")
            ? "<?= base_url('index.php/middle/updating_promotion'); ?>"
            : "<?= base_url('index.php/middle/adding_promotion'); ?>";

        // ✅ DEBUG (optional)
        console.log("Submitting ID:", id, "URL:", url);

        fetch(url, {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + localStorage.getItem("token")
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                showUpdatePopup(data.message || "Success ✅");

                // ✅ RESET FORM AFTER SAVE
                form.reset();
                document.getElementById('coupon_id').value = "";

                setTimeout(() => {
                    window.location.reload();
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