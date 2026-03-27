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
        <?php echo html_escape($product['status']); ?>
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
            data-category_id="<?= $product['category_id']; ?>"
            data-sub_category_id="<?= $product['sub_category_id']; ?>"
            data-name="<?= html_escape($product['product_name']); ?>"
            data-price="<?= $product['price']; ?>"
            data-stock="<?= $product['stock']; ?>"
            data-description="<?= html_escape($product['description']); ?>"
            data-status="<?= $product['status']; ?>"
            data-images='<?= json_encode($product["images"] ?? []); ?>'
            data-videos='<?= json_encode($product["videos"] ?? []); ?>'
            data-attributes='<?= json_encode($product["attributes"] ?? []); ?>'
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
<div class="modal fade" id="productFormModal" tabindex="-1" aria-hidden="true">
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
                    
                        <!-- PHOTOS -->
                    <div class="form-group">
                        <label>Upload Photos</label>
                        <input type="file" id="photoInput" name="photo[]" multiple accept="image/*"  class="form-control">
                        <ul id="photoPreview" class="mt-2 text-muted"></ul>
                    </div>

                    <!-- VIDEOS -->
                    <div class="form-group">
                        <label>Upload Videos</label>
                        <input type="file" id="videoInput" name="video[]" multiple accept="video/*" class="form-control">
                         <ul id="videoPreview" class="mt-2 text-muted"></ul>
                    </div>

                    <div id="existingMedia"></div>

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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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
const modal = document.getElementById('productFormModal');


modal.addEventListener('show.bs.modal', function (event) {
    attrIndex = 1; // 🔥 RESET INDEX

    const btn = event.relatedTarget;
     console.log("Clicked button:", btn);
    console.log("Mode:", btn.getAttribute('data-mode'));
    console.log("Edit ID:", btn.dataset.id);
    const mode = btn.getAttribute('data-mode');

    const form = document.getElementById('productForm');
    form.reset();

    // ✅ CLEAR
    document.getElementById('existingMedia').innerHTML = '';
    const container = document.getElementById('attributesContainer');
    container.innerHTML = '';

    if (mode === 'edit') {

        document.getElementById('productModalTitle').innerText = "Edit Product";

        document.getElementById('product_id').value = btn.dataset.id;
        form.product_name.value = btn.dataset.name;
        form.price.value = btn.dataset.price;
        form.stock.value = btn.dataset.stock;
        form.description.value = btn.dataset.description;
        form.status.value = btn.dataset.status;
        form.category_id.value = btn.dataset.category_id;
        form.sub_category_id.value = btn.dataset.sub_category_id;

        // ✅ MEDIA
        loadExistingMedia(btn.dataset.id);

        // ✅ ATTRIBUTES
        let attributes = JSON.parse(btn.dataset.attributes || '[]');

        attributes.forEach((attr, index) => {

            let selectHtml = `<select name="attributes[${index}][attribute_id]" class="form-select">`;

            <?php foreach ($attributes as $a): ?>
                selectHtml += `
                    <option value="<?= $a['id']; ?>" 
                    ${parseInt(attr.attribute_id) === <?= $a['id']; ?> ? 'selected' : ''}>
                        <?= $a['attribute_name']; ?>
                    </option>`;
            <?php endforeach; ?>

            selectHtml += `</select>`;

            container.innerHTML += `
            <div class="row mb-2">
                <div class="col-md-5">
                    ${selectHtml}
                </div>

                <div class="col-md-5">
                    <input type="text" 
                        name="attributes[${index}][value]" 
                        value="${attr.value}" 
                        class="form-control">
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger removeAttr">X</button>
                </div>
            </div>`;
        });

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
    </div>`

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
let selectedPhotos = [];

const photoInput   = document.getElementById('photoInput');
const photoPreview = document.getElementById('photoPreview');

photoInput.addEventListener('change', function () {

    // Add newly selected files
    for (let file of this.files) {
        selectedPhotos.push(file);
    }

    renderPhotoPreview();
    updatePhotoInput();
});

// Render file names + cancel button
function renderPhotoPreview() {
    photoPreview.innerHTML = '';

    selectedPhotos.forEach((file, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${file.name}
            <button type="button"
                    class="btn btn-sm btn-danger ms-2"
                    onclick="removePhoto(${index})">
                ✖
            </button>
        `;
        photoPreview.appendChild(li);
    });
}

// Remove single image
function removePhoto(index) {
    selectedPhotos.splice(index, 1);
    renderPhotoPreview();
    updatePhotoInput();
}

// Rebuild FileList (important)
function updatePhotoInput() {
    const dataTransfer = new DataTransfer();
    selectedPhotos.forEach(file => dataTransfer.items.add(file));
    photoInput.files = dataTransfer.files;
}
</script>

<script>
let selectedVideos = [];

const videoInput   = document.getElementById('videoInput');
const videoPreview = document.getElementById('videoPreview');

videoInput.addEventListener('change', function () {

    for (let file of this.files) {
        selectedVideos.push(file);
    }

    renderVideoPreview();
    updateVideoInput();
});

