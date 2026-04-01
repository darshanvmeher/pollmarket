<?php $this->load->view('frontend/partials/header'); ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="surface-card p-4">
            <div class="section-kicker">Create account</div>
            <h1 class="section-title">Register for faster repeat ordering</h1>
            <div class="row g-3">
                <div class="col-md-6"><input class="form-control" placeholder="First name"></div>
                <div class="col-md-6"><input class="form-control" placeholder="Last name"></div>
                <div class="col-12"><input class="form-control" placeholder="Email"></div>
                <div class="col-12"><input class="form-control" placeholder="Password" type="password"></div>
            </div>
            <button class="btn btn-primary w-100 mt-3">Create Account</button>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
