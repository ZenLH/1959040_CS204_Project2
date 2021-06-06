<?php
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/postmanager.php';
    include 'function/filemanager.php';

$errors = [];
if(isset($_POST['submit'])) {
  $title = $_POST['title'];
  $body = htmlspecialchars($_POST['body']);
  // check post doesnt return true or false
  // it updates the $errors[] if  there is an error
  checkPost($title, $body, $errors);
  // check file returns false if there is an error or
  // the new image path if successful
  // it also updates the $errors[] if  there is an error
  $img_path = checkFile($_FILES, "image", $errors);

  // create the post if there are no $errors
  if(empty($errors) && $img_path != false) {
      // create the post
      createPost($title, $body, $img_path, $conn);
  }
}
?>

<div class="container">

  <div class="row">
    <?php if ($_SESSION['loggedin'] == false): ?>
      <div class="mt-5 col-md-6 offset-md-3 text-center">
        <h2 class="display-5">Please Login to Post!</h2>
        <p>Create an account or login to post to the website.</p>
        <button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i> Create Account/Login</a> </button>
      </div>
    <?php else: ?>
      <div class="mt-3 col-md-6 offset-md-3">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
            <?php //var_dump($errors); ?>
          </div>
        <?php endif; ?>
        <h2>Create a post</h2>
        <form class="" action="newpost.php" method="post" enctype="multipart/form-data">
          <label for="title">Post Title</label>
          <input type="text" name="title" placeholder="Post title..." value="" class="form-control">
          <label for="body">Post Content</label>
          <textarea name="body" class="form-control" rows="8" cols="80"></textarea>
          <input type="file" name="image" class="form-control mt-1 mb-1" value="">
          <button type="submit" name="submit" class="btn btn-outline-dark btn-block"> <i class="fas fa-edit"></i> Create Post</button>
        </form>
      </div>
      <?php
        //var_dump($errors);
        //var_dump($img_path);
       ?>
    <?php endif; ?>
  </div>
</div>


<?php
    include 'includes/footer.php';
?>