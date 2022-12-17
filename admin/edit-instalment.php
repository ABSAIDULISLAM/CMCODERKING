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

$id = $_GET['edit'];
$instalmentIfoforedit = Customer::instalmentEdit($id);

if(isset($_POST['modaledit'])){

      Customer::updateInstalment($_POST);
}

if(isset($_GET['delete'])){
     $id = $_GET['id'];
     Customer::instalmentDelete($id);
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
                                    <select name="modal_customer_name" class="form-select mt-2" id="modal_customer_name">
                                          <option value="<?php echo $instalmentIfoforedit['id'] ?>"><?php echo $instalmentIfoforedit['name'] ?></option>
                                    </select>
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <label for="" >Instalment Number</label>
                                    <div>
                                          <input type="number" value="<?php echo $instalmentIfoforedit['instalment_number'] ?>" Required name="instalment_number" class="form-control mt-2"> 
                                          <input type="hidden" value="<?php echo $instalmentIfoforedit['id'] ?>" name="isId" class="form-control mt-2"> 
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <label for="">Instalment Amount</label>
                                    <div>
                                          <input type="number" value="<?php echo $instalmentIfoforedit['instalment_amount'] ?>" Required class="form-control mt-2" name="instalment_amount"> 
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <?php $date = date("Y-m-d") ?>
                                    <label for="" >Instalment Date</label>
                                    <div>
                                          <input type="date" name="instalment_date" value="<?php echo $instalmentIfoforedit['instalment_date'] ?>" class="form-control mt-2" value="<?php echo $date; ?>"> 
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <button type="submit" class="btn btn-primary" name="modaledit" >Save Instalment</button>
        </form>
      </div>

      <script>
            $(document).ready(function(){
            // for customer name diye alada vabe instalment id anar jonno
            $("#customer_name").on("change", function(){
                  var cusId = $("#customer_name").val();
                  $.ajax({
                        method: "POST",
                        url: "admin-ajax.php",
                        data: {cusId: cusId },
                        datatype: "html",
                        success: function(data){
                              $("#instalmenttable").html(data);
                        }
                  });

                  $("#modal_customer_name").val(cusId);
                  $("#collectInstCustomerName").val(cusId);
            });
      });
      </script>
</main><!-- End #main -->

  <?php include('include/admin-footer.php');?>








