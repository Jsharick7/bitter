<?php
session_start();
 ?>

  <!doctype html>
  <html lang="en" class="h-100">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Bitter, a social media platform built with PHP.">
      <title>Bitter</title>
      <link rel="icon" href="favicon-16x16.png">

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

      <!-- My styles -->
      <link rel="stylesheet" href="styles.css">


    </head>


      <header>
    <!-- Fixed navbar (fixed-top cut from next line temp) -->
    <nav class="navbar navbar-expand-md navbar-light bg-info">
      <a id="navBrand" class="navbar-brand ml-5" href="user.php">Bitter</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active ml-5">
            <a class="nav-link" href="user.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <?php error_reporting(0);
          if($_SESSION['user']){?>
            <li class="nav-item active ml-5">
              <form style="height:100%;" action="includes/logout.inc.php" method="post">
                <input style="margin-top:1px;" class="btn" type="submit" name="logout" value="Log Out">
              </form>
            </li>
        <?php }?>
        </ul>

      </div>
    </nav>
  </header>
    <body>
