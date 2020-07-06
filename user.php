<?php
error_reporting(0);
  session_start();
  $user = $_SESSION['user'];
  $user_fName = $_SESSION['user_fName'];
  //QUERY FOR FRIENDS ARRAY CALLED $EXPLODED//
  //REDIRECT IF NO USER LOGGED IN//
  if($_SESSION['user']===NULL){
    header("Location: index.php");
  }
  require("config/db_connect.php");
  $blobsql = 'SELECT friends FROM users WHERE user_id =?';
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$blobsql)){

    }
    else{
      mysqli_stmt_bind_param($stmt,"s",$_SESSION['user']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_row($result);
    }

  $blobResult = mysqli_query($conn, $blobsql);
  /* Exploded is global array of people user follows */
  global $exploded;
  $exploded = explode(",",$row[0]);
  mysqli_close($conn);
?>

<?php
//QUERY FOR LIKES ARRAY//
require("config/db_connect.php");
$sql = 'SELECT likes FROM users WHERE user_id =?';
$stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt,$sql)){

  }
  else{
    mysqli_stmt_bind_param($stmt,"s",$_SESSION['user']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_row($result);
  }
/* Likes is global array of pose IDs user has liked */
global $likes;
$likes = explode(",",$row[0]);
mysqli_close($conn);
?>

<?php
//QUERY FOR POST DATA OF CURRENT USER//
  require("config/db_connect.php");
    $sql = "SELECT post_body, author, date_created, post_id
    FROM posts
    WHERE author=('$user')
    ORDER BY date_created
    DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);
    $_SESSION['userPosts'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
?>

<?php
  //QUERY FOR OTHER USERS POSTS WHO USER FOLLOWS (i.e. from exploded array)//
    require("config/db_connect.php");
    $matchString = "('" . implode("','",$exploded) . "')";
    $sql = "SELECT post_body, author, date_created, post_id
    FROM posts
    WHERE author IN " . $matchString . "
    ORDER BY date_created
    DESC LIMIT 8";
    $result = mysqli_query($conn, $sql);
    $_SESSION['othersPosts'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($conn);
?>

<?php
//INSERT COMMENT TO DATABASE AND REDIRECT//
if(isset($_GET['commentContent'])){
  $postParent = (int)$_GET['parent'];
  $comment = htmlspecialchars($_GET['commentContent']);
  $author = $_SESSION['user'];

  $conn = mysqli_connect('localhost','joe','sterence18','db_bitter');
  $sql = "INSERT INTO comments (comment_body, comment_author, post_parent_id) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: user.php?error=commentfail");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "ssi", $comment, $author, $postParent);
      mysqli_stmt_execute($stmt);
      $_SESSION['recentComment'] = $comment;
      header("Location: user.php?comment=success#'$comment'");
      exit();
    }
    mysqli_close($conn);
}
 ?>
 <?php
  //QUERY FOR COMMENTS PER USER POST//
//  require("config/db_connect.php");
//    $comment_id = (int)$otherPostIndexHolder['post_id'];
//    $sql = "SELECT * FROM comments WHERE post_parent_id =? ORDER BY comment_date ASC";
//    $stmt = mysqli_stmt_init($conn);
//      if(!mysqli_stmt_prepare($stmt,$sql)){
//          echo "Comment Retrieval Error";
//      }
//      else{
//        mysqli_stmt_bind_param($stmt,"i",$comment_id);
//        mysqli_stmt_execute($stmt);
//        $result = mysqli_stmt_get_result($stmt);
//        $_SESSION['userPostComments'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
//      }
//      mysqli_close($conn);
// ?>



<?php require("includes/delete.inc.php"); ?>
<!-- FOLLOW/UNFOLLOW FUNCTIONALITY -->
<?php require('includes/managefollowing.inc.php'); ?>

<?php require("templates/header.php"); ?>
<!--main container-->
<section>
<div id="main-container" class="container">
  <div id="only-row" class="row">
    <div id="first-col" class="col-lg-6">
<!--YOUR FEED -->
<div id="welcome" class="normalpad panel panel-white panel-shadow">
      <div class="welcomeBack">
        <div class="welcomePic">
            <?php require("includes/getpostimage.inc.php");?>
        </div>
        <h1>Welcome, <?php
        echo $user_fName."!";
        ?></h1>
    </div>
      <div class="pictureupload">
        <p>Update your profile picture</p>
        <form class="" action="includes/submitimage.inc.php" method="post" enctype="multipart/form-data">
          <input type="file" name="image">
          <input type="submit" name="submitImg" value="Upload">
        </form>
      </div>
  <!-- COMPOSE A POST -->

        <h1>Say Something!</h1>
        <h3>The internet <em>REALLY</em> needs your opinion!</h3>
        <form action="includes/compose.inc.php" method="post">
          <textarea class="postTextArea" type="text" name="postBody"></textarea>
          <input class="btn btn-primary" type="submit" name="submitPost" value="Post">
        </form>
  </div>

<!-- DISPLAY RECENT POSTS FROM YOUR FRIENDS -->
      <h2>Here's what others are saying:</h2>

        <div id="friend-post" class="container bootstrap snippet">
