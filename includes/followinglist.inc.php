<h2>People You Follow:</h2>

<?php
  require("config/db_connect.php");
  $matchString = "('" . implode("','",$GLOBALS['exploded']) . "')";
    $sql = "SELECT user_id, image
    FROM users
    WHERE user_id IN $matchString";

    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
  ?>

<div class="normalpad panel panel-white post panel-shadow">
<?php foreach($users as $user){ ?>
    <p style="margin-bottom:20px"><?php
    echo '<img class="img-circle avatar" alt="user profile image" src="data:image/png;base64,'.base64_encode( $user['image'] ).'"/>';
    $userToRemove = $user['user_id'];
    echo $userToRemove;
     ?>
     <a href="user.php?removeid=<?php echo $userToRemove ?>">Unfollow</a>
     </p>

<?php } ?>
</div>
