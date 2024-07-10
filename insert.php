<?php
  $is_inserted = false;
  if($_SERVER["REQUEST_METHOD"] = "GET") {
    include("connect.php");

    if(in_array("insert", $_GET)) {
      $data = [
        "todo" => $_GET["todo"],
        "statues" => "U"
      ];
      $sql_insert = "INSERT INTO tasks (task, sta) VALUES  (:todo, :statues )";
      $data_base_work->prepare($sql_insert)->execute($data); 
      $is_inserted = true;
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
      <link rel="stylesheet" href="css/all.min.css">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/insert.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" 
          rel="stylesheet">
    <title>Add Tasks</title>
  </head>
  <body>
    <!-- start inset task -->
      <div class="container">
        <form action="" method="get">
          <h2>Write Your Tasks</h2>
          <div class="form">
            <input type="text" name="todo" placeholder="Wash the dishes" >
            <button type="submit" name="submit" value="insert">
              <i class="fa-solid fa-download fa-xl"></i>
            </button>
          </div>
        </form>
        
      <div>
      <!-- end inset task -->
      <?php 

        if($is_inserted) :?>

        <div class="container">
          <div class="taskMessage">
            <p class= "text">Task Has Been Inserted Successfully</p>
          </div>
        </div>
      <?php 

        endif;?>
      <!-- go back button to home page -->
      <div class="container">
        <div class="go_back">
          <a href="index.php">
            <p>Go Back To Home page</p>
            <i class="fa-solid fa-house"></i>
          </a>
        </div>
      </div>
  </body>
</html>