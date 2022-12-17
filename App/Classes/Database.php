<?php
namespace App\Classes;

      class Database{
            public static function dbConnect(){
                  $hostName = "localhost";
                  $userName = "root";
                  $password = "";
                  $dbName = "coder_king_cm";
                  $link = mysqli_connect("$hostName", "$userName", "$password", "$dbName");
                  return $link;

            }
      } 
?>