<?php
 //QUERY FOR COMMENTS PER OTHERS' POSTS//
require("config/db_connect.php");
  $comment_id = $_SESSION['post_id'];
  $sql = "SELECT * FROM comments WHERE post_parent_id =? ORDER BY comment_date ASC";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Comment Retrieval Error";
    }
    else{
      mysqli_stmt_bind_param($stmt,"i",$comment_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $_SESSION['commentsForOnePost'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    mysqli_close($conn);
?>
