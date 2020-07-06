
<?php include ("templates/header.php"); ?>

<div id="signin" class="container-fluid">
  <div class="row no-gutter">
    <div id="login-image" class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login sign-in d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h1>Welcome to Bitter!</h1>
              <h3>Make friends, drink coffee, be bitter.</h3>
              <h5>Sign in and rant to your friends today!</h5>

                <form class="form-signin" action="includes/login.inc.php" method="POST">
                  <img class="mb-4" src="chocolate.svg" alt="Logo" width="72" height="72">
                  <h1>Login</h1>
                  <label for="inputUsername" class="sr-only">Username:</label><input type="text" name="username" id="inputUsername" class="form-control" placeholder="User Name" required autofocus>
                  <label for="inputPassword" class="sr-only">Password:</label><input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login">Sign In</button>
                </form>
                <p id="or">or</p>
                <form class="" action="signup.php" method="POST">
                  <button class="create-account btn btn-lg btn-outline-info btn-block" type="submit" name="signUp" value="Create An Account">Create An Account</button>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ("templates/footer.php"); ?>
</html>
