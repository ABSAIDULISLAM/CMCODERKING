<?php
require_once('../vendor/autoload.php');
use App\Classes\Database;

// for district 
     $con = mysqli_connect("localhost", "root", "", "coder_king_cm") or die("Connection failed");

     if(isset($_POST['id'])){
      $id = $_POST['id'];
      $query = mysqli_query($con, "SELECT * FROM district_list WHERE division_id  = '$id' ");
      echo "<option value='' desebled> --Select one --</option>";
      while($row = mysqli_fetch_array($query)){
            $id = $row['district_id'];
            $name = $row['district_name'];
            echo "<option value='$id'>$name</option>";
      }
     }
// //  for thana info

     if(isset($_POST['upzilaId'])){
      $id = $_POST['upzilaId'];
      $query = mysqli_query($con, "SELECT * FROM thana_list WHERE district_id = '$id' ");
      echo "<option value='' desebled> --Select one --</option>";
      while($row = mysqli_fetch_array($query)){
            $tid = $row['thana_id'];
            $tname = $row['thana_name'];
            echo "<option value='$tid'>$tname</option>";
      }
     }
// //      for uinon info 

     if(isset($_POST['userUnionId'])){
      $id = $_POST['userUnionId'];
      $query = mysqli_query($con, "SELECT * FROM union_list WHERE thana_id = '$id'");
      echo "<option value='' desebled> --Select one --</option>";
      while($row = mysqli_fetch_array($query)){
            $uid = $row['union_id'];
            $uname = $row['union_name'];
            echo "<option value='$uid'>$uname</option>";
      }
     }
     // ===== end for ad-customer division, district, thana, union dreopdown =====

      // form nitial number from maintanance table
     
      if(isset($_POST['initId'])){
            $id = $_POST['initId'];

          $query = mysqli_query($con, "SELECT * FROM maintanance WHERE customer_id = '$id'");

          echo "<option value='' desebled> --Select one --</option>";
            while($row = mysqli_fetch_array($query)){
                  $instid = $row['id'];
                  $instname = $row['instalment_number'];
                  echo "<option value='$instid'>$instname</option>";
            }
      }

      // for instalment_amount 
    
      if(isset($_POST['instamountId'])){
            $cus_id = $_POST['customar_id'];
            $inst_id = $_POST['instamountId']; 
      
          $query = mysqli_query($con, "SELECT * FROM maintanance WHERE customer_id = '$cus_id' AND id = '$inst_id'");

            while($row = mysqli_fetch_array($query)){
                  $amountnstid = $row['id'];
                  $initAmount = $row['instalment_amount'];
                  // echo "<option value='$amountnstid'>$initAmount</option>";
                  echo $initAmount;
            }
      }

      // for instalment part
      if(isset($_GET['delete'])){
            $id = $_GET['id'];
            Customer::instalmentDelete($id);
       }
      // for instalment show
      if(isset($_POST['cusId'])){
            $id = $_POST['cusId'];
            $color;
            $status;

          $query = mysqli_query($con, "SELECT * FROM maintanance WHERE customer_id = '$id' ");
            $i = 1;
            while($row = mysqli_fetch_array($query)){
                  
                  
                  $instid = $row['id'];
                  $instNumber = $row['instalment_number'];
                  $insAmount = $row['instalment_amount'];
                  $instDate = $row['instalment_date'];
                  $instPayAmount = $row['pay_amount'];
                  $instPayDate = $row['pay_date'];
                  $instPayStatus = $row['status'];
                  if($instPayStatus == 1){ $color = "green"; $status="Paid";}else{$color = "red"; $status="Due";}
                  // echo $instNum;
                  
                  
                  echo '
                  <tr>
                        <td>'.$i++.'</td>
                        <td>'.$instid.'</td>
                        <td>'.$instNumber.'</td>
                        <td>'.$insAmount.'</td>
                        <td>'.$instDate.'</td>
                        <td>'.$instPayAmount.'</td>
                        <td>'.$instPayDate.'</td>
                        <td><b style="color:'.$color.'">'.$status.'</b></td>
                        <td>
                        <a href="edit-instalment.php?edit='.$instid.'" class= "btn btn-primary btn-sm">Edit</a>
                        <a href="?delete=true&id='.$instid.'" onclick="return confirm("are Your sure to delete This !!")" class="btn btn-danger btn-sm">Delete</a>

                        <a href="instalment-collection.php?collection='.$instid.'" type="button" class="btn btn-primary">Receive</a>
                        </tr>';

            }
      }


            // for Renewal part
            if(isset($_GET['delete'])){
                  $id = $_GET['id'];
                  Customer::renewDelete($id);
            }
            // for renewal show
            if(isset($_POST['cusIdr'])){
                  $id = $_POST['cusIdr'];
                  $color;
                  $status;
      
                $query = mysqli_query($con, "SELECT * FROM renewal_tbl WHERE customer_id = '$id' ");
                $i = 1;
                  while($row = mysqli_fetch_array($query)){

                        $renewid = $row['id'];
                        $renewNumber = $row['renewal_type']==1 ? "Yearly" : "Monthly";
                        $renewAmount = $row['renewal_amount'];
                        $renewDate = $row['renewal_date'];
                        $renewPayAmount = $row['renewal_collection'];
                        $renewPayDate = $row['pay_date'];
                        $renewPayStatus = $row['status'];
                        if($renewPayStatus ==1){ $color = "green"; $status = "paid";}else{$color = "red"; $status = "Due" ; }
                        // echo $instNum;
                        
                        
                        echo '
                        <tr>
                              <td>'.$i++.'</td>
                              <td>'.$renewid.'</td>
                              <td>'.$renewNumber.'</td>
                              <td>'.$renewAmount.'</td>
                              <td>'.$renewDate.'</td>
                              <td>'.$renewPayAmount.'</td>
                              <td>'.$renewPayDate.'</td>
                              <td><b style="color: '.$color.'">'.$status.'</b></td>
                              <td>
                              <a href="edit-renewal.php?edit='.$renewid.'" class="btn btn-success btn-sm">Edit</a>
                              <a href="?delete=true&id='.$renewid.'" class="btn btn-danger btn-sm">Delete</a>
                              <a href="renewal-collection.php?collection='.$renewid.'" class="btn btn-primary btn-sm">Receive</a>
                              </td>
                        </tr>';
                  }
            }
      


?>

<script>
      $(document).ready(function(){
            
            $("#showDialoguebtn").click(function(){
                  $("#dialogueBox").show();
            })
      })
</script>