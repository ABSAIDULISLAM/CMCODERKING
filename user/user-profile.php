<?php
session_start();
if(isset($_SESSION['user_id'])==null){
      header('Location: ../login.php');
}


require_once('../vendor/autoload.php');
use App\Classes\Login;
if(isset($_GET['userlogout'])){
      Login::userLogout();
}
//login section

 $message = "";
use App\Classes\Useroverview;

$id = $_SESSION['user_id'];
  $userInfo = Useroverview::getUserInfoById($id);
 $user = mysqli_fetch_assoc($userInfo);



//  update user passwoed
  if(isset($_POST['changePass'])){
    $message = Useroverview::updateUserPassword($_POST, $id);
  }
  if(isset($_POST['userInfoUpdate'])){
    $message = Useroverview::updateUserInfo($_POST, $id);
  }



?>


<?php include('include/user-main-dashboard.php');?>

<main id="main" class="main">


    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
        <h5 class="my-2"><?php echo $message; ?></h5>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link " data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade  profile-overview" id="profile-overview">
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['name'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">Bangladesh</div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="<?php echo $user['user_image'] ?>" alt="Profile">
                        <div class="pt-2">
                          <input type="file" class="btn btn-primary btn-sm" name="profile_image" title="Upload new profile image"><i class="bi bi-upload"></i>
                        </div>
                      </div>
                    </div>

          

                    <div class="text-center">
                      <button type="submit" name="userInfoUpdate" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div> 




                <div class="tab-pane fade show active pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="" method="post">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="current_password" required type="password" class="form-control">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" required type="password" class="form-control">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" required type="password" class="form-control">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="changePass">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>

        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?php echo $user['user_image'] ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $user['name'] ?></h2>

              <div class="social-links mt-2">
              </div>
            </div>
          </div>

        </div>
        
      </div>
    </section>

</main><!-- End #main -->

<?php include('include/user-footer.php');?>