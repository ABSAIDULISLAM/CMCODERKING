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
// ---login---


use App\Classes\Database;
use App\Classes\Useroverview;

$id = $_SESSION['customer_id'];
$queryForIns = Useroverview::showUserInstalmentInfoForinstalmentDEtails($id);
$queryForPay = Useroverview::showUserInstalmentInfoForPaymentDetails($id);
//  $instalInfo = mysqli_fetch_assoc($query);
//  echo '<pre>';
//  print_r($instalInfo);
//  exit();


?>

<?php include('include/user-main-dashboard.php');?>

<main id="main" class="main">

<div class="table-responsive">
      <h2 class="text-center my-3">Instalment Details</h2>
<table class="table table-bordered table-hover">
      <thead class ="bg-primary text-white">
            <tr>
                  <th>Sl No.</th>
                  <th>Instalment Number</th>
                  <th>instalment amount</th>
                  <th>instalment date</th>
            </tr>
      </thead>

      <tbody>
      <?php
      $i = 1;
      $status;
      $color;
       while($instalInfo = mysqli_fetch_assoc($queryForIns)){ ?>

            <tr>
                  <td><?php echo $i++ ?></td>
                  <td><?php echo $instalInfo['instalment_number'] ?></td>
                  <td><?php echo $instalInfo['instalment_amount'] ?></td>
                  <td><?php echo $instalInfo['instalment_date'] ?></td>  
            </tr>

            <?php }?>
       </tbody>
      </table>

</div>



<h2 class="text-center mt-5">Payment Details</h2>
<table class="table table-bordered table-hover">
      <thead class ="bg-secondary text-white">
            <tr>
                  <th>Sl No.</th>
                  <th>Payment amount </th>
                  <th>Payment date</th>
                  <th>Paymen status</th>
            </tr>
      </thead>

      <tbody>
      <?php
      $i = 1;
      $status;
      $color;
       while($instal = mysqli_fetch_assoc($queryForPay)){ ?>

            <tr>
                  <td><?php echo $i++ ?></td>
                  <td><?php echo $instal['pay_amount'] ?></td> 
                  <td><?php echo $instal['pay_date'] ?></td> 
                  <td><b><?php echo $instal['status']==1 ? "Paid" : "Due" ?></b></td>
                  
            </tr>

            <?php }?>
       </tbody>
      </table>



</main><!-- End #main -->

<?php include('include/user-footer.php');?>








