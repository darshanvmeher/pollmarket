<?php $this->load->view('frontend/partials/header'); ?>

<section class="mb-4">
    <div class="section-heading">
        <div class="section-kicker">Shop</div>
        <h1 class="section-title">Browse every product with an easy filter-first layout</h1>
        <p class="section-copy">Built for fast product discovery across packaging, stationery, and security supplies.</p>
    </div>
    <!--
    <div class="chip-row mb-4">
            <a class="chip active" href="#" data-id="all">All</a>
        <?php foreach ($categories as $index => $category): ?>
            <a class="chip <?php echo $index === 0 ? 'active' : ''; ?>" href="#" data-id="<?php echo $category['id']; ?>">
        <?php echo html_escape($category['category_name']); ?></a>
        <?php endforeach; ?>
    </div>-->

   <!-- <div class="chip-row mb-4">

    ALL
    <a class="chip <?= $active_category == 'all' ? 'active' : '' ?>"
       href="<?= base_url('shop?id=all') ?>">
       All
    </a>

     DYNAMIC 
    <?php foreach ($categories as $category): ?>
        <a class="chip <?= $active_category == $category['id'] ? 'active' : '' ?>"
           href="<?= base_url('shop?id='.$category['id']) ?>">
           <?= html_escape($category['category_name']); ?>
        </a>
    <?php endforeach; ?>

</div>-->

<!--
<div class="chip-row mb-4">

    <a class="chip <?= $active_category == 'all' ? 'active' : '' ?>"
       href="<?= base_url('shop?id=all') ?>">
       All
    </a>

    <?php foreach ($categories as $category): ?>
        <a class="chip <?= $active_category == $category['id'] ? 'active' : '' ?>"
           href="<?= base_url('shop?id='.$category['id']) ?>">
           <?= html_escape($category['category_name']); ?>
        </a>
    <?php endforeach; ?>

    -->

    <div class="chip-row mb-4">

    <a class="chip active" href="javascript:void(0)" data-id="all">
        All
    </a>

    <?php foreach ($categories as $category): ?>
        <a class="chip"
           href="javascript:void(0)"
           data-id="<?= $category['id']; ?>">
           <?= html_escape($category['category_name']); ?>
        </a>
    <?php endforeach; ?>

</div>

