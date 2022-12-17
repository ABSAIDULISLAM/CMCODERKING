<?php
namespace App\Classes;
use App\Classes\Database;

class Date{
      public static function format($date){
           return date('F, j, Y, g:i a', strToTime($date));
      }
      // $date = date("Y-m-d", strtotime("+6 HOURS"));
}


?>