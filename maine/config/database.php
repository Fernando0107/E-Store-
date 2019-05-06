<?php
// used to connect to the database
$host = "remotemysql.com";
$db_name = "Y1YLATiS3H";
$username = "Y1YLATiS3H";
$password = "tq1RyTAGF5";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>