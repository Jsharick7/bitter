<!-- ADD FRIEND FUNCTIONALITY -->

  <?php
  function addFriend($friendBeingAdded){
    $newFriendArray = array_push($exploded,$friendBeingAdded);
    $newFriendBlob = implode(",",$newFriendArray);
    $sql = "UPDATE users SET friends=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "DOESNT WORK";
      }
      else{
        mysqli_stmt_bind_param($stmt,"bs",$newFriendBlob,$user);
        mysqli_stmt_execute($stmt);
  }
  if (array_key_exists('addFriendButton', $_POST)){
    addFriend($GLOBALS['currentPotentialFriend']);
  }
   ?>
