<?php
namespace App\Classes;
use App\Classes\Database;

class Instalment{
      // getCollectionInfoByID
      public static function getCollectionInfoByID($id){
            $sql = "SELECT mc.id, `instalment_number`, `instalment_amount`, `instalment_date`, mc.created_at, pi.id, pi.name, `pay_date`, `pay_amount`, `collectable_amount`, `user_id`, `status` FROM maintanance mc INNER JOIN personal_info pi
            ON mc.customer_id = pi.id
            AND mc.customer_id = pi.id WHERE mc.id = '$id'";
            $query =  mysqli_query(Database::dbConnect(), $sql) or die('problem'.mysqli_error(Database::dbConnect()));
            return $query;
      }

      // savein & collection instalmentCollection
      public static function saveAndCollectinstalmentCollection($data){

            $customerId = $data['customer_id'];
            $id = $data['maintanance_id'];

            $recDate = $data['receive_date'];
            $recamount = $data['received_amount'];
            $Cltamount = $data['collectable_amount'];

            $recdesc = $data['receive_description'];

            $aquery = mysqli_query(Database::dbConnect(), "SELECT * FROM maintanance WHERE id = '$id'");
            $aresult = mysqli_fetch_assoc($aquery);
            $payamount = $aresult['pay_amount'];
            $insamount = $aresult['instalment_amount'];


            $totalRecAmount = $payamount+$recamount;
            
            $status;
            // if($payamount >= $insamount || $payamount == $insamount){
            //       $status = 1;
            // }else{
            //       $status = 0;
            // }
            if($recamount >= $Cltamount){
                  $status = 1;
            }else{
                  $status = 0;
            }
            

            $sql = "UPDATE maintanance SET  pay_date = '$recDate', pay_amount = '$totalRecAmount', collectable_amount = '$Cltamount', status = '$status' WHERE id = '$id' ";

            $mupdate= mysqli_query(Database::dbConnect(), $sql) or die('Query Problem'.mysqli_error(Database::dbConnect()));

            if($mupdate ==1){
                  $sqltwo = "INSERT INTO cash_tbl (customer_id, rec_description, rec_amount, rec_date) VALUES('$customerId', '$recdesc', '$recamount', '$recDate')";

                  if(mysqli_query(Database::dbConnect(), $sqltwo)){
                        header("Location: manage-instalment.php");
                        // $message = "Cash Received Successfully";
                        // return $message;
                  }else{
                        die("query Problem".mysqli_error(Database::dbConnect()));
                  }

            }
      }

      //for instalment overView Info
      public static function instalmentForOverViewById($id){
            $sql = "SELECT * FROM maintanance WHERE customer_id = '$id'";
            $overviewquery = mysqli_query(Database::dbConnect(), $sql);
            return $overviewquery;
      }


      // renewal section

      // addrenewal
      public static function addrenewal($data){

            $cName = $data['modal_customer_name'];
            $rType = $data['renewal_type'];
            $rAmount = $data['renewal_amount'];
            $rDate = $data['renewal_date'];

            $sql = "INSERT INTO renewal_tbl (customer_id, renewal_type, renewal_amount, renewal_date ) VALUES('$cName', '$rType', '$rAmount', '$rDate')";
            $query = mysqli_query(Database::dbConnect(), $sql);

      }

      // edit renewal
      public static function renewalEdit($id){
                  $sql = "SELECT rt.id, pi.name, `renewal_type`, `renewal_amount`, `renewal_date`, `pay_date`, `user_id`, `status`, rt.created_at, rt.updated_at, `next_date`, `renewal_collection` FROM renewal_tbl rt INNER JOIN personal_info pi
                  ON rt.customer_id = pi.id WHERE rt.id = '$id' ";

                  $queryResult = mysqli_query(Database::dbConnect(),$sql) or die('somossa hoiche'.myqli_error(Database::dbConnect()));
                  $reneawalEditInfo = mysqli_fetch_assoc($queryResult);
                  return $reneawalEditInfo;
      }

      public static function updateRenewal($data){
                 $renewType = $data['renewal_type'];
                 $reneamount = $data['renewal_amount'];
                 $renewdate = $data['renewal_date'];

                  $sql = "UPDATE renewal_tbl SET renewal_type = '$renewType', renewal_amount= '$reneamount', renewal_date ='$renewdate' WHERE id = '$data[reId]' ";
                 $edit = mysqli_query(Database::dbConnect(), $sql) or die("problem".mysqli_error(Database::dbConnect()));
                 if($edit){
                  header("Location: manage-renewal.php");
                 }
  
      }

      // instalment Delete
      public static function renewDelete($id){
            $sql = "DELETE FROM renewal_tbl WHERE id = '$id'";
            mysqli_query(Database::dbConnect(), $sql);
      }

      // for reneal update renewalCollectionInfoById
      public static function renewalCollectionInfoById($id){

            $sql = "SELECT rt.id, pi.name, `renewal_type`, `renewal_amount`, `renewal_date`, `pay_date`, `user_id`, `status`, rt.created_at, pi.id, `next_date`, `renewal_collection` FROM renewal_tbl rt INNER JOIN personal_info pi
            ON rt.customer_id = pi.id AND rt.customer_id = pi.id WHERE rt.id = '$id' ";
           $rquery = mysqli_query(Database::dbConnect(), $sql);
           return $rquery;
      }

      // saveandUpdateRenewalCollection
      public static function saveandUpdateRenewalCollection($data){
            // echo '<pre>';
            // print_r($data);
            // exit();
            $id = $data['renewal_id'];

            $query = mysqli_query(Database::dbConnect(), "SELECT * FROM renewal_tbl WHERE id = '$id' ");
            $row = mysqli_fetch_assoc($query);
            $renewAmount = $row['renewal_amount'];
            $rencollection = $row['renewal_collection'];

            $customerId = $data['renewal_customer_name'];

            $recamount = $data['receive_amount'];
            $recAmoDate = $data['renewal_receive_date' ];
            $Cltamount = $data['collectable_amount'];

            $rdesc = $data['renewal_rec_description'];


            $status;
            // if( $rencollection >= $renewAmount){
            //       $status = 1;
            // }else{
            //       $status = 0;
            // }
            if($recamount >= $Cltamount){
                  $status = 1;
            }else{
                  $status = 0;
            }

           $totalRenAMount = $rencollection+$recamount;

            $sql = "UPDATE renewal_tbl SET pay_date = '$recAmoDate', status = '$status', renewal_collection = '$totalRenAMount' WHERE id = '$id' ";

            $rupdate= mysqli_query(Database::dbConnect(), $sql) or die('Query Problem'.mysqli_error(Database::dbConnect()));

            if($rupdate ==1){
                  $sqltwo = "INSERT INTO cash_tbl (customer_id, rec_description, rec_amount, rec_date) VALUES('$customerId', '$rdesc', '$recamount', '$recAmoDate')";

                  if(mysqli_query(Database::dbConnect(), $sqltwo)){
                        header("Location: manage-renewal.php");
                        // $message = "Cash Received Successfully";
                        // return $message;
                  }else{
                        die("query Problem".mysqli_error(Database::dbConnect()));
                  }
            } 
      }


      // renewalInfoByIdForOverview
      public static function renewalInfoByIdForOverview($id){
            $sql = "SELECT * FROM renewal_tbl WHERE customer_id = '$id'";
            $query = mysqli_query(Database::dbConnect(), $sql);
            return $query;
      }











}












?>