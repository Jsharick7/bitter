
<?php
  error_reporting(0);
  session_start();
  $author = $_GET['visit'];
  require("config/db_connect.php");
    $sql = "SELECT *
    FROM posts
    WHERE author=('$author')
    ORDER BY date_created
    DESC LIMIT 7";
    $result = mysqli_query($conn, $sql);
    $_SESSION['visitPostData'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['visitAuthor'] = $_GET['visit'];
    mysqli_close($conn);
?>

<?php require("templates/header.php"); ?>

<section>
  <div id="main-container" class="container">
    <div id="only-row" class="row">
      <div id="yourBits" class="col-lg-6">

  <h2><?php echo $_GET['visit']; ?>'s recent bits:</h2>
  <?php foreach($_SESSION['visitPostData'] as $userPost){ ?>
  <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

  <div class="container bootstrap snippet">
      <div class="">
          <div class="panel panel-white post panel-shadow">

              <div class="post-heading">
                  <div class="pull-left image">
                    <?php require("includes/getvisitpostimg.inc.php"); ?>
                  </div>
                  <div class="pull-left meta">
                      <div class="title h5">
                          <a href="#"><b><?php echo $_GET['visit']; ?></b></a>
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

</div>
</div>



</section>

  <?php require("templates/footer.php"); ?>
