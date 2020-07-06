<?php
//  HANDLE PICTURE SUBMISSION
if (isset($_POST['submitImg'])){
  session_start();
  require("../config/db_connect.php");
  $user = $_SESSION['user'];
  $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
  mysqli_query($conn, "UPDATE users SET image = ('$image') WHERE user_id=('$user')");
  echo "query attempted";
  header("Location: ../user.php");
  }
?>
<?php
//  ADD DEFAULT PICTURES TO MISSING USER IMAGES
// if (isset($_POST['submitImg'])){
//   session_start();
//   require("../config/db_connect.php");
//   $user = $_SESSION['user'];
//   $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
//   mysqli_query($conn, "UPDATE users SET image = ('$image') WHERE image=('')");
//   echo "query attempted";
//   header("Location: ../user.php");
//   }
?>
