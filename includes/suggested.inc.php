<h2>Follow Others:</h2>
  <div class="normalpad panel panel-white post panel-shadow">
    <form class="addFriend">


  <?php
  require("config/db_connect.php");
  error_reporting(0);
  $matchString = "('" . implode("','",$GLOBALS['exploded']) . "','$user')";
  $user = $_SESSION['user'];
  $sql = "SELECT user_id, image
  FROM users
  WHERE NOT user_id='$user' AND user_id NOT IN $matchString";
  $result = mysqli_query($conn, $sql);

  $friendsToAdd = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_close($conn);
  global $count;
  $count = 0;
  foreach($friendsToAdd as $potentialFriend){

      if($count<5){

        echo '<p style="margin-bottom:20px"><img class="img-circle avatar" alt="user profile image" src="data:image/png;base64,'.base64_encode( $potentialFriend['image'] ).'"/>';
      $currentPotentialFriend = $potentialFriend['user_id'];
      echo $currentPotentialFriend;
      ?>
      <a href="user.php?addid=<?php echo $currentPotentialFriend ?>">Follow</a></p><br>
      <?php
      $count++;
      }
    }
   ?>

</form>
</div>
