<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 text-center">
            <div class="alert py-4" role="alert"
                style="background:#dce8f3;border:1px solid #ADC3D1;color:#3a4a5c;border-radius:14px;">
                <i class="fas fa-moon fa-2x mb-3" style="color:#8FB1CC;"></i>
                <p class="mb-0 fw-semibold">You are currently Offline. Set your status to Available to start receiving orders.</p>
            </div>
        </div>
    </div>
</div>

<?php
if (isset ($_GET['takeToHome'])) {
    include ('takeToHome.php');
}
if (isset ($_GET['takeToOffline'])) {
    include ('takeToOffline.php');
}
?>
