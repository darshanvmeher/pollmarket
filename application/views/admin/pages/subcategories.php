<section class="panel-card mt-3">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h2 class="panel-title mb-0">Saved Subcategories</h2>
            <p class="page-subtitle mt-1">
                Manage subcategory masters with modal-based add, edit, and delete actions.
            </p>
        </div>

        <button
            class="btn btn-success btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#subModal"
            data-mode="add">
            <i class="bi bi-plus-lg me-1"></i>Add New Subcategory
        </button>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table id="myTable" class="table align-middle">

            <thead>
                <tr>
                    <th>CATEGORY</th>
                    <th>SUBCATEGORY</th>
                    <th>DESCRIPTION</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTION</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($subcategories as $sub): ?>

                <?php
                $status_class = 'status-live';
                if ($sub['status'] == 'Review') $status_class = 'status-low';
                if ($sub['status'] == 'Draft') $status_class = 'status-out';
                ?>

                <tr>
                    <td><?= $sub['category_name']; ?></td>
                    <td><?= $sub['sub_category_name']; ?></td>
                    <td><?= $sub['description']; ?></td>

                    <td>
                        <span class="status-pill <?= $status_class ?>">
                            <?= $sub['status']; ?>
                        </span>
                    </td>

                    <td class="text-end">

                        <!-- EDIT -->
                        <button
                            class="btn btn-sm btn-light me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#subModal"
                            data-mode="edit"
                            data-id="<?= $sub['id']; ?>"
                            data-name="<?= $sub['sub_category_name']; ?>"
                            data-category="<?= $sub['category_id']; ?>"
                            data-status="<?= $sub['status']; ?>"
                            data-description="<?= $sub['description']; ?>">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>

                        <!-- DELETE -->
                        <button
                            class="btn btn-sm btn-outline-danger deleteBtn"
                            data-id="<?= $sub['id']; ?>">
                            <i class="bi bi-trash"></i> Delete
                        </button>

                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</section>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="subModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <form id="subForm">

        <div class="modal-header border-0">
          <div>
            <h5 class="modal-title">Add Subcategory</h5>
            <p class="text-muted small mb-0">Create a new subcategory.</p>
          </div>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="id">

          <!-- CATEGORY -->
          <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category_id" id="category_id">
              <option value="">Select Category</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id']; ?>">
                  <?= $cat['category_name']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- NAME -->
          <div class="mb-3">
            <label class="form-label">Subcategory Name</label>
            <input type="text" class="form-control" name="sub_category_name" id="name">
          </div>

          <!-- STATUS -->
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" id="status">
              <option>Active</option>
              <option>Review</option>
              <option>Draft</option>
            </select>
          </div>

          <!-- DESCRIPTION -->
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
          </div>

        </div>

        <div class="modal-footer border-0">
          <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Subcategory</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ================= DELETE MODAL ================= -->
<div class="modal fade" id="deleteSubModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Delete Subcategory</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Are you sure you want to delete this subcategory?
      </div>

      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteSub">Delete</button>
      </div>

    </div>
  </div>
</div>

<!-- ================= POPUP ================= -->
<div id="updatePopup" style="
position: fixed;
top: 20px;
right: 20px;
background: #1f8a39;
color: #fff;
padding: 10px 20px;
border-radius: 5px;
display: none;
z-index: 9999;">
</div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// POPUP
function showUpdatePopup(message) {
    const popup = document.getElementById('updatePopup');
    popup.innerText = message;
    popup.style.display = 'block';

    setTimeout(() => popup.style.display = 'none', 2000);
}

// MODAL SET DATA
const modal = document.getElementById('subModal');

modal.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const mode = button.getAttribute('data-mode');

    const name = button.getAttribute('data-name');
    const status = button.getAttribute('data-status');
    const description = button.getAttribute('data-description');
    const category = button.getAttribute('data-category');
    const id = button.getAttribute('data-id');

    if (mode === 'edit') {
        document.getElementById('name').value = name;
        document.getElementById('status').value = status;
        document.getElementById('description').value = description;
        document.getElementById('category_id').value = category;
        document.getElementById('id').value = id;

        document.querySelector('.modal-title').innerText = "Edit Subcategory";
    } else {
        document.getElementById('name').value = "";
        document.getElementById('status').selectedIndex = 0;
        document.getElementById('description').value = "";
        document.getElementById('category_id').value = "";
        document.getElementById('id').value = "";

        document.querySelector('.modal-title').innerText = "Add Subcategory";
    }
});

// SAVE
document.getElementById("subForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);
    let id = document.getElementById("id").value;

    let url = id
        ? "<?= base_url('index.php/middle/updating_subcategories'); ?>"
        : "<?= base_url('index.php/middle/adding_subcategories'); ?>";

    fetch(url,{
        method:"POST",
        body:formData
    })
    .then(res => res.json())
    .then(data => {
        showUpdatePopup(data.message);
        setTimeout(()=> location.reload(), 1000);
    });
});

// DELETE
let deleteId = null;

document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        deleteId = this.dataset.id;
        new bootstrap.Modal(document.getElementById('deleteSubModal')).show();
    });
});

document.getElementById('confirmDeleteSub').addEventListener('click', function () {

    fetch("<?= base_url('index.php/middle/deleting_subcategories'); ?>", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "id=" + deleteId
    })
    .then(res => res.json())
    .then(data => {
        showUpdatePopup(data.message);
        setTimeout(()=> location.reload(), 1000);
    });
});
</script>