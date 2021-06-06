<?php
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/account.php';
    //var_dump($errors);
    //var_dump($conn);
?>

<div class="jumbotron jumbotron-fluid">
    <div class="display-4" style="text-align: center;">Sign up</div>
</div>
<div class="container mt-3">
   <?php if (isset($errMsg)): ?>
     <div class="alert alert-danger" role="alert">
       <?php echo $errMsg; ?>
     </div>
   <?php endif; ?>
</div>
<div class="container">
    <div class="col-md-6 offset-md-3">
        <form action="signup.php" method="post">
            <!-- Update username or email -->
            <label for="username">Username</label>
            <input type="text" name="name" value="<?php if(isset($username)) {echo htmlspecialchars($username);}?>" class="form-control" placeholder="Username..." id="">
            <?php if(isset($errors['signup_username'])) {echo "<p class='alert alert-danger'>".$errors['signup_username']."</p>";} ?>
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php if(isset($email)) {echo htmlspecialchars($email);}?>" class="form-control" placeholder="Youremail@..." id="">
            <?php if(isset($errors['signup_email'])) {echo "<p class='alert alert-danger'>".$errors['signup_email']."</p>";} ?>
            <!-- -->
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="pass" value="" class="form-control" placeholder="Input your password..." id="">
            <?php if(isset($errors['signup_pass'])) {echo "<p class='alert alert-danger'>".$errors['signup_pass']."</p>";} ?>
            <!-- Confirm password -->
            <label for="password">Password</label>
            <input type="password" name="pass1" value="" class="form-control" placeholder="Confirm your password..." id="">
            <?php if(isset($errors['signup_pass1'])) {echo "<p class='alert alert-danger'>".$errors['signup_pass1']."</p>";} ?>
            <!-- Update image upload -->
            <button type="submit" name="signup" class="btn btn-outline-primary btn-block">Sign up</button>
        </form>
    </div>
</div>

<?php
    include 'includes/footer.php';
?>