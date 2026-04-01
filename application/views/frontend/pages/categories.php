<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">Categories</div>
    <h1 class="section-title">All shopping categories in one visual grid</h1>
</div>

<div class="row g-3">
    <?php foreach (array('Plastic Garbage Bags','Stationery Materials','Silver Foil Papers','RFID Seals','Paper Bags','Office Kits') as $category): ?>
        <div class="col-6 col-lg-4">
            <div class="collection-card">
                <div class="fw-bold"><?php echo html_escape($category); ?></div>
                <div class="text-muted small">Explore products and bulk pricing</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
