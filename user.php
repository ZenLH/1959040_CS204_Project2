<?php
    
    include 'function/account.php';
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/postmanager.php';

    $posts = getUserPosts($conn,$_SESSION['user_id']);

    //var_dump($_SESSION);
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="display-4 text-center">My Info</div>
            <div class="container text-center">
                <img src="<?php echo $_SESSION['user_ava']; ?>" style="height: 25vh;" alt="">
            </div>
            
            <h5>Username:   <?php echo $_SESSION['user_name'];?></h5>
            <h5>Email:      <?php echo $_SESSION['user_email'];?></h5>
            <div class="container">
                <a href="" class="btn btn-warning btn-block"><i class="fas fa-edit"></i>Edit</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="display-4 text-center">My posts</div>
            <div class="container">
    <!-- tag -->
            <?php outputPosts($conn, $posts); ?>
            </div>
        </div>
    </div>
</div>



<?php
    include 'includes/footer.php';
?>