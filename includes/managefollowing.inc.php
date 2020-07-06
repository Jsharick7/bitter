
  <?php

  if (array_key_exists("addid", $_GET)){
    follow();
  }
  if (array_key_exists("removeid",$_GET)){
    unfollow();
  }

  function follow(){
    require("config/db_connect.php");

    $friendBeingAdded = htmlspecialchars($_GET['addid']);
    array_push($GLOBALS['exploded'],$friendBeingAdded);
    $newFriendBlob = implode(",",$GLOBALS['exploded']);
    $conn = mysqli_connect('localhost','joe','sterence18','db_bitter');
    $sql = "UPDATE users SET friends=? WHERE user_id=?";
    $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "DOESNT WORK";
      }
      else{
        mysqli_stmt_bind_param($stmt,"ss",$newFriendBlob,$_SESSION['user']);
        mysqli_stmt_execute($stmt);

      }
      mysqli_close($conn);
    }
    function unfollow(){
      require("config/db_connect.php");

      $personToUnfollow = htmlspecialchars($_GET['removeid']);
      $pos = array_search($personToUnfollow, $GLOBALS['exploded']);
      unset($GLOBALS['exploded'][$pos]);
      $newFollowString = implode(",",$GLOBALS['exploded']);

      $sql = "UPDATE users SET friends=? WHERE user_id=?";
      $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
          echo "UNFOLLOW SQL ERROR";
        }
        else{
          mysqli_stmt_bind_param($stmt,"ss",$newFollowString,$_SESSION['user']);
          mysqli_stmt_execute($stmt);
          
        }
        mysqli_close($conn);
      }

   ?>
