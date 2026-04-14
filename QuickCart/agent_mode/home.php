<div class="container my-4">
    <?php viewDeliveringOrders($agent_id); ?>
</div>

<?php
if (isset ($_GET['takeToHome'])) {
    include ('takeToHome.php');
}
if (isset ($_GET['takeToOffline'])) {
    include ('takeToOffline.php');
}
?>
