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
// ---login----

$message="";
use App\Classes\Customer;
// add customer
if(isset($_POST['btn'])){
     $message = Customer::addCustomer($_POST);
}

// getdivisionInfo for dropdown
 $divisionInfo = Customer::getdivisionInfo();


?>

<script src="../assets/js/adcustomer.js"></script>
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/fontawesome.js"></script>
<script src="../assets/back-end/assets/js/main.js"></script>
<script src="../assets/css/bootstrap.min.css"></script>
<script src="../assets/back-end/vendor/bootstrap/css/bootstrap.main.css"></script>

<?php include('include/admin-main-dashboard.php');?>

<style>
      .personal-info{
            /* background-color: #F3F6FD; */
            padding: 10px;
      }
      .card{
            background-color: #F9F6FD;
            
      }
      .rowone:hover{
            background-color: #ececfd;
            border-radius: 5px;
      }
      .rowtwo:hover{
            background-color: #ececfd;
            border-radius: 5px;
      }
      .rowthree:hover{
            background-color: #ececfd;
            border-radius: 5px;
      }
      .rowfour:hover{
            background-color: #ececfd;
            border-radius: 5px;
      }
      .maintananceTable{
            background-color: #E6E4EA;
            color: black;
            font-weight: 200;
            padding: 20px;
            
      }
      .maintananceTable:hover{
            background-color: #ececfd;
            color: black;
            font-weight: 200;
            
      }
      .maintananceTable th{
            color: black;
            font-weight: 200; 
      }
</style>

<main id="main" class="main">

