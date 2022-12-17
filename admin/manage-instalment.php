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

// for instalment delete
if(isset($_GET['delete'])){
      $id = $_GET['id'];
      $mquery = Customer::instalmentDelete($id);
      $queryresult = mysqli_fetch_assoc($mquery);

}

// for instalment collection
if(isset($_POST['btn'])){
      Instalment::addinstalmentCollection($_POST);
}

?>

<?php include('include/admin-main-dashboard.php');?>

<main id="main" class="main">

<form action="">
      <div class="container-fluid my-3">
            <div class="row">
                  <div class="col-md-6 my-3">
                        
                        <div class="col-md-6">
                              <label for="" >Customer Name</label>
                              <div>
                                    <select name="" class="form-select mt-2" id="customer_name">
                                    <?php
                                          $query = mysqli_query(Database::dbConnect(), "SELECT * FROM personal_info");
                                          
                                    ?>
                                          <option value="">--select---</option>
                                          <?php while($personalInfo = mysqli_fetch_assoc($query)){ ?>
                                          <option value="<?php echo $personalInfo['id'] ?>"><?php echo $personalInfo['id'] ." || ".$personalInfo['name'] ?></option>
                                          <?php } ?>
                                    </select>
                              </div>
                        </div>
                  </div>

                  <div class="col-md-6">
                        <div class=" text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Add Instalment 
                        </button>
                        </div>
                  </div>
            </div>
      </div>
</form>

<?php 
      $query = mysqli_query(Database::dbConnect(), "SELECT * FROM maintanance ORDER BY id DESC");
?>
<div class="table-responsive">
<table class="table table-bordered table-hover">
      <thead class ="bg-secondary text-white">
            <tr>
                  <th>Sl No.</th>
                  <th>Id No.</th>
                  <th>Instalment<br> Number</th>
                  <th>instalment<br>amount</th>
                  <th>instalment<br>date</th>
                  <th>Received <br>amount </th>
                  <th>Received <br>date</th>
                  <th>status</th>
                  <th>Action</th>
            </tr>
      </thead>

      <tbody id="instalmenttable">

      <?php
      $i = 1;
      $status;
      $color;
       while($row = mysqli_fetch_assoc($query)){ ?>

            <tr>
                  <td><?php echo $i++ ?></td>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['instalment_number'] ?></td>
                  <td><?php echo $row['instalment_amount'] ?></td>
                  <td><?php echo $row['instalment_date'] ?></td>
                  <td><?php echo $row['pay_amount'] ?></td> 
                  <td><?php echo $row['pay_date'] ?></td> 
                  <td><b><?php echo $row['status']==1 ? "Paid" : "Due" ?></b></td>
                  
            </tr>

            <?php }?>
            
            </tbody>
      </table>


</div>

<!-- for instalment Collection  modal-->
<div class="col-md-6 text-canter m-auto" id="dialogueBox">
      <div class="card">
            <div class="card-header">
                  <h3>Instalment Collection</h3>
            </div>
            <div class="card-body">

            <form action="" method="POST">
                  <div class="card">
                        <div class="card-body">
                        <?php 
                              $sql = " SELECT * FROM personal_info";
                              $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));                             
                        ?>
                              <div class="row">
                                    <div class="col-md-12">
                                          <div class="from-group my-1">
                                                <label for="" class="my-2">Customer Name </label>
                                                <select name="instalment_cus_name" class="form-select" id="collectInstCustomerName" required>
                                                      <option value="0">--select--</option>
                                                <?php while($customerInfo =  mysqli_fetch_assoc($queryResult)){ ?>
                                                      <option value="<?php echo $customerInfo['id'] ?>"><?php echo $customerInfo['id']. " || " . $customerInfo['name']?></option>
                                                      <?php } ?>
                                                      
                                                </select>   
                                          </div>
                                    </div>                                   
                              </div>
                              <div class="row">
                                    <div class="col-md-6">
                                          <div class="from-group my-2">
                                          <label for="" class="mb-2">Instalment no.</label>
                                          <select name="instalment_number_ID"  class="form-select" id="instalment_number" required>
                                                 <option value="">--Select--</option>
                                          </select>
                                          <!-- <input type="text" class="form-control" value="" > -->
                                          </div>                                    
                                    </div>
                                    <div class="col-md-6">
                                          <div class="from-group my-2">
                                          <label for="" class="mb-2">Collectable Amount</label>
                                          <div class="col">
                                                <input readonly type="text" name="collectable_amount" id="instalment_amount" class="form-control" value="" >
                                          </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-md-6">
                                          <div class="from-group my-2">
                                          <label for="" class="mb-2">Recived Amount</label>
                                          <div class="col">
                                                <input type="number" name="received_amount"  id="" class="form-control" required >
                                          </div>
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                          <div class="from-group my-2">
                                          <?php $date = date("Y-m-d");  ?>
                                          <label for="" class="mb-2">Payment Date</label>
                                          <div class="col">
                                                <input type="date" name="payment_date" id="payment_date" class="form-control" value="<?php echo $date; ?>" required>
                                          </div>
                                    </div>
                                    </div>  
                                    <div class="row">
                                          <div class="">
                                          <label for="" class="mb-2 mt-3">Recived Description</label>
                                                <textarea name="receive_description" id="" class="form-control" cols="10" rows="3"></textarea>
                                          </div>
                                    </div>   
                              </div>
                              <div class="from-group mt-4">
                                    <div class="ibtn text-end">
                                          <button class="btn btn-primary" id="instalmentCollect" name="btn">Save</button>
                                    </div>
                              </div>
                        </div>
                  </div>
            </form>
            <!-- modal button -->
            <a href="#" class="btn btn-success" type="submit" name="submit" value="" id="closeDialogue">Exit</a>

            </div>
      </div>
