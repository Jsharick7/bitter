<?php
  //QUERY FOR IMAGES FROM USER AND THEIR FOLLOWS//
  require("config/db_connect.php");
  $author = $_SESSION['oCommentAuthor'];
  $sql= "SELECT * FROM users WHERE user_id=('$author')";
  $res = mysqli_query($conn, $sql);
  $row=mysqli_fetch_array($res);

  echo '<img class="img-circle avatar" alt="user profile image" src="data:image/png;base64,'.base64_encode( $row['image'] ).'"/>';
   mysqli_close($conn);
 ?>
