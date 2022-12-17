<?php
session_start();
include 'connect.php';
if(isset($_SESSION['admin_id'])==null){
      header('Location: ../login.php');
}

require_once('../vendor/autoload.php');
use App\Classes\Login;
if(isset($_GET['adminlogout'])){
      Login::adminLogout();
}
// ---login---


$message="";
use App\Classes\Customer;
use App\Classes\Database;
$id = $_GET['view'];

if(isset($_GET['view'])){
      //customer info
      $customerInfo = Customer::viewCustomerInfo($id);

}

?>

<?php include('include/admin-main-dashboard.php');?>
<main id="main" class="main">

<div class="text-end">
<a href="print.php?view=<?php echo $customerInfo['id'] ?>" target="_blank" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-print"></span> Print</a>
</div>


<table>
<div class="row">
            <div class="col-md-12">
                  <div class="panel panel-default">
                        <div class="panel-body">
                              <div class="panel-heading">
                                    <h3 class="text-center my-3">Customer Personal information</h3>
                              </div>
                              <table class="table table-bordered table-hover" id="">
                                    <tr>
                                          <td>Customer Name</td>
                                          <td><?php echo $customerInfo['name'] ?> </td>
                                    </tr>
                                    <tr>
                                          <td>Customer Email </td>
                                          <td><?php echo $customerInfo['email'] ?></td>
                                    </tr>
                                    <tr>
                                          <td>Customer Contact Number </td>
                                          <td><?php echo $customerInfo['mobile'] ?></td>
                                    </tr>
                                    <tr>
                                          <td>Customer Address</td>
                                          <td><?php echo $customerInfo['village' ]. ", " .$customerInfo['union_name' ] . ", ". $customerInfo['thana_name' ] . ", " .$customerInfo['district_name'] ?></td>
                                    </tr>
                              </table>
                        </div>
                  </div> 
            </div>
      </div>
      <br>
      <?php
            $sql =" SELECT * FROM product_details WHERE customer_id = '$id'";
            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
            $productDetails = mysqli_fetch_assoc($queryResult);
      ?>
      <div class="row">
            <div class="col-md-12">
                  <div class="panel panel-default">
                        <div class="panel-body">
                              <div class="panel-heading">
                                    <h3 class="text-center">Product Details</h3>
                              </div>
                              <table class="table table-bordered table-hover">
                                    <tr>
                                          <td><b>Product Description</b></td>
                                          <td colspan="5"><?php echo $productDetails['product_description']?></td>
                                    </tr>
                                    <tr>
                                          <td><b>Product Price</b></td>
                                          <td><?php echo $productDetails['total_price']?></td>
                                          <td><b>Initial instalment</b></td>
                                          <td><?php echo $productDetails['initit_instal']?></td>
                                          <td><b>Product Deadline</b></td>
                                          <td><?php echo $productDetails['deadline']?></td>
                                    </tr>
                              </table>
                        </div>
                  </div> 
            </div>
      </div>
      <br>
      <?php
            $sql = "SELECT * FROM maintanance WHERE customer_id = '$id'";
            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));     
      ?>
      <h3 class="text-center">Instalment Shedule</h3>
      <table class="table table-bordered table-hover">
            <thead class="bg-secondary text-light">
                  <th>Sl no.</th>
                  <th>Instalment no</th>
                  <th>Instalment amount</th>
                  <th>Instalment date</th>
                  <th>Pay Date </th>
                  <th>Pay Amount</th>
                  <th>Status</th>
            </thead>
            <tbody>
                  <?php 
                   $i =1;
                  while($cusInstalShedule = mysqli_fetch_assoc($queryResult)) { ?>
                  <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $cusInstalShedule['instalment_number'] ?></td>
                        <td><?php echo $cusInstalShedule['instalment_amount'] ?></td>
                        <td><?php echo $cusInstalShedule['instalment_date'] ?></td>
                        <td><?php echo $cusInstalShedule['pay_date'] ?></td>
                        <td><?php echo $cusInstalShedule['pay_amount'] ?></td>
                        <td><b><?php echo $cusInstalShedule['status']==0 ? "Due" : "Paid" ?></b></td>
                  </tr>
                  <?php } ?>
            </tbody>
      </table>
      <hr>
      <?php 
            $sql= "SELECT * FROM renewal_tbl WHERE customer_id = '$id'";
            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
      ?>
      <br>
      <h3 class="text-center">Renewal / Maintanance</h3>
      <table class="table table-bordered table-hover">
            <thead class="bg-secondary text-light">
                  <tr>
                        <th>Sl no.</th>
                        <th>renewal type</th>
                        <th>renewal amount</th>
                        <th>renewal date</th>
                        <th>Pay Amount</th>
                        <th>pay date</th>
                        <th>Payment status</th>
                        <th>Next Date</th>
                  </tr>
            </thead>
            <tbody>

                  <?php 
                  $i =1;
                  while($cusrenew = mysqli_fetch_assoc($queryResult)){ ?>
                  <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $cusrenew['renewal_type'] ==1 ? 'Yearly' : 'Monthly' ?></td>
                        <td><?php echo $cusrenew['renewal_amount'] ?></td>
                        <td><?php echo $cusrenew['renewal_date'] ?></td>
                        <td><?php echo $cusrenew['pay_date'] ?></td>
                        <td><?php echo $cusrenew['renewal_collection'] ?></td>
                        <td><?php echo $cusrenew['status']==1 ? "Paid" : "Due" ?></td>
                        <td><?php echo $cusrenew['next_date'] ?></td>
                  </tr>
                  <?php } ?>
            </tbody>
      </table>   
      <br>
</table>

      <a href="manage-customer.php" class="btn btn-outline">Go Back</a>
<script type="text/javascript">

</script>

</main><!-- End #main -->

<?php include('include/admin-footer.php');?>

