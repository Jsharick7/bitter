<?php
if (array_key_exists("deleteComment",$_GET)){
  deleteComment();
  }
function deleteComment(){
  $comment_id = $_GET['deleteComment'];
  require("config/db_connect.php");
  $sql = "DELETE FROM comments WHERE comment_id=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: user.php?err=deletecommenterror");
    }
    else{
      mysqli_stmt_bind_param($stmt,"i",$comment_id);
      mysqli_stmt_execute($stmt);
      header("Location: user.php?delete=success");
    }
    mysqli_close($conn);
}
if (array_key_exists("deletePost",$_GET)){
  deletePost();
  }
function deletePost(){
  $post_id = $_GET['deletePost'];
  require("config/db_connect.php");
  $sql = "DELETE FROM posts WHERE post_id=?";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
      header("Location: user.php?err=deleteposterror");
    }
    else{
      mysqli_stmt_bind_param($stmt,"i",$post_id);
      mysqli_stmt_execute($stmt);
      header("Location: user.php?err=deletepostsuccess");
    }
    mysqli_close($conn);
}
 ?>
