<?php
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/postmanager.php';
    include 'function/filemanager.php';

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $post = getPost($id, $conn);
        //var_dump($post);
    }
    $errors = [];
    if(isset($_POST['edit'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        // check post doesnt return true or false
        // it updates the $errors[] if  there is an error
        checkPost($title, $body, $errors);
        // check file returns false if there is an error or
        // the new image path if successful
        // it also updates the $errors[] if  there is an error
        //var_dump($_FILES);
        $img_path = checkFile($_FILES, "image", $errors);
        if($img_path == false){
            $img_path= $post['post_img'];
        }
        //var_dump($errors); var_dump($img_path);
        // create the post if there are no $errors
    if(empty($errors) && $img_path != false) {
      editPost($id, $title, $body, $img_path, $conn);
  }
}
?>

<div class="container">

  <div class="row">
    <?php if ($_SESSION['loggedin'] == false): ?>
      <div class="mt-5 col-md-6 offset-md-3 text-center">
        <h2 class="display-5">Wanna Join Us?</h2>
        <p>Create an account or login to post to the website.</p>
        <button type="button" class="btn btn-block btn-outline-primary"><a href="login.php"><i class="fas fa-sign-in-alt"></i>Join Us!</a> </button>
      </div>
    <?php else: ?>
      <div class="mt-3 col-md-6 offset-md-3">
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
            <?php //var_dump($errors); ?>
          </div>
        <?php endif; ?>
        <h2>Edit the Post</h2>
        <form class="" action="editpost.php?id=<?php echo $post['ID'];?>&edit=true" method="post" enctype="multipart/form-data">
          <label for="title">Post Title</label>
          <input type="text" name="title" value="<?php echo $post['post_title'] ?>" class="form-control">
          <label for="body">Post Content</label>
          <textarea name="body" class="form-control" rows="8" cols="80" value=""><?php echo $post['post_body'];?></textarea>
          <!-- img preview -->
          <div class="container image offset-md-3" style=>
            <img style="height: 15rem" src="<?php echo $post['post_img'];?>" alt="">
          </div>
          
          <label for="image">Chose another image</label>
          <input type="file" name="image" class="form-control mt-1 mb-1" value="">
          <button type="submit" name="edit" class="btn btn-outline-warning btn-block"> <i class="fas fa-edit"></i>Edit</button>
          <button type="submit" name="cancel" class="btn btn-outline-dark btn-block"><a href="post.php?id=<?php if(isset($id)) {echo $id;}?>">Cancel</button>
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