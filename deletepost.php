<?php
    include 'function/config.php';
    include 'function/postmanager.php';
    include 'includes/header.php';
    include 'function/commentmanager.php';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
if(isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $comments = getComments($id, $conn);
    foreach ($comments as $key => $comment) {
      deleteComment($conn, $comment['ID']);
    }
    deletePost($conn, $id);
}
?>
<div class="jumbotron align-content-center">
  <h1 class="display-4">Are you sure you want to delete?</h1>
  <form class="" action="deletepost.php" method="post">
    <button type="submit" name="delete" value="<?php if(isset($id)) {echo $id;} ?>" class="btn mr-5 float-left btn-outline-danger">Delete</button>
  </form>
  <button type="submit" name="cancel" class="btn float-left btn-outline-success"><a href="post.php?id=<?php if(isset($id)) {echo $id;}?>">Cancel</a></button>
</div>


 <?php include "includes/footer.php"; ?>