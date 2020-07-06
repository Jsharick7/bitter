
<?php
session_start();
require("../config/db_connect.php");

if(isset($conn)){

  $post_Body = $_POST['postBody'];
  $author = $_SESSION['user'];
  echo $post_Body;
  echo $author;
  print_r($conn);

  $sql = "INSERT INTO posts (post_body, author) VALUES (?, ?);";
  $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../user.php?error=posterror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ss", $post_Body, $author);
      mysqli_stmt_execute($stmt);
      $_SESSION['recentPost'] = $post_Body;
      header("Location: ../user.php?post=success");
      exit();
    }
}
else{
  header("Location: ../index.php");
  exit();
}

 ?>
