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

<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/back-end/assets/img/favicon.png" rel="icon">
  <link href="../assets/back-end/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/back-end/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/back-end/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <script src="../assets/back-end/assets/js/jquery.js"></script>

  <!-- Template Main CSS File -->
  <link href="../assets/back-end/assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/fontawesome.min.css" rel="stylesheet">
  <script src="../assets/js/jquery.js"></script>
  <script src="../assets/js/addcustomer.js"></script>

<div class="container">

<table>
<div class="row">
            <div class="col-md-12">
                  <div class="panel panel-default">
                        <div class="panel-body">
                              <div class="panel-heading">
                                    <h3 class="text-center">Coder King It Solution</h3>
                                    <p class="text-center">Rupatali, Barishal</p>
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
                  <!-- <th>Payid amount</th> -->
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
                        <td><?php echo $cusInstalShedule['status']==0 ? "Due" : "Paid" ?></td>
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
                        <td><?php echo $cusrenew['status'] ?></td>
                        <td><?php echo $cusrenew['next_date'] ?></td>
                  </tr>
                  <?php } ?>
            </tbody>
      </table>
      
      <br>

</table>

<p class="text-center"> Thanks for Connect With Us</p>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}

      window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});
</script>

<script src="../assets/js/fontawesome.js"></script>

  <!-- Vendor JS Files -->
  <script src="../assets/back-end/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/back-end/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/back-end/assets/vendor/chart.js/chart.min.js"></script>
  <script src="../assets/back-end/assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/back-end/assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/back-end/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/back-end/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/back-end/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/back-end/assets/js/main.js"></script>
  <script src="../assets/back-end/assets/js/addcustomer.js"></script>
