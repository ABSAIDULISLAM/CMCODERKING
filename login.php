<?php
session_start();
if(isset($_SESSION["admin_name"]) && isset($_SESSION["admin_id"])){
      header('Location: admin/dashboard.php');
}
if(isset($_SESSION["user_name"]) && isset($_SESSION["user_id"])){
      header('Location: user/dashboard.php');
}


require_once('vendor/autoload.php');
$message = '';
use App\Classes\Login;
if(isset($_POST['btn'])){
      $message = Login::LoginCheck($_POST);
   }
   

?>




<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CM | Login</title>
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/style.css">

      <style>
            .header{
                  background-color: #243949;
            }
            .imgdiv{
                  position: relative;
                  height:100%;
                  width:100%
            }
            .textDiv{
                  position: absolute;
                  top:0;
                  height:100%;
                  width:100%;
                  background: linear-gradient(rgba(0, 0, 0, 0.7),rgba(0, 0, 0, 0.7));
            }
            .text{
                  margin-top: 200px;
            }
            .bodyh{
                  font-weight: 450;
            }
            .imgdiv .textDiv .text .bodyt{
                  font-weight: 400;
                  font-size: 20px;
                  color: #1A7BF9;
            }
            .lform{
                  margin-top: 150px;
            }
            .btn {
                  padding: 5px 30px;
            } 
            
      </style>

</head>



<body>

      <header class="header">
            <div class="container-fluid">
                  
            <div class="row">
                  <div class="col-md-5">
                        <div class="imgdiv">
                              <img class="lImg" src="assets/img/register.png" width="100%" height="730px" alt="">
                            <div class="textDiv">

                              <div class="text">
                              <h1 class="display-5 text-bolder text-center text-white bodyh">Cloud Soft</h1>
                              <p class="display-6 text-bolder text-center text-white pt-2 bodyt" style="color:#1A7BF9" >Inventory & Stock Management</p>
                                    </div>
                            </div>
                              

                        </div>
                  </div>
                  <div class="col-md-7 ftop">
                        <div class="container">
                              <div class="row">
                                    <div class="col-md-6">
                                         <div class="col-md-4 mt-2">
                                         <select class="form-select" aria-label="Default select example">
                                                <option value="1">English</option>
                                                <option value="2">Bangla</option>
                                                <option value="3">Spanish</option>
                                                <option value="3">Hindi</option>
                                                <option value="3">Dutch</option>
                                                <option value="3">Frech</option>
                                                <option value="3">Polish</option>
                                                <option value="3">Turki</option>
                                                <option value="3">Romania</option>
                                                <option value="3">Lio</option>
                                                </select>
                                         </div>
                                          <form action="" method="post" class="lform ms-5">
                                                <div class="form-group mb-2">
                                                <h4 class="text-danger text-center"> <?php echo $message; ?></h4>
                                                      <label for="" class="text-white text-bolder mb-1">Customer Name</label>
                                                      <input type="name" name="name" value="admin" required class="form-control">
                                                </div>
                                                <div class="form-group mb-2">
                                                      <label for="" class="text-white mb-1 text-bolder">Password</label>
                                                      <input type="password" name="password" value="01795828708" required class="form-control">
                                                </div>
                                                <div class="form-group mb-2">
                                                      <input type="checkbox" class="form-check-input ms-2" id="exampleCheck1">
                                                      <label class="form-check-label text-white" for="exampleCheck1"> Remember Me</label>
                                                </div>
                                                <div class="form-group mb-2">
                                                      <input type="submit" class="btn btn-primary" name="btn" value="Login">                                                      
                                                </div>
                                         </div>                                                
                                          </form>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            </div>
      </header>

      
</body>
</html>