</div>

<script>
      $(document).ready(function(){
            $("#dialogueBox").hide();

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
                  $("#modal_Edit_customer_name").val(cusId);
                  $("#collectInstCustomerName").val(cusId);
            });

            // for instalment number in instalment collection form
            $("#collectInstCustomerName").on("change", function(){
                  var initId = $("#collectInstCustomerName").val();
                  // var instamountId = $("#instalment_number").val();
                  $.ajax({
                        method: "POST",
                        url: "admin-ajax.php",
                        data:{initId: initId},
                        dataType: "html",
                        success: function(data){
                              $("#instalment_number").html(data);
                        }
                  });
                  // $("#instalment_number").val(initId);
            });

            // for instalment collection collectable amount 
            $("#instalment_number").on("change", function(){
                  var cus_id = $("#collectInstCustomerName").val();
                  var instamountId = $("#instalment_number").val();
                  $.ajax({
                        method: "POST",
                        url: "admin-ajax.php",
                        data:{instamountId: instamountId, customar_id :cus_id},
                        dataType: "html",
                        success: function(data){
                              $("#instalment_amount").val(data);
                        }
                  });
                  $("#instalment_amount").val(instamountId);
            });

            $("#closeDialogue").click(function(){
                  $("#dialogueBox").hide();

            });
           

      });
</script>

<!-- modal for save instalment Info  -->
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Instalment Save</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php 
            if(isset($_POST['modalSubmit'])){

                 $id = $_POST['modal_customer_name'];
                 $initNumber = $_POST['instalment_number'];
                 $initAmount = $_POST['instalment_amount'];
                 $initDate = $_POST['instalment_date'];

                  $sql = "INSERT INTO maintanance (instalment_number, instalment_amount,instalment_date, customer_id, pay_amount) VALUES('$initNumber', '$initAmount', '$initDate', '$id', '0' )";
                  mysqli_query(Database::dbConnect(), $sql) or die("problem".mysqli_error(Database::dbConnect())) ;
            }

            ?>
      <form action="" method="POST">
            <div class="form-group">
                  <div class="card">
                        <div class="card-body">
                              <div class="form-group my-2">
                                    <label for="" >Customer Name</label>
                                    <div>
                                    <select name="modal_customer_name" class="form-select mt-2" id="modal_customer_name">

                                    <?php
                                    $query = mysqli_query(Database::dbConnect(), "SELECT * FROM personal_info");
                                    
                                    ?>
                                          <option value="">--select---</option>
                                          <?php while($personalInfo = mysqli_fetch_assoc($query)){ ?>
                                          <option value="<?php echo $personalInfo['id'] ?>"><?php echo $personalInfo['id'] ." || ".$personalInfo['name'] ?></option>
                                          <?php } ?>
                                    </select>
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <label for="" >Instalment Number</label>
                                    <div>
                                          <input type="number" Required name="instalment_number" class="form-control mt-2"> 
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <label for="">Instalment Amount</label>
                                    <div>
                                          <input type="number" Required class="form-control mt-2" name="instalment_amount"> 
                                    </div>
                              </div>
                              <div class="form-group my-2">
                                    <?php $date = date("Y-m-d") ?>
                                    <label for="" >Instalment Date</label>
                                    <div>
                                          <input type="date" name="instalment_date" class="form-control mt-2" value="<?php echo $date; ?>"> 
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <button type="submit" class="btn btn-primary" name="modalSubmit" >Save Instalment</button>
        </form>
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

<?php include('include/admin-footer.php');?>








