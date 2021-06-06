<?php
//include 'config.php';
include 'commentmanager.php';

session_start();
include '../db.php';
if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}

if(isset($_POST['comment'])) {
  $post_id = $_POST['post_id'];
  $user_id = $_SESSION['user_id'];
  $comment_text = $_POST['comment'];
  //echo $post_id.$user_id.$comment_text;
  $comment = createComment($conn, $post_id, $comment_text, $user_id);
  //echo $comment;
  echo json_encode($comment);
}

if(isset($_POST['delete-comment'])) {
  $comment_id = $_POST['comment_id'];
  deleteComment($conn, $comment_id);
}


 ?>
