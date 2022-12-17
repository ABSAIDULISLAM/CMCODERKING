<?php
namespace App\Classes;
use App\Classes\Database;

class Amount{
      public static function cashForTodaySale($todat){
           $sql = "SELECT SUM(rec_amount) as amount FROM `cash_tbl` WHERE rec_date = '$todat'";
           $query = mysqli_query(Database::dbConnect(), $sql);
           return $query;
            
      }
}


?>