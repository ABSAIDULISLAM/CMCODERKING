<?php
namespace App\Classes;
use App\Classes\Database;

class Login{
      public static function LoginCheck($data){
          $name = $data['name'];
          $password = $data['password'];
          $sql = "SELECT * FROM users WHERE name='$name' AND mobile = '$password' ";
          if(mysqli_query(Database::dbConnect(), $sql)){
            $queryResult = mysqli_query(Database::dbConnect(), $sql);
            $userInfo =  mysqli_fetch_assoc($queryResult);
            
            // $_SESSION['user_type'] = $userInfo['user_type'];
            if($userInfo){
                  if($userInfo['name']==$name && $userInfo['mobile']==$password && $userInfo['user_type']=='admin'){
                        $_SESSION['admin_id'] = $userInfo['id'];
                        $_SESSION['admin_name'] = $userInfo['name'];
                   //      $_SESSION['admin_image'] = $userInfo['image'];
                         $adminMes ="Welcome to Admin Dashboard";
                         $_SESSION['adminMessage'] = $adminMes;
                        header('Location: admin/dashboard.php');
                   }else if($userInfo['name']==$name && $userInfo['mobile']==$password && $userInfo['user_type']=='user'){
                         $_SESSION['user_id'] = $userInfo['id'];
                         $_SESSION['user_name'] = $userInfo['name'];
                         $_SESSION['customer_id'] = $userInfo['customer_id'];
                         $_SESSION['user_image'] = $userInfo['user_image'];
                         // $_SESSION['user_image'] = $userInfo['image'];
                         $userMessage ="Welcome to User Dashboard";
                         $_SESSION['userMessage'] = $userMessage;
                         header('Location: user/dashboard.php');
                   }else{
                         $message = "Wrong User Name or Password";
                         return $message;
                   }
            }else{
                  $message = "Wrong User Name or Password";
                  return $message;
            }

          }else{
            die('Query Problem'.mysqli_error(Database::dbConnect()));
          }

      }

      public static function adminLogout(){
            unset($_SESSION['admin_id']);
            unset($_SESSION['admin_name']);
            session_unset();
            session_destroy();
            header('Location: ../login.php');

      }
      public static function userLogout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            session_unset();
            session_destroy();
            header('Location: ../login.php');

      }


}


?>