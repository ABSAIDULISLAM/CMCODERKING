<?php
namespace App\Classes;

use App\Classes\Database;

// showUserInstalmentInfoForinstalmentDEtails
class Useroverview{
      public static function showUserInstalmentInfoForinstalmentDEtails($id){
            $sql = "SELECT * FROM maintanance WHERE customer_id = '$id' ";
            $queryForIns = mysqli_query(Database::dbConnect(), $sql);
            return $queryForIns;
      }
      // showUserInstalmentInfoForPaymentDetails
      public static function showUserInstalmentInfoForPaymentDetails($id){
            $sql = "SELECT * FROM maintanance WHERE customer_id = '$id' ";
            $queryForPay = mysqli_query(Database::dbConnect(), $sql);
            return $queryForPay;
      }

      // renewalInfoForrenewalDEtails
      public static function renewalInfoForrenewalDEtails($id){
            $sql = "SELECT * FROM renewal_tbl WHERE customer_id = '$id' ";
            $renewalqueryFordetails = mysqli_query(Database::dbConnect(), $sql);
            return $renewalqueryFordetails;
      }

      public static function renewalInfoForPaymentDetails($id){
            $sql = "SELECT * FROM renewal_tbl WHERE customer_id = '$id' ";
            $renewalqueryForPay = mysqli_query(Database::dbConnect(), $sql);
            return $renewalqueryForPay;
      }



      
      // user Profile Update
      public static function getUserInfoById($id){
            $sql = "SELECT * FROM users WHERE id = '$id' ";
            $userInfo = mysqli_query(Database::dbConnect(), $sql);
            return $userInfo;
      }


      // updateUserPassword
      public static function updateUserPassword($data, $id){

            $query = mysqli_query(Database::dbConnect(), "SELECT * FROM users WHERE id = '$id'");
            $quResult = mysqli_fetch_assoc($query);
            $userPass = $quResult['mobile'];

           $cur_pass = $data['current_password'];
           $new_pass = $data['newpassword'];
           $renew_pass = $data['renewpassword'];

           if($userPass == $cur_pass && $new_pass == $renew_pass){
                  $sql = "UPDATE users SET mobile = '$new_pass' WHERE id = '$id'";
                  if(mysqli_query(Database::dbConnect(), $sql)){
                        $message = "<h4 style='color: #157347'>Password Updated Successfully</h4>";
                        return $message;
                  }else{
                        die("query Problem".mysqli_error(Database::dbConnect()));
                  }
                  
           }else{
                  $message = "<h4 style='color: red'>Password not Matched</h4>";
                  return $message;
           }
      }

      // updateUserInfo

      public static function updateUserInfo($data, $id){
            $postimage = $_FILES['profile_image']['name'];
    
            if($postimage){
                    //ager image unset  or delete korar jonno
                $sql = "SELECT * FROM users WHERE id = '$id'";
                $queryResult = mysqli_query(Database::dbConnect(), $sql);
                $postInfo = mysqli_fetch_assoc($queryResult);
                unlink($postInfo['user_image']);
    
    
                $fileName = $_FILES['profile_image']['name'];
                $directory = "../Assets/images/";
                $imageUrl = $directory.$fileName;
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
                // $imageSize = $_FILES['profile_image']['size'];
                $check = getimagesize($_FILES['profile_image']['tmp_name']);
        
                if($check){
                    if(file_exists($imageUrl)){
                        die('File Already Exists. Please try again with Another file. Thanks!');
                    }else{
                        if($_FILES['profile_image']['size'] > 5000000){
                            die('Your File Too big. Please Select file Between 5mb, Thanks!');
                        }else{
                            if($fileType != 'jpg' && $fileType != 'png' && $fileType != 'gif' && $fileType != 'docx' && $fileType != 'JPG' && $fileType != 'PNG' && $fileType != 'GIF' && $fileType != 'DOCX' ){
                                die('Please Select jpg, png, gif, docx file only. Thanks!');
                            }else{
                                move_uploaded_file($_FILES['profile_image']['tmp_name'], $imageUrl);
        
                                $sql = "UPDATE users SET user_image= '$imageUrl' WHERE id = '$id'";
        
                                if(mysqli_query(Database::dbConnect(), $sql)){
                                    $message = "Profile Updated Successfully";
                                    return $message;
                                }else{
                                    die('Query Problem').mysqli_error(Database::dbConnect());
                                }
                            }
                        }
                    }
                }else{
                    die('Please Chose a Image File. Thanks!');
                }
    
    
    
            }
            // else{
                
            //     $sql = "UPDATE users SET name='$data[name]' WHERE id = '$id'";
    
            //     if(mysqli_query(Database::dbConnect(), $sql)){
            //         $message =  "Profile Updated Successfullt";
            //         return $message;
            //     }else{
            //         die('Query Problem').mysqli_error(Database::dbConnect());
            //     }
            // }
              
      }


    //   customer View Info for user customer View
    public static function viewUserMyconstactInfo($id){
        $sql = "SELECT `id`, `name`, `mobile`, `email`, `division`, dl.district_name, tl.thana_name, ul.union_name, `village`, `created_at`, `updated_at` FROM personal_info pi INNER JOIN district_list dl ON pi.district = dl.district_id
            INNER JOIN thana_list tl ON pi.upzila = tl.thana_id
            INNER JOIN union_list ul ON pi.user_union = ul.union_id WHERE id = '$id' ";
        $query = mysqli_query(Database::dbConnect(), $sql);
        return $query;
    }






}


?>