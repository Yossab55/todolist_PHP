<?php

if($_SERVER["REQUEST_METHOD"] == "GET") {
  if (in_array("change_style", $_GET)) {
    if (isset($_COOKIE['style'])) {
      if ($_COOKIE['style'] != "dark") {
        setcookie("style", "dark", time() + 365 * 24 * 60 * 60);
        header("Location: upload.php");
      } else {
        setcookie("style", "light", time() + 365 * 24 * 60 * 60);
        header("Location: upload.php");
      }
    } else {
      setcookie("style", "dark", time() + 365 * 24 * 60 * 60);
      header("Location: upload.php");
    }
  }
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
  // upload file clicked 
  if(isset($_POST['up']) || ! (is_null($_POST)) ) {
    session_start();
    include('connect.php');
    $is_moved ;
    $filename = $_FILES['file_upload']['name'];
    $temp_name = $_FILES['file_upload']['tmp_name'];
    $folder = "upload/". $filename;
    $data = [
      'filename_data' => $filename,
      'description_data' => $_POST['description']
    ];
    $sql_update ="UPDATE tasks SET filename_db = :filename_data, description_db = :description_data WHERE id =". $_SESSION['image_id'];
    $statement_update = $data_base_work->prepare($sql_update);
    $statement_update->execute($data);
    
    // move to upload folder 
    if(move_uploaded_file($temp_name, $folder)) {
      $is_moved = TRUE ;
    } else {
      $is_moved = FALSE ;
    }
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
    <link rel="stylesheet" href="css/upload.css">
    <?php
    if (isset($_COOKIE['style']) && $_COOKIE['style'] == "dark") {
      echo '<link rel="stylesheet" href="css/dark.css">';
    }
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">
    <title>Upload image & description</title>
  </head>
  <body>
    <nav>
      <form action="" method="get" class="form_dark">
        <div class="Dark_button">
          <button type="submit" name="style" value="change_style">
            <?php
            if (isset($_COOKIE['style']) && $_COOKIE['style'] == "dark") {
              echo '<i class="fa-regular fa-sun fa-2xl sun"></i>';
            } else {
              echo '<i class="fa-regular fa-moon fa-2xl moon"></i>';
            }
            ?>
          </button>
        </div>
      </form>
    </nav>
    <div class="container">
      <h1 class="title">Upload An Image & a Description To Your Task   <i class="fa-regular fa-image"></i></h1>
    </div>
    <div class="container">
      <form action="" method="post" enctype="multipart/form-data" class="form_upload">
        <label>
          Upload Image
          <input type="file" name="file_upload" accept="image/*">
        </label>
        <textarea name="description"></textarea>
        <button type="submit">
          <i class="fa-regular fa-paper-plane"></i>
        </button>
      </form>
    </div>
    <!-- is inserted or not -->
    <?php

      if(isset($is_moved)) {
        ?>
        <div class="container">
          <div class="taskMessage">
            <p class="text">
              <?php
                if($is_moved) {
                  echo "Image Has Been Uploaded Successfully" ;
                } else {
                  echo "Image Has Not Been Uploaded" ;
                }
              ?>
            </p>
          </div>
        </div>
        <?php
      }
    ?>
    <!-- go back home -->
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
