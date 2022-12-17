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
// ---login---

$message="";
use App\Classes\Database;
use App\Classes\Customer;
use App\Classes\Instalment;

//getCollectionInfoByID for show
$id = $_GET['collection'];
$query = Instalment::getCollectionInfoByID($id);
     $queryResult = mysqli_fetch_assoc($query);
     //for overView 
    $customer_id = $queryResult['id'];
   $overviewquery = Instalment::instalmentForOverViewById($customer_id);

if(isset($_POST['btn'])){
      Instalment::saveAndCollectinstalmentCollection($_POST);
}

?>

<?php include('include/admin-main-dashboard.php');?>


<main id="main" class="main">

<style>
        #table-header{
            background-color: #E6E4EA;
            color: black;
            font-weight: 300;
            padding: 20px;
      }
</style>

<script src="../assets/js/adcustomer.js"></script>
<script src="../assets/js/jquery.js"></script>

<div class="row">
      <h2 class="text-center">Instalment Information</h2>
      <div class="col-md-6">
      <form action="" method="post">
            <div class="col-md m-auto mt-4">
                  <div class="card">
                        <div class="card-title text-center">Instalment Collection</div>                        <div class="card-body">
                              <div class="form-group row">
                                    <div class="col-md-12 m-auto my-2">
                                          <label for="">Customer Name</label>
                                          <select name="customer_id" id="" class="form-select">
                                                <option value="<?php echo $queryResult['id']?>"><?php echo $queryResult['name']?></option>
                                          </select>
                                    </div>
                                    <div class="col-md-6 m-auto my-2">
                                          <label for="">Instalment Number</label>
                                          <input disabled type="text" name="instalment_number" class="form-control mt-3" value="<?php echo $queryResult['instalment_number'] ?>">
                                          <input type="hidden" name="maintanance_id" class="form-control mt-3" value="<?php echo $id; ?>">
                                    </div>
                                    <?php 
                                    $aquery = mysqli_query(Database::dbConnect(), "SELECT * FROM maintanance WHERE id = '$id'");
                                     $aresult = mysqli_fetch_assoc($aquery);
                                     $payamount = $aresult['pay_amount'];
                                     $insamount = $aresult['instalment_amount'];
                                     $collectableamount = $insamount-$payamount;
                                    ?>
                                    <div class="col-md-6 m-auto my-2">
                                          <label for="">Collectable Amount</label>
                                          <input readonly type="text" name="collectable_amount" value="<?php echo $collectableamount ?>" class="form-control mt-3" value="<?php echo $queryResult['instalment_amount'] ?>">
                                    </div>

                                    <div class="col-md-6 m-auto my-2">
                                          <label for="">Receive Amount</label>
                                          <input type="number" required name="received_amount" class="form-control mt-3">
                                    </div> 
                                    <?php $date = date("Y-m-d");  ?>
                                    <div class="col-md-6 m-auto my-2">
                                          <label for="">Receive Date</label>
                                          <input type="date" name="receive_date" class="form-control mt-3" value="<?php echo $date; ?>">
                                    </div>
                                    <div class="col-md-12 m-auto my-2">
                                          <label for="">Receive Description</label>
                                          <textarea required type="text" class="form-control mt-3" name="receive_description" id="" cols="10" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6 my-3 ">
                                          <a href="manage-instalment.php" class="btn btn-outline">Go Back</a>
                                    </div>
                                    <div class="col-md-6 my-3 text-end">
                                          <button class="btn btn-primary mt-3" name="btn">Collect Instalment</button>
                                    </div>

                              </div>
                        </div> 
                  </div>
            </div>           
      </form>
      </div>

      <div class="col-md-6 mt-4">
            <div class="card">
                  <div class="card-title text-center">Instalment Overview</div>
                  <div class="card-body">
                        <table class="table table-bordered table-hover">
                              <thead id="table-header">
                                    <tr>
                                          <td>Sl No.</td>
                                          <td>Instalment<br>No.</td>
                                          <td>Instalment</br>amount</td>
                                          <td>Instalment</br>last date</td>
                                          <td>Instalment<br>Status</td>
                                    </tr>
                              </thead>
                              <tbody>
                                    
                                          <?php
                                          $i = 1;
                                          while($overviewqueryresul = mysqli_fetch_assoc($overviewquery)){ ?>
                                    <tr>

                                          <td><?php echo $i++?></td>
                                          <td><?php echo $overviewqueryresul['instalment_number']?></td>
                                          <td><?php echo $overviewqueryresul['instalment_amount']?></td>
                                          <td><?php echo $overviewqueryresul['instalment_date']?></td>

                                          <td><b><?php echo $overviewqueryresul['status']==1 ? "Paid" : "Unpaid" ?></b></td>
                                    </tr>
                                    <?php } ?>
                              </tbody>    
                        </table>
                  </div>
            </div>
      </div>
</div>

</main><!-- End #main -->

<?php include('include/admin-footer.php');?>