<div class="container-fluid">
            <form action="" method="post">
                  <div class="card">
                        <h3 class="text-center my-4">Add Customer</h3>
                        <h4 class="text-success ms-4"><?php echo $message; ?></h4>
                        <div class="card-body">
                              <div class="personal-info">
                              <h5>Personal Info </h5>
                                    <div class="row my-2 rowone">
                                          
                                          <div class="col-md-4">
                                                <div class="form-group row mt-3">
                                                      <label for="" class="my-2  mt-1">Name</label>
                                                      <div class="">
                                                            <input type="text" name="name" Required class="form-control ">
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="form-group row mt-3">
                                                      <label for="" class="my-2 mt-1">Mobile</label>
                                                      <div class="">
                                                            <input type="number" Required name="mobile" min="11" max="11" class="form-control ">
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="form-group row my-3">
                                                      <label for="" class="my-2 mt-1">Email</label>
                                                      <div class="">
                                                            <input type="email" Required name="email" class="form-control ">
                                                      </div>
                                                </div>
                                          </div>   
                                    </div>                                    
                                    <div class="row mb- rowtwo">       
                                          <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Division</label>
                                                      <select name="division" id="division"  class="form-select" Required>
                                                            <option value="0">--Select--</option>
                                                            <?php while($division = mysqli_fetch_assoc($divisionInfo)){ ?>
                                                            <option value="<?php echo $division['division_id']?>"><?php echo $division['division_name']?></option>
                                                            <?php }?>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">District</label>
                                                      <select name="district" id="district"  class="form-select" Required>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Upzila</label>
                                                      <select name="upzila" id="upzila"  class="form-select" Required>

                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-2 my-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Union</label>
                                                      <select name="user_union" id="user_union"  class="form-select" Required>

                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Village</label>
                                                      <input type="text" name="village" class="form-control" Required>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <hr>
                              <h5 class="mt-5 ">Product details</h5>
                              <div class="row rowthree">
                              <label for="" class=" my-2">Product description</label>
                                    <div class="col-md-12 ">
                                          <div class="form-group row ">
                                                <div class=" text-start mb-4">
                                                      <textarea name="product_description" Required class="form-control" id="" cols="10" rows="3"></textarea>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="row my-4 rowfour">
                                    <div class="col-md-3 ">
                                          <div class="form-group row">
                                                <label for="" class="  my-2">Product total price</label>
                                                <div class="">
                                                      <input type="number" Required name="total_price" class="form-control">
                                                </div>
                                          </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                          <div class="form-group row">
                                                <label for="" class=" my-2">Initial instalment</label>
                                                <div class="">
                                                      <input type="number" Required name="initit_instal" class="form-control">
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                    <?php $date = date("Y-m-d");  ?>
                                          <div class="form-group row">
                                                <label for="" class=" my-2">Product Deadline</label>
                                                <div class="">
                                                      <input type="date" Required name="deadline" class="form-control" value="<?php echo $date?>">
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <hr>
                              <h5 class="mt-5 mb-2">Instalment Shedule</h5>
                              <div class="container">
                                    <table class="table table-bordered table-hover ">
                                          <thead class="maintananceTable">
                                                <tr>
                                                      <td>Instalment no.</td>
                                                      <td>Instalment amount</td>
                                                      <td>Instalment date</td>
                                                      <td>Action</td>
                                                </tr>
                                          </thead>
                                          <tbody id="body">
                                                <tr>
                                                      <td><input type="number" name="instalment_number[]" class="form-control"></td>
                                                      <td><input type="number" name="instalment_amount[]" class="form-control"></td>
                                                      <td><input type="date" name="instalment_date[]" class="form-control" value="<?php echo $date?>"></td>
                                                      <td><input type="button" class="btn btn-primary btn-lg" value="add" id="add"></td>
                                                </tr>
                                          </tbody>
                                    </table>
                              </div>

                              <script>
                              var html = '<tr><td><input type="number" name="instalment_number[]" class="form-control"></td><td><input type="number" name="instalment_amount[]" class="form-control"></td><td><input type="date" name="instalment_date[]" class="form-control" value="<?php echo $date?>"></td><td><input type="button" class="btn btn-danger btn-sm" value="remove" id="remove"></td></tr>';
                              $(document).ready(function(){
                              $("#add").click(function(){
                                    var x = 1;
                                    $("#body").append(html);
                                    x++;

                                    $("#body").on("click", "#remove", function(){
                                          $(this).closest('tr').remove();
                                          x--;
                                    })
                              })
                              });
                              </script>

                              <!-- end maintanance -->
                              
                              <!-- start Renewal -->
                              <hr>
                              <h5 class="mt-5 mb-2">Renewal / Maintanance</h5>
                              <div class="container">
                                    <table class="table table-bordered table-hover ">
                                          <thead class="maintananceTable">
                                                <tr>
                                                      <td>Renewal type.</td>
                                                      <td>Renewal Amount</td>
                                                      <td>Renewal Date</td>
                                                      <td>Action</td>
                                                </tr>
                                          </thead>
                                          <tbody id="renewal-body">
                                                <tr>
                                                      <td>
                                                            <select name="renewal_type[]" class="form-select">
                                                                  <option value="1">Yearly</option>
                                                                  <option value="2">Monthly</option>

                                                            </select>
                                                      </td>
                                                      <td><input type="number" name="renewal_amount[]" class="form-control"></td>
                                                      <td><input type="date" name="renewal_date[]" class="form-control" value="<?php echo $date?>"></td>
                                                      <td><input type="button" class="btn btn-success btn-lg" value="add" id="renewal-add"></td>
                                                </tr>
                                          </tbody>
                                    </table>
                              </div>

                              <script>
                              var renewalHtml = '<tr><td><select name="renewal_type[]" class="form-select"><option value="1">Yearly</option><option value="2">Monthly</option></select></td><td><input type="number" name="renewal_amount[]" class="form-control"></td><td><input type="date" name="renewal_date[]" class="form-control" value="<?php echo $date?>"></td><td><input type="button" class="btn btn-danger btn-sm" value="remove" id="renewal-remove"></td></tr>';
                              $(document).ready(function(){
                              $("#renewal-add").click(function(){
                                    var x = 1;
                                    $("#renewal-body").append(renewalHtml);
                                    x++;

                                    $("#renewal-body").on("click", "#renewal-remove", function(){
                                          $(this).closest('tr').remove();
                                          x--;
                                    })
                              })
                              });
                              </script>

                              <div class="customer-btn text-end my-5">
                                    <button class="btn btn-lg btn-primary" name="btn" id="btn">Save Customer</button>
                              </div>
                        </div>
                       
                  </div>
            </form>
    </div>

  </main><!-- End #main -->

  <?php include('include/admin-footer.php');?>




  