<?php
    $postNum = 0;
    foreach($_SESSION['othersPosts'] as $oPost){
      global $otherPostIndexHolder;
    $otherPostIndexHolder[$postNum] = $oPost['post_id'];
    $postNum++;
    $_SESSION['post_id'] = $oPost['post_id'];
    $_SESSION['oPostAuthor'] = $oPost['author']?>


            <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                    <div class="pull-left image">
                        <?php require("includes/getcommentimage.inc.php"); ?>
                    </div>
                    <div class="pull-left meta">
                        <div class="title h5">
                            <a href='otheruser.php?visit=<?php echo $oPost['author']?>'><b><?php echo $oPost['author'] ?></b></a>
                            said:
                        </div>
                        <h6 class="text-muted time"><?php echo "on ".$oPost['date_created'];?></h6>
                    </div>
                </div>
                <div class="post-description">
                    <p><?php echo htmlspecialchars($oPost['post_body']);?></p>
                    <div class="stats">
                        <a href="" class="btn btn-default stat-item">
                            <i class="fa fa-thumbs-up icon"></i>2
                        </a>
                        <a href="#" class="btn btn-default stat-item">
                            <i class="fa fa-share icon"></i>12
                        </a>
                    </div>
                </div>
                <div class="post-footer">
                  <form class="input-group" action="user.php" method="get">
                    <input class="form-control" placeholder="Add a comment" name="commentContent" autocomplete="off">
                    <input type="hidden" name="parent" value="<?php echo $oPost['post_id']; ?>">
                    <input class="btn btn-primary" type="submit" value="Reply" name="submitComment">
                  </form>
                </div>

            <!-- COMMENTS ON OTHER USER POSTS -->
      <?php
        require("includes/commentsperpost.inc.php");
      foreach($_SESSION['commentsForOnePost'] as $oComment){
        $_SESSION['oCommentAuthor'] = $oComment['comment_author']?>

          <ul class="comments-list">
            <li class="comment">
                <a class="pull-left" href="#">
                    <?php require("includes/getreplycommentimg.inc.php"); ?>
                </a>
                <div class="comment-body">
                    <div class="comment-heading">
                        <h4 class="user"><?php echo $oComment['comment_author'];?></h4>
                        <h5 class="time"><?php echo "on " .$oComment['comment_date']; ?></h5>
                    </div>
                    <p><?php echo $oComment['comment_body']; ?></p>

                      <?php
                        //DELETE COMMENT FUNCTIONALITY//copy these 2 lines when user only recent feed is up!!
                        if($oComment['comment_author']===$_SESSION['user']){ ?>
                        <a onclick="return confirm('Are you sure you want to permanently delete this message?')" href="user.php?deleteComment=<?php echo $oComment['comment_id']; ?>">Delete</a>
                        <?php  } ?>
                  </div>
              </li>
          </ul>
        <?php } ?>

            </div>
        <?php } ?>
    </div>
  </div>

<div id="yourBits" class="col-lg-6">

<h2>Your recent bits:</h2>
<?php foreach($_SESSION['userPosts'] as $userPost){ ?>
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

<div class="container bootstrap snippet">
    <div class="">
        <div class="panel panel-white post panel-shadow">

            <div class="post-heading">
                <div class="pull-left image">
                  <?php require("includes/getpostimage.inc.php"); ?>
                </div>
                <div class="pull-left meta">
                    <div class="title h5">
                        <a href="#"><b>You</b></a>
                        posted:
                    </div>
                    <h6 class="text-muted time"><?php echo "on ".$userPost['date_created']; ?></h6>
                </div>
            </div>
            <div class="post-description">
                <p><?php echo htmlspecialchars($userPost['post_body']);?></p>
                <div class="stats">
                    <a href="#" class="btn btn-default stat-item">
                        <i class="fa fa-thumbs-up icon"></i>2
                    </a>
                    <a onclick="return confirm('Permanently delete this bit?')" href="user.php?deletePost=<?php echo $userPost['post_id']; ?>"> Delete</a>
                </div>
            </div>

            <div class="post-footer">
              <form class="input-group" action="user.php" method="get">
                <input class="form-control" placeholder="Add a comment" name="commentContent" autocomplete="off">
                <input type="hidden" name="parent" value="<?php echo $userPost['post_id']; ?>">
                <input class="btn btn-primary" type="submit" value="Reply" name="submitComment">
              </form>
            </div>

            <?php
            $_SESSION['post_id'] = $userPost['post_id'];
              require("includes/commentsperpost.inc.php");

            foreach($_SESSION['commentsForOnePost'] as $oComment){
              $_SESSION['oCommentAuthor'] = $oComment['comment_author']?>

                <ul class="comments-list">
                  <li class="comment">
                      <a class="pull-left" href="#">
                          <?php require("includes/getreplycommentimg.inc.php"); ?>
                      </a>
                      <div class="comment-body">
                          <div class="comment-heading">
                              <h4 class="user"><?php echo $oComment['comment_author'];?></h4>
                              <h5 class="time"><?php echo "on " .$oComment['comment_date']; ?></h5>
                          </div>
                          <p><?php echo $oComment['comment_body']; ?></p>

                            <?php
                              //DELETE COMMENT FUNCTIONALITY//copy these 2 lines when user only recent feed is up!!
                              if($oComment['comment_author']===$_SESSION['user']){ ?>
                              <a onclick="return confirm('Are you sure you want to permanently delete this message?')" href="user.php?deleteComment=<?php echo $oComment['comment_id']; ?>">Delete</a>
                              <?php  } ?>
                        </div>
                    </li>
                </ul>
              <?php } ?>




        </div>
    </div>
</div>
<?php } ?>


        <div>
        <!-- PEOPLE YOU FOLLOW -->
          <?php require("includes/followinglist.inc.php"); ?>
        <!-- SUGGEST FRIENDS -->
        <?php require("includes/suggested.inc.php"); ?>
      </div>

    </div>
  </div>
</div>

</section>

<?php require("templates/footer.php"); ?>
