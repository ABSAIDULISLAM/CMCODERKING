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

if(isset($_POST['modalSubmit'])){
      Instalment::addrenewal($_POST);
}

// if(isset($_GET['delete'])){
//       $id = $_GET['id'];
//       Customer::renewDelete($id);
// }

if(isset($_POST['btn'])){
      Instalment::renewCollection($_POST);
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
                              Add Renewal
                        </button>
                        </div>
                  </div>
            </div>
      </div>
</form>

<?php
   
      $query = mysqli_query(Database::dbConnect(), "SELECT * FROM renewal_tbl ORDER BY id DESC");

?>
<table class="table table-bordered table-hover">
      <thead class ="bg-secondary text-white">
            <tr>
                  <th>Sl No.</th>
                  <th>id</th>
                  <th>Renewal<br>type</th>
                  <th>Reneal<br>amount</th>
                  <th>Renewal<br>date</th>
                  <th>Received<br>Renewal </th>
                  <th>Renewal<br>receive date</th>
                  <th>status</th>
                  <th>Action</th>
            </tr>
      </thead>
      <tbody id="instalmenttable">

      <?php
      $i = 1;
      
       while($row = mysqli_fetch_assoc($query)){ ?>
            
            <tr>
                  <td><?php echo  $i++ ?></td>
                  <td><?php echo $row['id'] ?></td>
                  <td><?php echo $row['renewal_type']==1 ? "Yearly" : "Monthly" ?></td>
                  <td><?php echo $row['renewal_amount'] ?></td>
                  <td><?php echo $row['renewal_date'] ?></td>
                  <td><?php echo $row['renewal_collection'] ?></td> 
                  <td><?php echo $row['pay_date'] ?></td> 
                  <td><b><?php echo $row['status']==1 ? "Paid" : "Unpaid" ?></b></td> 
                  
            </tr>
            <?php }?>
            
      </tbody>
</table>

<script>
      $(document).ready(function(){
            $("#customer_name").on("change", function(){
                  var cusIdr = $("#customer_name").val();
                  $.ajax({
                        method: "POST",
                        url: "admin-ajax.php",
                        data: {cusIdr: cusIdr },
                        datatype: "html",
                        success: function(data){
                              $("#instalmenttable").html(data);
                        }
                  });

                  $("#modal_customer_name").val(cusIdr);
            });


      });
</script>

<!-- modal for add/save Renewal Info  -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Renewal Save</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
                                          <label for="" >Reneal Type</label>
                                          <select name="renewal_type" class="form-select mt-2">
                                                <option value="1">Yearly</option>
                                                <option value="2">Monthly</option>
                                          </select>
                                    </div>
                                    <div class="form-group my-2">
                                          <label for="">Renewal Amount</label>
                                          <input type="number" name="renewal_amount" class="form-control mt-2">
                                    </div>
                                    <div class="form-group my-2">
                                          <?php $date = date("Y-m-d") ?>
                                          <label for="">Reneal Date</label>
                                          <div>
                                                <input type="date" name="renewal_date" class="form-control mt-2" value="<?php echo $date; ?>"> 
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <button type="submit" class="btn btn-primary" name="modalSubmit" >Save Renewal</button>
            </form>
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

  <?php include('include/admin-footer.php');?>








