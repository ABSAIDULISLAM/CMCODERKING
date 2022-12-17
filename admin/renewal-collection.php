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

$id = $_GET['collection'];
     $rquery = Instalment::renewalCollectionInfoById($id);
    $rResult = mysqli_fetch_assoc($rquery);
      //for overview table info
    $cusotmerId = $rResult['id'];
    $query = Instalment::renewalInfoByIdForOverview($cusotmerId);
//     $overViewInfo = mysqli_fetch_assoc($query);



if(isset($_POST['btn'])){
      $message = Instalment::saveandUpdateRenewalCollection($_POST);
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

<div class="container-fluid">
      <div class="row">
      <h2 class="text-center my-4">Renewal Information</h2>
            <div class="col-md-6 mt-3" >
                        <form action="" method="POST">
                        <div class="form-group">
                              <div class="card">
                                    <div class="card-title text-center">Renewal Collection</div>
                                    <div class="card-body">
                                          <div class="form-group my-2">
                                                <label for="" >Customer Name</label>
                                                <div>
                                                <select readonly name="renewal_customer_name" class="form-select mt-2" id="modal_customer_name">
                                                      <option value="<?php echo $rResult['id'];?>"><?php echo $rResult['name']?></option>
                                                </select>
                                                </div>
                                                </div>
                                                <div class="form-group row">
                                                <div class="col-md-6">
                                                      <div class="form-group my-2">
                                                            <label for="" >Reneal Type</label>
                                                            <select disabled name="renewal_type" class="form-select mt-2">    
                                                                  <option value="<?php echo $rResult['renewal_type'] ?>"><?php echo $rResult['renewal_type']==1 ? "Yearly": "Monthly" ?></option>
                                                            </select>
                                                      </div>
                                                </div>
                                                <?php 
                                                $aquery = mysqli_query(Database::dbConnect(), "SELECT * FROM renewal_tbl WHERE id = '$id'");
                                                $aresult = mysqli_fetch_assoc($aquery);
                                                $payamount = $aresult['renewal_collection'];
                                                $renewalAmount = $aresult['renewal_amount'];
                                                $collectableamount = $renewalAmount-$payamount;
                                                ?>
                                                <div class="col-md-6">
                                                      <div class="form-group my-2">
                                                            <label for="">Collectable Amount</label>
                                                            <input readonly type="number" name="collectable_amount" value="<?php echo $collectableamount?>" class="form-control mt-2">
                                                            <input type="hidden" name="renewal_id" value="<?php echo $id ?>" class="form-control mt-2">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group my-2">
                                                            <label for="">Receive Amount</label>
                                                            <input type="number" name="receive_amount" class="form-control mt-2">
                                                      </div>
                                                </div>
                                                <div class="col-md-6">
                                                      <div class="form-group my-2">
                                                            <?php $date = date("Y-m-d") ?>
                                                            <label for="" >Reneal Date</label>
                                                            <div>
                                                                  <input type="date" name="renewal_receive_date" class="form-control mt-2" value="<?php echo $date; ?>"> 
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="col-md-12">
                                                      <div class="form-group my-2">
                                                            <label for="" >Receive Description</label>
                                                            <div>
                                                                  <textarea name="renewal_rec_description" class="form-control my-2" id="" cols="5" rows="3"></textarea>
                                                            </div>
                                                            
                                                      </div>
                                                </div>
                                                <div class="col-md-6 mt-4">
                                                      <div class="form-group my-2">
                                                      <a href="manage-renewal.php" class="btn btn-outline">Go Back</a>                                                      </div>
                                                </div>
                                                <div class="col-md-6 mt-4 text-end">
                                                      <div class="form-group my-2">
                                                            <button type="submit" class="btn btn-primary" name="btn" >Collect Renewal</button>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        
                  </form>
            </div>

            <div class="col-md-6 mt-3">
                  <div class="card">
                        <div class="card-title text-center">Renewal Overview</div>
                        <div class="card-body">
                              <table class="table table-bordered table-hover">
                                    <thead id="table-header">
                                          <tr>
                                                <td>Sl No.</td>
                                                <td>Renewal<br>type</td>
                                                <td>Last pay</br> Date</td>
                                                <td>Renewal<br>Status</td>
                                          </tr>
                                    </thead>
                                    <tbody>
                                    
                                          <?php
                                          $i = 1;
                                          while($overViewInfo = mysqli_fetch_assoc($query)){ ?>
                                          <tr>

                                                <td><?php echo $i++?></td>
                                                <td><?php echo $overViewInfo['renewal_type']==1 ? "Yearly" : "Monthly" ?></td>
                                                <td><?php echo $overViewInfo['renewal_date']?></td>

                                                <td><b><?php echo $overViewInfo['status']==1 ? "Paid" : "Unpaid" ?></b></td>
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

