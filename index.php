<?php
    
    include 'function/account.php';
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/postmanager.php';

    $posts = getPosts(20, $conn);
    //var_dump($posts);
?>

<div class="container">
    <!-- tag -->
    <br>
    <?php outputPosts($conn, $posts); ?>
</div>

<?php
    include 'includes/footer.php';
?>