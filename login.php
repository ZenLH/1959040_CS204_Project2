<?php
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/account.php';
?>

<div class="jumbotron jumbotron-fluid">
    <div class="display-4" style="text-align: center;">Login</div>
</div>
<div class="container mt-3">
   <?php if (isset($errMsg)): ?>
     <div class="alert alert-danger" role="alert">
       <?php echo $errorMsg; ?>
     </div>
   <?php endif; ?>
    <p style="text-align: center;">Have you <a href="signup.php">Signed up</a> yet?</p>
</div>
<div class="container">
    <div class="col-md-6 offset-md-3">
        <form action="login.php" method="post">
            <!-- Update username or email -->
            <label for="username">Username</label>
            <input type="text" name="name" value="<?php if(isset($username)) {echo htmlspecialchars($username);}?>" class="form-control" placeholder="Username..." id="">
            <?php if(isset($errors['login_username'])) {echo "<p class='alert alert-danger'>". $errors['login_username']."</p>";} ?>
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="pass" value="" class="form-control" placeholder="Input your password..." id="">
            <?php if(isset($errors['login_password'])) {echo "<p class='alert alert-danger'>". $errors['login_password']."</p>";} ?>
            <!-- Update image upload -->
            <button type="submit" name="login" class="btn btn-outline-primary btn-block">Login</button>
        </form>
    </div>
</div>

<?php
    include 'includes/footer.php';
?>