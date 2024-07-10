<?php
  include("connect.php");
  if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(array_key_exists("delete", $_GET)) {
      $sql_delete = "DELETE FROM tasks WHERE id = ".$_GET["delete"] ;
      $statement_delete = $data_base_work->prepare($sql_delete);
      $statement_delete->execute();
      header("Location: index.php");
    }
    if(array_key_exists("complete", $_GET)) {
      $sql_update = "UPDATE tasks SET sta = 'C' WHERE id=".$_GET["complete"];
      $statement_update = $data_base_work->prepare($sql_update);
      $statement_update->execute();
      header("Location: index.php");
    }
    if(in_array("truncate", $_GET)) {
      $sql_truncate = "DELETE FROM tasks";
      $statement_truncate = $data_base_work->prepare($sql_truncate);
      $statement_truncate->execute();
      header("Location: index.php");
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" 
        rel="stylesheet">
    <title>Todo list</title>
  </head>

  <body>
    <!-- start welcome section -->
    <div class="container">
      <h1 class="title">Welcome To Your ToDo List <i class="fa-solid fa-table-list"></i></h1>
    </div>
    <!-- end welcome section -->
    <!-- start show task -->
      <div class="container show_tasks ">
        <!-- IS THERE IS A TASK OR NO FIRST -->
        <?php 
          // if it's array then theres tasks else there is no task
          $sql_number_rows = "SELECT COUNT(*) as num_rows FROM tasks";
          $statement_number = $data_base_work->prepare($sql_number_rows);
          $statement_number->execute();
          $number = $statement_number->fetch(PDO::FETCH_ASSOC);

          if($number["num_rows"] > 0) {
          $sql_select = "SELECT * FROM tasks ORDER BY sta DESC";
          $statement_select = $data_base_work->prepare($sql_select);
          $statement_select->execute();

            while($result = $statement_select->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <div class="box <?php echo ($result["sta"] === "U")?  "bg-r": "bg-lg" ?> ">
                <div class="task"><?php echo $result["task"]?></div>
                <div class="buttons">
                  <form action="" method="get">
                    <button type="submit" name="complete" value="<?php echo $result["id"]?>">
                      <i class="fa-solid fa-check "></i>
                    </button>
                    <button type="submit" name="delete" value="<?php echo $result["id"]?>">
                      <i class="fa-regular fa-trash-can "></i>
                    </button>
                  </form>
                </div>
              </div>
              <?php
            }
            // truncate all 
            ?>
            <form action="" method="get" class="truncate">
              <button type="submit" name="truncate" value = "truncate"> Delete All <i class="fa-solid fa-trash"></i></button>
            </form>
            <?php
          } else {
            echo "<h2 class='al-c '>
              There Is No Tasks Today <i class='fa-solid fa-face-smile-wink c-green'></i>
              </h2>";
          }
          
        ?>
      </div>
    <!-- end show task -->
    <!-- start to tasks -->
    <div class="container go">
      <div class="go-tasks">
        <a href="insert.php">
          <h2>Add Task</h2>
          <span><i class="fa-solid fa-plus"></i></span>
        </a>
      </div>
    </div>
    <!-- end to tasks -->
  </body>
</html>