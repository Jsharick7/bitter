

<?php include ("templates/header.php"); ?>
<div id="signupform">
<form action="includes/signup.inc.php" method="post">
  <h2>Sign Up</h2>
  <label>First Name:</label><input class="form-control" type="text" name="newFirstName">
  <label>Username:</label><input class="form-control" type="text" name="newUsername">
  <label>Choose Password:</label><input class="form-control" type="password" name="newPassword">
  <label>Email Address:</label><input class="form-control" type="email" name="email">
  <input style="margin-top:10px; margin-left:auto;" class="btn btn-lg btn-primary" type="submit" name="signUp" value="Sign Up">
</form>
</div>
<?php include ("templates/footer.php"); ?>
