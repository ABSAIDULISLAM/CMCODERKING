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
use App\Classes\Instalment;

$id = $_GET['edit'];

$reneawalEditInfo = Instalment::renewalEdit($id);


if(isset($_POST['modaledit'])){

      Instalment::updateRenewal($_POST);
}
?>

<?php include('include/admin-main-dashboard.php');?>

<main id="main" class="main">

<form action="" method="POST">
            <div class="form-group">
                  <div class="card">
                        <div class="card-body">
                        <div class="form-group my-2">
                                    <label for="" >Customer Name</label>
                                    <div>
                                    <select name="modal_customer_name" class="form-select mt-2" id="modal_customer_name" value="<?php echo $reneawalEditInfo['customer_id'] ?>">
                                          <option value="<?php echo $reneawalEditInfo['id'] ?>"><?php echo $reneawalEditInfo['name'] ?></option>
                                    </select>
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <label for="" >Reneal Type</label>
                                    <select name="renewal_type" class="form-select mt-2" value="<?php echo $reneawalEditInfo['renewal_type'] ?>">
                                          <option value="1">Yearly</option>
                                          <option value="2">Monthly</option>

                                    </select>
                              </div>
                              <div class="form-group my-2">
                                    <label for="">Renewal Amount</label>
                                    <input type="number" name="renewal_amount" class="form-control mt-2" value="<?php echo $reneawalEditInfo['renewal_amount'] ?>">
                                    <input type="hidden" value="<?php echo $reneawalEditInfo['id'] ?>" Required name="reId" class="form-control mt-2"> 
                              </div>
                              <div class="form-group my-2">
                                    <?php $date = date("Y-m-d") ?>
                                    <label for="" >Reneal Date</label>
                                    <div>
                                          <input type="date" name="renewal_date" class="form-control mt-2" value="<?php echo $date; ?>"  value="<?php echo $reneawalEditInfo['renewal_amount'] ?>"> 
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <button type="submit" class="btn btn-primary" name="modaledit" >Update Renewal</button>
        </form>
      </div>

</main><!-- End #main -->

  <?php include('include/admin-footer.php');?>








