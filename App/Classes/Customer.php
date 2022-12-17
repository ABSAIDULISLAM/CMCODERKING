<?php
namespace App\Classes;
use App\Classes\Database;

class Customer{
      // for get division info
      public static function getdivisionInfo(){
            $sql = "SELECT * FROM  division_list";
            $divisionInfo = mysqli_query(Database::dbConnect(), $sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
            return $divisionInfo;

      }

      // add addCustomer
      public static function addCustomer($data){
            // forn personal tble
            $lastId;
           $name = $data['name'];
           $mobile = $data['mobile'];
           $email = $data['email'];
           $division = $data['division'];
           $district = $data['district'];
           $upzila = $data['upzila'];
           $union = $data['user_union'];
           $village = $data['village'];

      //      for product details
           $product_desc = $data['product_description'];
           $totalPrice = $data['total_price'];
           $ininstal = $data['initit_instal'];
           $deadline = $data['deadline'];

           //for maintanance
           $initNum = $data['instalment_number'];
           $initAmount = $data['instalment_amount'];
           $initDate = $data['instalment_date'];

            // for user 
           $name = $data['name'];
           $mobile = $data['mobile'];
           $userType = $data['user_type'];

      //      for renewal
            $rtype = $data['renewal_type'];
            $ramount = $data['renewal_amount'];
            $rdate = $data['renewal_date'];

            //FOR CASH TABLE
            // $product_desc = $data['product_description'];
            // $ininstal = $data['initit_instal'];
            // $lastTime;

            // for personal_info form
           $sql =  "INSERT INTO personal_info (name, mobile, email, division, district, upzila, user_union, village) VALUES('$name', '$mobile', '$email', '$division', '$district', '$upzila', '$union', '$village')";

          $personal = mysqli_query(Database::dbConnect(), $sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
      //     Geting last id
            $sql2 = "SELECT id FROM `personal_info` ORDER BY id DESC LIMIT 1";
            $personal_id = mysqli_query(Database::dbConnect(), $sql2);
            $row = mysqli_fetch_assoc($personal_id);
            $lastId = $row['id'];

            // for product details
          if($personal ==1){
            $sqltwo =  "INSERT INTO product_details (product_description, total_price, initit_instal, deadline, customer_id) VALUES('$product_desc', '$totalPrice', '$ininstal', '$deadline', '$lastId')";
            $pdetails = mysqli_query(Database::dbConnect(), $sqltwo) or die('somossa hoiche'.myqli_error(Database::dbConnect()));

            // for mailtanance
            if($pdetails ==1){
                  foreach($initNum as $key => $value){
                        $sqlthree =  "INSERT INTO maintanance (instalment_number, instalment_amount, instalment_date, customer_id, pay_amount) VALUES('".$value."', '".$initAmount[$key]."', '".$initDate[$key]."', '$lastId', '0')";
                        $maintanance = mysqli_query(Database::dbConnect(), $sqlthree) or die('somossa hoiche'.myqli_error(Database::dbConnect()));

                  }
                  
                  // for users
            if($maintanance==1){
                  $sqlfour =  "INSERT INTO users (name, mobile, user_type, user_image, customer_id) VALUES('$name', '$mobile', 'user', 'admin.jpg', '$lastId')";
                  $user = mysqli_query(Database::dbConnect(), $sqlfour) or die('somossa hoiche'.myqli_error(Database::dbConnect()));

                  // for renewal
                  if($user ==1){
                        foreach($rtype as $key => $renewalvalue){
                              $sqlFive = "INSERT INTO renewal_tbl (customer_id, renewal_type, renewal_amount, renewal_date) VALUES('$lastId', '".$renewalvalue."', '".$ramount[$key]."', '".$rdate[$key]."')";
                              $renewal = mysqli_query(Database::dbConnect(), $sqlFive) or die('somossa hoiche'.myqli_error(Database::dbConnect()));

                        }
                        if($renewal==1){
                              $sqlSix = "INSERT INTO cash_tbl (customer_id, rec_description, rec_amount) VALUES('$lastId', '$product_desc', '$ininstal' )";
                              if(mysqli_query(Database::dbConnect(), $sqlSix)){
                                    $message = "Customer Info Saved Succesfully";
                                    return $message;
                              }else{
                                    die('Query Problem'.mysqli_error(Database::dbConnect()));
                              }
                        }
                  }
            }      

            }
          }
      }

      // view customer by customer{personal_info} by id
      public static function viewCustomerInfo($id){
            $sql = "SELECT `id`, `name`, `mobile`, `email`, `division`, dl.district_name, tl.thana_name, ul.union_name, `village`, `created_at`, `updated_at` FROM personal_info pi INNER JOIN district_list dl ON pi.district = dl.district_id
            INNER JOIN thana_list tl ON pi.upzila = tl.thana_id
            INNER JOIN union_list ul ON pi.user_union = ul.union_id WHERE id = '$id' ";

            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
            $customerInfo = mysqli_fetch_assoc($queryResult);
            return $customerInfo;

      }

      // editable form for customer Info
      public static function getPersonalInfoForEdit($id){
            $sql = "SELECT * FROM personal_info WHERE id = '$id' ";
            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
            $personalInfo = mysqli_fetch_assoc($queryResult);
            return $personalInfo;

      }

      public static function personalInfoUpdate($data, $id){
            // forn personal tble
            $lastId;
           $name = $data['name'];
           $mobile = $data['mobile'];
           $email = $data['email'];
           $division = $data['division'];
           $district = $data['district'];
           $upzila = $data['upzila'];
           $union = $data['user_union'];
           $village = $data['village'];

      //      for product details
           $product_desc = $data['product_description'];
           $totalPrice = $data['total_price'];
           $ininstal = $data['initit_instal'];
           $deadline = $data['deadline'];


            // for personal_info form
           $sql = "UPDATE personal_info SET name = '$name', mobile = '$mobile', email= '$email', division= '$division', district= '$district', upzila= '$upzila', user_union='$union', village='$village' WHERE id = '$id'";

          $personal = mysqli_query(Database::dbConnect(), $sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
      //     Geting last id
            $sql2 = "SELECT id FROM personal_info ORDER BY id DESC LIMIT 1";
            $personal_id = mysqli_query(Database::dbConnect(), $sql2);
            $row = mysqli_fetch_assoc($personal_id);
            $lastId = $row['id'];

            // for product details
          if($personal ==1){
            $sqltwo = "UPDATE product_details SET product_description = '$product_desc', total_price = '$totalPrice', initit_instal= '$ininstal', deadline = '$deadline',  customer_id =  '$lastId' WHERE customer_id = '$id' ";

            $pdetails = mysqli_query(Database::dbConnect(), $sqltwo) or die('somossa hoiche'.myqli_error(Database::dbConnect()));

            if($pdetails==1){
                        // $message = "Customer Info Updated Succesfully";
                        // return $message;
                        header("Location: manage-customer.php");
            }
          }
      }

      // ---modal instalment edit
      public static function instalmentEdit($id){
            $sql = "SELECT mc.id, `instalment_number`, `instalment_amount`, `instalment_date`, mc.created_at, mc.updated_at, pi.name, `pay_date`, `pay_amount`, `collectable_amount`, `user_id`, `status` FROM maintanance mc INNER JOIN personal_info pi
            ON mc.customer_id = pi.id WHERE mc.id = '$id' ";

            $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
            $instalmentIfoforedit = mysqli_fetch_assoc($queryResult);
            return $instalmentIfoforedit;

      }

      // update Instalment
      public static function updateInstalment($data){

                 $initNumber = $data['instalment_number'];
                 $initAmount = $data['instalment_amount'];
                 $initDate = $data['instalment_date'];
                  $id = $data['isId'];

                  $sql = "UPDATE maintanance SET instalment_number = '$initNumber', instalment_amount= '$initAmount', instalment_date ='$initDate' WHERE id = '$id' ";
                 $edit = mysqli_query(Database::dbConnect(), $sql) or die("problem".mysqli_error(Database::dbConnect()));
                 if($edit){
                  header("Location: manage-instalment.php");
                 }
      }


      // instalment Delete
      public static function instalmentDelete($id){

            $sql = "SELECT * FROM maintanance WHERE id = '$id'";
            $mquery = mysqli_query(Database::dbConnect(), $sql);
            return $mquery;
      }

}


?>