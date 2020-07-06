<?php

require("../config/db_connect.php");

if (isset($_POST['login'])) {
  $user_id = $_POST['username'];
  $password = $_POST['password'];

  if (empty($user_id) || empty($password)) {
    header("Location: ../index.php?error=emptyfields");
    exit();
  }
  else{
    $sql = "SELECT * FROM users WHERE user_id=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $user_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if($row = mysqli_fetch_assoc($result)){

        $pwdCheck = password_verify($password, $row['password']);

        if($pwdCheck == false){
          header("Location: ../index.php?error=wrongpassword");
          exit();
        }
        elseif($pwdCheck == true){
          session_start();
          $_SESSION['user'] = $row['user_id'];
          $_SESSION['user_fName'] = $row['fName'];
          header("Location: ../user.php");
          exit();
        }
        else{
          header("Location: ../index.php?error=wrongpassword");
          exit();
        }
      }
      else{
        header("Location: ../index.php?error=nouser");
        exit();
      }

    }
  }

}
else{
  header("Location: ../index.php?error=incorrectpassword");
  exit();
}
?>
