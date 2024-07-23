<?php
  session_start();
  if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (in_array("change_style", $_GET)) {
      if (isset($_COOKIE['style'])) {
        if ($_COOKIE['style'] != "dark") {
          setcookie("style", "dark", time() + 365 * 24 * 60 * 60);
          header("Location: details.php");
        } else {
          setcookie("style", "light", time() + 365 * 24 * 60 * 60);
          header("Location: details.php");
        }
      } else {
        setcookie("style", "dark", time() + 365 * 24 * 60 * 60);
        header("Location: details.php");
      }
    }
  }
  include("connect.php");
  $sql_select = "SELECT * FROM tasks WHERE id=". $_SESSION['image_id'];
  $statement_select = $data_base_work->prepare($sql_select);
  $statement_select->execute();
  $result = $statement_select->fetch(PDO::FETCH_ASSOC)
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/details.css">
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
      <h1 class="title">Here Is your Details About Your task <i class="fa-regular fa-image"></i></h1>
    </div>
    <!-- start show details section -->
    <div class="container">
      <div class="details">
        <p class='task'><?php echo $result['task']; ?></p>
        <div class="box">
          <img src="<?php echo "upload/".$result['filename_db']; ?>" alt="">
          <p class="description"><?php echo $result['description_db']; ?></p>
        </div>
      </div>
    </div>
    <!-- end show details section -->
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
