<?php
session_start();
if(isset($_SESSION['user_id'])==null){
      header('Location: ../login.php');
}


require_once('../vendor/autoload.php');
use App\Classes\Login;
if(isset($_GET['userlogout'])){
      Login::userLogout();
}




?>


<?php include('include/user-main-dashboard.php');?>

<main id="main" class="main">

<?php include('include/user-body.php');?>
    

</main><!-- End #main -->

<?php include('include/user-footer.php');?>