function renderVideoPreview() {
    videoPreview.innerHTML = '';

    selectedVideos.forEach((file, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${file.name}
            <button type="button"
                    class="btn btn-sm btn-danger ms-2"
                    onclick="removeVideo(${index})">
                ✖
            </button>
        `;
        videoPreview.appendChild(li);
    });
}

function removeVideo(index) {
    selectedVideos.splice(index, 1);
    renderVideoPreview();
    updateVideoInput();
}

function updateVideoInput() {
    const dataTransfer = new DataTransfer();
    selectedVideos.forEach(file => dataTransfer.items.add(file));
    videoInput.files = dataTransfer.files;
}
</script>


<script>
function loadExistingMedia(productId) {

    fetch("<?= base_url('index.php/api_handler/product_media_by_id'); ?>", {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'product_id=' + productId
    })
    .then(res => res.json())
    .then(res => {
        let html = '<h5 class="mt-3">Existing Media</h5>';

        res.data.forEach(m => {
            html += `
            <div class="mb-2">
                ${
                    m.media_type === 'photo'
                    ? `<img src="<?= base_url(); ?>${m.media_path}" width="80">`
                    : `<video width="120" controls src="<?= base_url(); ?>${m.media_path}"></video>`
                }
                <button type="button"
                        class="btn btn-sm btn-danger ms-2"
                        onclick="deleteMedia(${m.id})">✖</button>
            </div>`;
        });

        document.getElementById('existingMedia').innerHTML = html;
    });
}
</script>



<!--Delete existing media-->

<script>
function deleteMedia(mediaId) {
    if (!confirm('Delete this media?')) return;

    fetch("<?= base_url('index.php/api_handler/delete_product_media'); ?>", {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'media_id='+mediaId
    })
    .then(res=>res.json())
    .then(res=>{
        if(res.status){
            loadExistingMedia(document.getElementById('product_id').value);
        }
    });
}
</script>




<script>
    document.getElementById('productForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;

    const photoInput = document.getElementById('photoInput');
    const videoInput = document.getElementById('videoInput');

    const allowedPhotoTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    const allowedVideoTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv'];

    /* ---------- VALIDATION ---------- */
    if (photoInput.files.length > 0) {
        for (let file of photoInput.files) {
            if (!allowedPhotoTypes.includes(file.type)) {
                showUpdatePopup('❌ Invalid photo format', true);
                return;
            }
        }
    }

    if (videoInput.files.length > 0) {
        for (let file of videoInput.files) {
            if (!allowedVideoTypes.includes(file.type)) {
                showUpdatePopup('❌ Invalid video format', true);
                return;
            }
        }
    }

    /* ---------- URL FIX ---------- */
    const id = document.getElementById('product_id').value;

    const url = id
        ? "<?= base_url('index.php/middle/updating_product'); ?>"
        : "<?= base_url('index.php/middle/adding_product'); ?>";

    const formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())   // DEBUG SAFE
    .then(data => {
        console.log("RAW RESPONSE:", data);

        try {
            const json = JSON.parse(data);

            if (json.status) {
                showUpdatePopup(json.message);
                setTimeout(() => location.reload(), 1200);
            } else {
                showUpdatePopup(json.message, true);
            }

        } catch (e) {
            console.error("NOT JSON:", data);
            showUpdatePopup("Server returned HTML ❌", true);
        }
    });
});
</script>

<script>
const modalEl = document.getElementById('productFormModal');

let lastFocused = null;

// store button that opened modal
modalEl.addEventListener('show.bs.modal', function (e) {
    lastFocused = e.relatedTarget;
});

// fix focus + reset when modal closes
modalEl.addEventListener('hide.bs.modal', function () {

    // 🔥 FORCE REMOVE FOCUS FROM MODAL
    if (document.activeElement && modalEl.contains(document.activeElement)) {
        document.activeElement.blur();
    }

    // 🔥 MOVE FOCUS OUTSIDE MODAL (VERY IMPORTANT)
    document.body.focus();

    // 🔥 RETURN FOCUS TO BUTTON
    if (lastFocused) {
        lastFocused.focus();
    }

    // 🔥 RESET ATTRIBUTES
    document.getElementById('attributesContainer').innerHTML = '';
    attrIndex = 1;
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    let deleteProductId = null;

    // ✅ FIX CLASS NAME
    document.querySelectorAll('.delete-product-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            deleteProductId = this.dataset.id;

            if (!confirm("Delete this product?")) return;

            fetch("<?= base_url('index.php/middle/deleting_product'); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + deleteProductId
            })
            .then(res => res.json())
            .then(data => {

                if (data.status) {

                    showUpdatePopup('Product deleted successfully ✅');

                    // ✅ REMOVE ROW
                    this.closest('tr').remove();

                } else {
                    showUpdatePopup(data.message || 'Delete failed ❌', true);
                }

            })
            .catch(() => {
                showUpdatePopup('Server error ❌', true);
            });

        });

    });

});
</script>