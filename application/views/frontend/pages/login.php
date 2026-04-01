<?php $this->load->view('frontend/partials/header'); ?>

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="surface-card p-4">
            <div class="section-kicker">Welcome back</div>
            <h1 class="section-title">Sign in to your Poll Market Solutions account</h1>
            <div class="mb-3"><input class="form-control" placeholder="Email"></div>
            <div class="mb-3"><input class="form-control" type="password" placeholder="Password"></div>
            <button class="btn btn-primary w-100">Login</button>
            <div class="text-center mt-3">
                <a href="<?php echo site_url('frontend/register'); ?>">Create an account</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
