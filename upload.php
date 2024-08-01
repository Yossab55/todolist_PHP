<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
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
include('connect.php');
$sql_select = "SELECT * FROM tasks WHERE id=" . $_GET['id'];
$statement_select = $data_base_work->prepare($sql_select);
$statement_select->execute();
$result = $statement_select->fetch(PDO::FETCH_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST" && $result) {
  // upload file clicked 
  if (isset($_POST['up']) || !(is_null($_POST))) {
    $is_moved;
    $tmp = explode(".", $_FILES['file_upload']['name']);
    $filename = time() . '_' . rand(100, 999) . '.' . end($tmp);
    $temp_name = $_FILES['file_upload']['tmp_name'];
    $folder = "upload/" . $filename;
    $data = [
      'description_data' => $_POST['description']
    ];
    $sql_update = "UPDATE tasks SET description_db = :description_data WHERE id =" . $_GET['id'];
    $statement_update = $data_base_work->prepare($sql_update);
    $statement_update->execute($data);

    // move to upload folder 
    if (move_uploaded_file($temp_name, $folder)) {
      $is_moved = TRUE;
      $data = [
        'filename_data' => $filename,
      ];
      $sql_update = "UPDATE tasks SET filename_db = :filename_data WHERE id =" . $_GET['id'];
      $statement_update = $data_base_work->prepare($sql_update);
      $statement_update->execute($data);
    }
    header('location: index.php');
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
  <?php
  if ($result) {
  ?>
    <div class="container">
      <h1 class="title">Upload An Image & a Description To Your Task <i class="fa-regular fa-image"></i></h1>
    </div>
    <div class="container">
      <form action="" method="post" enctype="multipart/form-data" class="form_upload">
        <label>
          Upload Image
          <input type="file" name="file_upload" accept="image/*">
        </label>
        <textarea name="description"><?php echo $result['description_db']; ?></textarea>
        <button type="submit">
          <i class="fa-regular fa-paper-plane"></i>
        </button>
      </form>
    </div>
    <!-- is inserted or not -->
  <?php
  } else {
  ?>
    <h1 style="text-align: center;">THIS TASK NOT EXIST</h1>
  <?php
  }
  ?>
  <?php

  if (isset($is_moved)) {
  ?>
    <div class="container">
      <div class="taskMessage">
        <p class="text">
          <?php
          if ($is_moved) {
            echo "Image Has Been Uploaded Successfully";
          } else {
            echo "Image Has Not Been Uploaded";
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