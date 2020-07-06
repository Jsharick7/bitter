


<?php

  require("../config/db_connect.php");

if(isset($_POST['signUp'])){
    $fName = $_POST['newFirstName'];
    $username = $_POST['newUsername'];
    $password = $_POST['newPassword'];
    $email = $_POST['email'];

    if(empty($fName) || empty($username) || empty($email) || empty($password)) {
       header("Location: ../signup.php?error=emptyfields&newUsername=".$username."&email=".$email."&newFirstName=".$fName);
       exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: ../signup.php?error=invalidmailuid=");
      exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      header("Location: ../signup.php?error=invalidmail&newUsername=".$username);
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
      header("Location: ../signup.php?error=invaliduid&email=".$email);
      exit();
    }
    else{
      $sql = "SELECT user_id FROM users WHERE user_id=?;";
      $stmt = mysqli_stmt_init($conn);


        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else{
          mysqli_stmt_bind_param($stmt, "s", $username);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);
          if($resultCheck > 0){
            header("Location: ../signup.php?error=usertaken&email=".$email);
            exit();
          }
          else{
          $sql = "INSERT INTO users (user_id, fName, password, email) VALUES (?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
              header("Location: ../signup.php?error=sqlerror");
              exit();
            }
            else{
              $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

              mysqli_stmt_bind_param($stmt, "ssss", $username, $fName, $hashedPassword, $email);
              mysqli_stmt_execute($stmt);
              header("Location: ../index.php?signup=success");
              exit();
            }
        }
    }
  }

    mysql_stmt_close($stmt);
    mysql_close($conn);

  }
  else{
    header("Location: ../signup.php");
    exit();
  }


?>
