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
use App\Classes\Customer;
use App\Classes\Database;
// add customer
if(isset($_POST['btn'])){
     $message = Customer::addCustomer($_POST);
}

// getdivisionInfo for dropdown
 $divisionInfo = Customer::getdivisionInfo();

 $id =  $_GET['edit'];
if(isset($_GET['edit'])){
      $id =  $_GET['edit'];
      $personalInfo =  Customer::getPersonalInfoForEdit($id);
}


if(isset($_POST['update'])){
//      $mId = $maintanance['id'];
//      $rId = $renewInfo['id'];
      Customer::personalInfoUpdate($_POST, $id);
}

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
                        <h3 class="text-center my-4">Edit Customer</h3>
                        <div class="card-body">
                              <div class="personal-info">

                              <h5>Personal Info </h5>
                                    <div class="row my-2 rowone">
                                          
                                          <div class="col-md-4">
                                                <div class="form-group row mt-3">
                                                      <label for="" class="my-2  mt-1">Name</label>
                                                      <div class="">
                                                            <input type="text" value="<?php echo $personalInfo['name']; ?>" name="name" Required class="form-control ">
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="form-group row mt-3">
                                                      <label for="" class="my-2 mt-1">Mobile</label>
                                                      <div class="">
                                                            <input type="number"  value="<?php echo $personalInfo['mobile']; ?>" Required name="mobile" class="form-control ">
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col-md-4">
                                                <div class="form-group row my-3">
                                                      <label for="" class="my-2 mt-1">Email</label>
                                                      <div class="">
                                                            <input type="email"   value="<?php echo $personalInfo['email']; ?>" Required name="email" class="form-control ">
                                                      </div>
                                                </div>
                                          </div>   
                                    </div>     
                                    <?php 
                                          $sql = "SELECT `id`, `name`, `mobile`, `email`, dnl.division_name, dl.district_name, tl.thana_name, ul.union_name, `village`, `created_at`, `updated_at` FROM personal_info pi INNER JOIN district_list dl ON pi.district = dl.district_id 
                                          INNER JOIN division_list dnl ON pi.division = dnl.division_id
                                          INNER JOIN thana_list tl ON pi.upzila = tl.thana_id
                                          INNER JOIN union_list ul ON pi.user_union = ul.union_id";
                                          $query = mysqli_query(database::dbConnect(), $sql);
                                          $customerInfo = mysqli_fetch_assoc($query);
                                          ?>                               
                                    <div class="row mb- rowtwo">       
                                          <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Division</label>
                                                      <select name="division" id="division"  class="form-select" Required>
                                                      <option selected value="<?php echo $customerInfo['id'] ?>"><?php echo $customerInfo['division_name'] ?></option>
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
                                                      <option selected value="<?php echo $customerInfo['id'] ?>"><?php echo $customerInfo['district_name'] ?></option>
                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-2 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Upzila</label>
                                                      <select name="upzila" id="upzila"  class="form-select" Required>
                                                      <option selected value="<?php echo $customerInfo['id'] ?>"><?php echo $customerInfo['thana_name'] ?></option>

                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-2 my-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Union</label>
                                                      <select name="user_union" id="user_union"  class="form-select" Required>
                                                      <option selected value="<?php echo $customerInfo['id'] ?>"><?php echo $customerInfo['union_name'] ?></option>

                                                      </select>
                                                </div>
                                          </div>
                                          <div class="col-md-3 mt-4">
                                                <div class="form-group">
                                                      <label for="" class="my-2">Village</label>
                                                      <input type="text" name="village" value="<?php echo $personalInfo['village'] ?>" class="form-control" Required>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <hr>
                              <?php
                                    $sql = "SELECT * FROM product_details WHERE customer_id = '$id'";
                                    $query = mysqli_query(Database::dbConnect(), $sql) or die("query Problem".mysqli_error(Database::dbConnect()));
                                    $productdetails =  mysqli_fetch_assoc($query);
                              ?>
                              <h5 class="mt-5 ">Product details</h5>
                              <div class="row rowthree">
                              <label for="" class=" my-2">Product description</label>
                                    <div class="col-md-12 ">
                                          <div class="form-group row ">
                                                <div class=" text-start mb-4">
                                                      <textarea name="product_description" Required class="form-control" id="" cols="10" rows="3"><?php echo $productdetails['product_description'] ?></textarea>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="row my-4 rowfour">
                                    <div class="col-md-3 ">
                                          <div class="form-group row">
                                                <label for="" class="  my-2">Product total price</label>
                                                <div class="">
                                                      <input type="number" value="<?php echo $productdetails['total_price'] ?>" Required name="total_price" class="form-control">
                                                </div>
                                          </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                          <div class="form-group row">
                                                <label for="" class=" my-2">Initial instalment</label>
                                                <div class="">
                                                      <input type="number" value="<?php echo $productdetails['initit_instal'] ?>" Required name="initit_instal" class="form-control">
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                          <div class="form-group row">
                                                <label for="" class=" my-2">Product Deadline</label>
                                                <div class="">
                                                      <input type="date" value="<?php echo $productdetails['deadline'] ?>" Required name="deadline" class="form-control">
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <hr>
                              

                              <div class="customer-btn text-end my-5">
                                    <button class="btn btn-lg btn-primary" name="update" id="btn">Update Customer Info</button>
                              </div>
                        </div>
                       
                  </div>
            </form>
    </div>

  </main><!-- End #main -->

  <?php include('include/admin-footer.php');?>




  





