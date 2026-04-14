<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 text-center">
            <div class="alert py-4" role="alert"
                style="background:#FFE6CD;border:1px solid #FFE6CD;color:#1A1A1A;border-radius:14px;">
                <i class="fas fa-moon fa-2x mb-3" style="color:#1A1A1A;"></i>
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
