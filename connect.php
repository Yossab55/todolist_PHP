<?php
$dsn = "mysql:host=localhost;dbname=projects" ;
$user = "root";
try {
  $data_base_work = new PDO($dsn, $user,"");
  
} catch(PDOException $e) {
  echo "CAN NOT CONNECT ". $e ;
}