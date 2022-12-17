<?php
session_start();
if(isset($_SESSION['admin_id'])==null){
      header('Location: ../login.php');
}

require_once('../vendor/autoload.php');
use App\Classes\Login;
if(isset($_GET['adminlogout'])){
      Login::adminLogout();
}

?>

<?php include('include/admin-main-dashboard.php');?>

<main id="main" class="main">

<?php include('include/admin-body.php');?>
    
</main><!-- End #main -->

<?php include('include/admin-footer.php');?>