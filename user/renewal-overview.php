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
$renewalqueryFordetails = Useroverview::renewalInfoForrenewalDEtails($id);
$renewalqueryForPay = Useroverview::renewalInfoForPaymentDetails($id);
//  $instalInfo = mysqli_fetch_assoc($query);
//  echo '<pre>';
//  print_r($instalInfo);
//  exit();


?>


<?php include('include/user-main-dashboard.php');?>

<main id="main" class="main">

<div class="table-responsive">
      <h2 class="text-center my-3">Renewal Details</h2>
<table class="table table-bordered table-hover">
      <thead class ="bg-primary text-white">
            <tr>
                  <th>Sl No.</th>
                  <th>Renewal Type</th>
                  <th>Renewal amount</th>
                  <th>Renewal date</th>
            </tr>
      </thead>

      <tbody>
      <?php
      $i = 1;
      $status;
      $color;
       while($instalInfo = mysqli_fetch_assoc($renewalqueryFordetails)){ ?>

            <tr>
                  <td><?php echo $i++ ?></td>
                  <td><?php echo $instalInfo['renewal_type']==1 ? "Yearly" : "Monthly" ?></td>
                  <td><?php echo $instalInfo['renewal_amount'] ?></td>
                  <td><?php echo $instalInfo['renewal_date'] ?></td>  
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
                  <th>Payment renewal</th>
                  <th>Payment date</th>
                  <th>Payment status</th>
            </tr>
      </thead>

      <tbody>
      <?php
      $i = 1;
      $status;
      $color;
       while($instal = mysqli_fetch_assoc($renewalqueryForPay)){ ?>

            <tr>
                  <td><?php echo $i++ ?></td>
                  <td><?php echo $instal['renewal_collection'] ?></td> 
                  <td><?php echo $instal['pay_date'] ?></td> 
                  <td><b><?php echo $instal['status']==1 ? "Paid" : "Due" ?></b></td>
                  
            </tr>

            <?php }?>
       </tbody>
      </table>



</main><!-- End #main -->

<?php include('include/user-footer.php');?>


