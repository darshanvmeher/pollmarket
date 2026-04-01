<?php $this->load->view('frontend/partials/header'); ?>

<form id="loginForm" autocomplete="off">

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="surface-card p-4">
            <div class="section-kicker">Welcome back</div>
            <h1 class="section-title">Sign in to your Poll Market Solutions account</h1>
            <div class="mb-3"><input class="form-control" name="email" placeholder="Email"></div>
            <div class="mb-3"><input class="form-control" name="password" type="password" placeholder="Password"></div>
            <button class="btn btn-primary w-100">Login</button>
            <div class="text-center mt-3">
                <a href="<?php echo site_url('frontend/register'); ?>">Create an account</a>
            </div>
        </div>
    </div>
</div>
</form>

<?php $this->load->view('frontend/partials/footer'); ?>

<!-- ✅ jQuery (if not already included in header) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--Ajax-->
<script>
 $(document).ready(function() {
    $('#loginForm').submit(function(e){
        e.preventDefault(); // Prevent default form submission
$.ajax({
    url : "<?=base_url('index.php/Api_handler/customer_login')?>",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json", // ✅ important

    success: function(res){

        console.log(res); // 🔍 debug

        if(res.status){   // ✅ BEST CONDITION
                    
        localStorage.setItem("token", res.token);

            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: res.message
            }).then(() => {
                window.location.href = "<?=base_url('index.php/frontend/')?>";
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: res.message
            });
        }
    }
});
});

 });

    

</script>