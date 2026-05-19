<?php $this->load->view('frontend/partials/header'); ?>

<form id="registerForm">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="surface-card p-4">
                <div class="section-kicker">Create account</div>
            <h1 class="section-title">Register for faster repeat ordering</h1>
            <div class="row g-3">
                <div class="col-md-6"><input class="form-control" name="firstname" placeholder="First name" required></div>
                <div class="col-md-6"><input class="form-control" name="lastname" placeholder="Last name" required></div>
                <div class="col-md-6"><input class="form-control" name="dob" placeholder="Date of Birth" type="date" required></div>
                <div class="col-md-6">
                    <select class="form-control" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-12"><input class="form-control" name="phone_no" placeholder="Phone number" required></div>
                <div class="col-12"><input class="form-control" name="email" placeholder="Email" required></div>
                <div class="col-12"><input class="form-control" name="password" placeholder="Password" type="password" required></div>
                <div class="col-12"><textarea class="form-control" name="address" placeholder="Address" required></textarea></div>
                <div class="col-md-6"><input class="form-control" name="city" placeholder="City" required></div>
             <!--   <div class="col-md-6"><input class="form-control" name="state" placeholder="State" required></div>-->
                <div class="col-md-6">
                <select class="form-control" name="state" required>
                <option value="">Select State</option>

                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>

                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Ladakh">Ladakh</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Puducherry">Puducherry</option>
            </select>
        </div>
                <div class="col-md-6"><input class="form-control" name="country" placeholder="Country" required></div>
                <div class="col-md-6"><input class="form-control" name="pincode" placeholder="Pincode" required></div>



            </div>
            <button class="btn btn-primary w-100 mt-3">Create Account</button>
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
    $('#registerForm').submit(function(e){
        e.preventDefault(); // Prevent default form submission
$.ajax({
    url : "<?=base_url('index.php/Api_handler/register')?>",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json", // ✅ important

    success: function(res){

        console.log(res); // 🔍 debug

        if(res.status){   // ✅ BEST CONDITION
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: res.message
            }).then(() => {
                window.location.href = "<?=base_url('index.php/frontend/login')?>";
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: res.message
            });
        }
    }
});
});

 });


</script>