<?php 
$data['title'] = "Track Order";
$this->load->view('frontend/partials/header'); 
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- ✅ FORM -->
        <form id="trackForm">

            <div class="surface-card p-4">

                <div class="section-kicker">Track Order</div>
                <h1 class="section-title">Check delivery status across India in seconds</h1>

                <div class="input-group mt-3">
                    <input class="form-control" name="order_number" 
                        placeholder="Enter order number (e.g. PM-0032)" required>
                    <button type="submit" class="btn btn-primary">Track</button>
                </div>

                <!-- ✅ RESULT BOX -->
                <div class="mt-4 d-none" id="resultBox">

                    <!-- Order placed -->
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span>Order placed</span>
                        <strong class="text-success">Completed</strong>
                    </div>

                    <!-- Current status -->
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span>Current status</span>
                        <strong class="text-primary current-status"></strong>
                    </div>

                    <!-- Delivered -->
                    <div class="d-flex justify-content-between py-3">
                        <span>Delivered</span>
                        <strong class="delivered-status text-warning">Pending</strong>
                    </div>

                </div>

                <!-- ❌ ERROR MESSAGE -->
                <div class="alert alert-danger mt-3 d-none" id="errorBox">
                    Order not found. Please check your order number.
                </div>

            </div>

        </form>

    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>

<!-- ✅ JQUERY (if not already loaded) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    $("#trackForm").on("submit", function(e) {
        e.preventDefault();

        let order_number = $("input[name='order_number']").val().trim();

        if (!order_number) {
            alert("Please enter order number");
            return;
        }

        // 🔐 Get token
        let token = localStorage.getItem("token");

        if (!token) {
            alert("Please login first");
            return;
        }

        // Reset UI
        $("#resultBox").addClass("d-none");
        $("#errorBox").addClass("d-none");

        fetch("http://localhost/pollmarket/index.php/Api_handler/track_order_api", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token, // ✅ IMPORTANT
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                order_number: order_number
            })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error("Network error");
            }
            return res.json();
        })
        .then(data => {

            if (data.status) {

                $("#resultBox").removeClass("d-none");

                let status = (data.order_status || "").toLowerCase();

                // ✅ Show exact DB value (with first letter capital)
                let displayStatus = data.order_status.charAt(0).toUpperCase() + data.order_status.slice(1);
                $(".current-status").text(displayStatus);

                // Delivered logic
                if (status === "delivered") {
                    $(".delivered-status")
                        .text("Completed")
                        .removeClass("text-warning")
                        .addClass("text-success");
                } else {
                    $(".delivered-status")
                        .text("Pending")
                        .removeClass("text-success")
                        .addClass("text-warning");
                }

            } else {
                $("#errorBox").removeClass("d-none");
            }
        })
        .catch(err => {
            console.error(err);
            $("#errorBox").removeClass("d-none");
        });

    });

});
</script>