</div>
    <div class="row g-3">
        <div class="col-lg-3">
              
            <div class="surface-card p-3" id="subcategory-card">

                <h2 class="h6 fw-bold">Filters</h2>
                <label class="form-label mt-2">Subcategory</label>
                <select class="form-select" id="subcategory-dropdown">
                     <option value="all">All</option>

                <?php foreach ($subcategories as $subcategory): ?>
                    <option value="<?= $subcategory['id']; ?>">
                        <?= html_escape($subcategory['sub_category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
                <label class="form-label mt-3">Price Range</label>
                <input class="form-range" type="range">
                <label class="form-label mt-3">Sort</label>
                <select class="form-select"><option>Featured</option><option>Price Low to High</option><option>Newest</option></select>
            </div>
        </div>
        <!--<div class="col-lg-9">
            <div class="row g-3" id="product-list"> 
                <?php foreach ($products as $index => $product): ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="product-card">
                            <div class="product-thumb d-flex flex-column justify-content-between">
                                <div class="product-photo">
                               <img src="<?= base_url($product['media'][0]['media_path'] ?? 'assets/no-image.png') ?>" alt="<?= html_escape($product['product_name']) ?>"   >
                                </div>
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="product-pill"><?php echo html_escape($product['badge']); ?></span>
                                    <span class="product-pill"><i class="bi bi-star-fill"></i> <?php echo html_escape($product['rating']); ?></span>
                                </div>
                                <div>
                                    <div class="text-white-50 small"><?php echo html_escape($product['category_name']); ?></div>
                                    <h3 class="h5 mt-1 mb-0"><?php echo html_escape($product['product_name']); ?></h3>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price"><?php echo html_escape($product['price']); ?></span>
                                        <span class="price-old ms-2"><?php echo html_escape($product['strike_price']); ?></span>
                                    </div>
                                    <a class="btn btn-sm btn-primary"  href="<?php echo site_url('frontend/product/' . $product['id']); ?>"> View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>-->
        <div class="row g-3" id="product-list"> 

    <?php if (!empty($products)): ?>

        <?php foreach ($products as $product): ?>

            <div class="col-md-6 col-xl-4">
                <div class="product-card">
                    <div class="product-thumb d-flex flex-column justify-content-between">

                        <div class="product-photo">
                            <img src="<?= base_url($product['media'][0]['media_path'] ?? 'assets/no-image.png') ?>" 
                                 alt="<?= html_escape($product['product_name']) ?>">
                        </div>

                        <div class="d-flex justify-content-between align-items-start">
                            <span class="product-pill"><?= html_escape($product['badge']); ?></span>
                            <span class="product-pill">
                                <i class="bi bi-star-fill"></i> <?= html_escape($product['rating']); ?>
                            </span>
                        </div>

                        <div>
                            <div class="text-white-50 small">
                                <?= html_escape($product['category_name']); ?>
                            </div>
                            <h3 class="h5 mt-1 mb-0">
                                <?= html_escape($product['product_name']); ?>
                            </h3>
                        </div>

                    </div>

                    <div class="p-3">
                        <!--
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="price">₹<?= html_escape($product['price']); ?></span>
                                <span class="price-old ms-2">
                                    <?= html_escape($product['strike_price']); ?>
                                </span>
                            </div>

                            <a class="btn btn-sm btn-primary"
                               href="<?= site_url('frontend/product/' . $product['id']); ?>">
                               View
                            </a>
                        </div>
                        -->
                        <a class="btn btn-sm btn-primary w-100"
                           href="<?= site_url('frontend/contact'); ?>">
                           Enquire Now
                        </a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    <?php else: ?>
        <!-- ✅ IMPORTANT -->
        <div class="col-12 text-center">
            <p>No products found</p>
        </div>
    <?php endif; ?>

</div>
    </div>
</section>

<?php $this->load->view('frontend/partials/footer'); ?>


<!-- js for shop page
<script>

    $(document).on('click', '.chip', function(e) {
    e.preventDefault();

    $('.chip').removeClass('active');
    $(this).addClass('active');

    let category_id = $(this).data('id');

    $.ajax({
        url: "<?= base_url('index.php/api_handler/get_products_by_category') ?>",
        type: "POST",
        data: { category_id: category_id },
        success: function(response) {
            $('#product-list').html(response);
        }
    });
});
</script>   
                -->


                
                   
<!-- js for shop page with category filter
<script>

    $.ajax({
    url: "<?= base_url('index.php/api_handler/get_products_by_category') ?>",
    type: "POST",
    data: { category_id: category_id },
    success: function(response) {
        $('#product-list').html(response);
    }
});
</script>-->


<!--
<script>
$(document).on('click', '.chip', function(e) {
    e.preventDefault();

    $('.chip').removeClass('active');
    $(this).addClass('active');

    let id = $(this).data('id');

    $.ajax({
        url: "<?= base_url('index.php/api_handler/products_by_category') ?>",
        type: "POST",
        data: { category_id: id },
        success: function(res) {

            let response = JSON.parse(res);
            let html = '';

            if (response.status) {
                response.data.forEach(function(product) {

                    let image = '';
                    if (product.media && product.media.length > 0) {
                        image = "<?= base_url() ?>" + product.media[0].media_path;
                    }

                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="product-card">
                                <img src="${image}" class="img-fluid">
                                <h6>${product.product_name}</h6>
                                <p>₹${product.price}</p>
                            </div>
                        </div>
                    `;
                });
            }

            // ✅ ONLY update HTML
            $('#product-list').html(html);
        }
    });
});
</script>

                -->


<!--
<script>
$(document).on('click', '.chip', function(e) {
    e.preventDefault();

    $('.chip').removeClass('active');
    $(this).addClass('active');

    let id = $(this).data('id');

    // ✅ update URL
    window.history.pushState({}, '', '?id=' + id);

    loadProducts(id);
});

// ✅ separate function (clean)
function loadProducts(id) {

    $('#product-list').html('<p>Loading...</p>');

    $.ajax({
        url: "<?= base_url('index.php/api_handler/products_by_category') ?>",
        type: "POST",
        data: { category_id: id },

        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            console.log(response); // 🔍 DEBUG

            let html = '';

            if (response.status && response.data.length > 0) {

                response.data.forEach(function(product) {

                    let image = "<?= base_url('assets/no-image.png') ?>";

                    if (product.media && product.media.length > 0) {
                        image = "<?= base_url() ?>" + product.media[0].media_path;
                    }

                  html += `
<div class="col-md-6 col-xl-4">
    <div class="product-card">

        <div class="product-thumb d-flex flex-column justify-content-between">

            <div class="product-photo">
                <img src="${image}" alt="${product.product_name}">
            </div>

            <div class="d-flex justify-content-between align-items-start">
                <span class="product-pill">${product.badge ?? ''}</span>
                <span class="product-pill">
                    <i class="bi bi-star-fill"></i> ${product.rating ?? ''}
                </span>
            </div>

            <div>
                <div class="text-white-50 small">
                    ${product.category_name ?? ''}
                </div>
                <h3 class="h5 mt-1 mb-0">
                    ${product.product_name}
                </h3>
            </div>

        </div>

        <div class="p-3">
            <!--
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="price">₹${product.price}</span>
                    <span class="price-old ms-2">${product.strike_price ?? ''}</span>
                </div>

                <a class="btn btn-sm btn-primary"
                   href="<?= site_url('frontend/product/') ?>${product.id}">
                   View
                </a>
            </div>
            -->
            <a class="btn btn-sm btn-primary w-100"
               href="<?= site_url('frontend/contact'); ?>">
               Enquire Now
            </a>
        </div>

    </div>
</div>`;
                });

            } else {
                html = '<div class="col-12 text-center"><p>No products found</p></div>';
            }

            $('#product-list').html(html);
        },

        error: function(xhr) {
            console.error(xhr);
            $('#product-list').html('<p>Error loading products</p>');
        }
    });
}

// ✅ IMPORTANT: LOAD ON PAGE REFRESH
$(document).ready(function () {

    let urlParams = new URLSearchParams(window.location.search);
    let id = urlParams.get('id') || 'all';

    // set active chip
    $('.chip').removeClass('active');
    $('.chip[data-id="'+id+'"]').addClass('active');

    // load products
    loadProducts(id);
});
</script>

    -->



    <!--
    <script>

function loadProducts(id = 'all') {

    $('#product-list').html('<p>Loading...</p>');

    $.ajax({
        url: "<?= base_url('index.php/api_handler/products_by_category') ?>",
        type: "POST",
        data: { category_id: id },

        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            let html = '';

            if (response.status && response.data.length > 0) {

                response.data.forEach(function(product) {

                    let image = "<?= base_url('assets/no-image.png') ?>";

                    if (product.media && product.media.length > 0) {
                        image = "<?= base_url() ?>" + product.media[0].media_path;
                    }

                    html += `
                    <div class="col-md-6 col-xl-4">
                        <div class="product-card">

                            <div class="product-thumb d-flex flex-column justify-content-between">

                                <div class="product-photo">
                                    <img src="${image}" alt="${product.product_name}">
                                </div>

                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="product-pill">${product.badge ?? ''}</span>
                                    <span class="product-pill">⭐ ${product.rating ?? ''}</span>
                                </div>

                                <div>
                                    <div class="text-white-50 small">
                                        ${product.category_name ?? ''}
                                    </div>
                                    <h3 class="h5 mt-1 mb-0">
                                        ${product.product_name ?? ''}
                                    </h3>
                                </div>

                            </div>

                            <div class="p-3">
                                <!--
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="price">₹${product.price ?? 0}</span>
                                        <span class="price-old ms-2">${product.strike_price ?? ''}</span>
                                    </div>

                                    <a class="btn btn-sm btn-primary"
                                       href="<?= site_url('frontend/product/') ?>${product.id}">
                                       View
                                    </a>
                                </div>
                                -->
                                <a class="btn btn-sm btn-primary w-100"
                                   href="<?= site_url('frontend/contact'); ?>">
                                   Enquire Now
                                </a>
                            </div>

                        </div>
                    </div>`;
                });

            } else {
                html = '<p>No products found</p>';
            }

            $('#product-list').html(html);
        },

        error: function(xhr) {
            console.error(xhr);
            $('#product-list').html('<p style="color:red;">Error loading products</p>');
        }
    });
}


$(document).on('click', '.chip', function(e) {
    e.preventDefault();

    $('.chip').removeClass('active');
    $(this).addClass('active');

    let id = $(this).data('id');

    // update URL
    window.history.pushState({}, '', '?id=' + id);

    loadProducts(id);
});


// ✅ LOAD ON PAGE REFRESH (IMPORTANT FIX)
$(document).ready(function () {

    let urlParams = new URLSearchParams(window.location.search);
    let id = urlParams.get('id') || 'all';

    $('.chip').removeClass('active');
    $('.chip[data-id="' + id + '"]').addClass('active');

    loadProducts(id);
});



// load subcategories
if (id !== 'all') {

    $.ajax({
        url: "<?= base_url('index.php/api_handler/get_subcategories_by_category') ?>",
        type: "POST",
        data: { category_id: id },

        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            let options = '<option value="all">All</option>';

            if (response.status && response.data.length > 0) {

                response.data.forEach(function(sub) {
                    options += `<option value="${sub.id}">
                        ${sub.sub_category_name}
                    </option>`;
                });

            }

            $('#subcategory-dropdown').html(options);
        }
    });

} else {
    // reset dropdown
    $('#subcategory-dropdown').html('<option value="all">All</option>');
}
</script>

-->


<script>

function loadProducts(id = 'all') {

    $('#product-list').html('<p>Loading...</p>');

    $.ajax({
        url: "<?= base_url('index.php/api_handler/products_by_category') ?>",
        type: "POST",
        data: { category_id: id },

        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;
            let html = '';

            if (response.status && response.data.length > 0) {

                response.data.forEach(function(product) {

                    let image = "<?= base_url('assets/no-image.png') ?>";

                    if (product.media && product.media.length > 0) {
                        image = "<?= base_url() ?>" + product.media[0].media_path;
                    }

                    html += `
                    <div class="col-md-6 col-xl-4">
                        <div class="product-card">

                            <div class="product-thumb d-flex flex-column justify-content-between">

                                <div class="product-photo">
                                    <img src="${image}" alt="${product.product_name}">
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span class="product-pill">${product.badge ?? ''}</span>
                                    <span class="product-pill">⭐ ${product.rating ?? ''}</span>
                                </div>

                                <div>
                                    <div class="text-white-50 small">
                                        ${product.category_name ?? ''}
                                    </div>
                                    <h3 class="h5 mt-1 mb-0">
                                        ${product.product_name ?? ''}
                                    </h3>
                                </div>

                            </div>

                            <div class="p-3">
                                <!--
                                <div class="p-3 d-flex justify-content-between">
                                    <div>
                                        ₹${product.price ?? 0}
                                        <span class="price-old">${product.strike_price ?? ''}</span>
                                    </div>
                                    <a href="<?= site_url('frontend/product/') ?>${product.id}" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </div>
                                -->
                                <a href="<?= site_url('frontend/contact'); ?>" class="btn btn-sm btn-primary w-100">
                                    Enquire Now
                                </a>
                            </div>

                        </div>
                    </div>`;
                });

            } else {
                html = '<p>No products found</p>';
            }

            $('#product-list').html(html);
        }
    });
}


// ✅ NEW FUNCTION (IMPORTANT)
/*function loadSubcategories(id) {

    if (id === 'all') {
        $('#subcategory-dropdown').html('<option value="all">All</option>');
        return;
    }

    $.ajax({
        url: "<?= base_url('index.php/api_handler/get_subcategories_by_category') ?>",
        type: "POST",
        data: { category_id: id },

        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            let options = '<option value="all">All</option>';

            if (response.status && response.data.length > 0) {

                response.data.forEach(function(sub) {
                    options += `<option value="${sub.id}">
                        ${sub.sub_category_name}
                    </option>`;
                });

            }

            $('#subcategory-dropdown').html(options);
        }
    });
}*/


function loadSubcategories(id) {

    if (id === 'all') {
        $('#subcategory-card').hide(); // ✅ hide
        $('#subcategory-dropdown').html('<option value="all">All</option>');
        return;
    }

    $('#subcategory-card').show(); // ✅ show

    $.ajax({
        url: "<?= base_url('index.php/api_handler/get_subcategories_by_category') ?>",
        type: "POST",
        data: { category_id: id },
        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            let options = '<option value="all">All</option>';

            if (response.status && response.data.length > 0) {
                response.data.forEach(function(sub) {
                    options += `<option value="${sub.id}">${sub.sub_category_name}</option>`;
                });
            }

            $('#subcategory-dropdown').html(options);
        }
    });
}

// ✅ CLICK CATEGORY
$(document).on('click', '.chip', function(e) {
    e.preventDefault();

    $('.chip').removeClass('active');
    $(this).addClass('active');

    let id = $(this).data('id');

    window.history.pushState({}, '', '?id=' + id);

    loadProducts(id);
    loadSubcategories(id); // ✅ IMPORTANT
});


// ✅ PAGE LOAD
$(document).ready(function () {

    let urlParams = new URLSearchParams(window.location.search);
    let id = urlParams.get('id') || 'all';

    $('.chip').removeClass('active');
    $('.chip[data-id="' + id + '"]').addClass('active');

    loadProducts(id);
    loadSubcategories(id); // ✅ IMPORTANT
});

</script>
