<?php
//include 'postmanager.php';

if(isset($_GET['delete-id'])) {
  session_start();
  include '../db.php';
  if(!isset($_SESSION['loggedin'])){
    $_SESSION['loggedin'] = false;
}
  deleteComment($conn,$_GET['delete-id']);
}


if(isset($_POST['comment'])) {
  $errors = [];
  //include_once 'config.php';
  //echo $_SESSION;
  if(!isset($_SESSION['user_id'])) {
    $errors['userid'] = "User id not set";
  }
  if(!isset($_POST['id'])) {
    $errors['postid'] = "post id not set";
  } else {
    $queryIDCount = 3;
    $queryStrPos = strpos($_SESSION['query_history'][$queryIDCount],"id");
    $queryId = substr($_SESSION['query_history'][$queryIDCount],$queryStrPos);
    $queryId = explode("=", $queryId);
    if($queryId[1] != $_POST['id']) {
      $errors['queryid'] = "query id doesnt equal post id";
    }
  }
  //var_dump($errors);
  if(empty($errors)) {
    //createComment($conn, $_POST['id'], $_POST['comment'], $_SESSION['user_id']);
  }

}

function createComment($conn, $postid, $text, $userid){
  //echo $postid.$text.$userid;
  $sql = "INSERT INTO comments (comment, comment_author, comment_post) VALUE (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sii", $text, $userid, $postid);
  $stmt->execute();
  if($stmt->affected_rows == 1) {
    $id = $stmt->insert_id;
    $sql = "SELECT u.user_ava, cm.ID, cm.comment, u.user_name, cm.date_modified FROM comments cm JOIN users u ON u.ID = cm.comment_author WHERE cm.ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result;
  }
}

function getComment($commentid, $conn) {
  $sql = "SELECT cm.comment_post, u.user_ava, cm.ID, cm.comment, u.user_name, u.ID as user_id, cm.date_modified FROM comments cm JOIN users u ON u.ID = cm.comment_author JOIN posts ON posts.ID = cm.comment_post WHERE cm.ID=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $commentid);
  $stmt->execute();
  $results = $stmt->get_result();
  return $results->fetch_assoc();
}


function getComments($postid, $conn) {
  $sql = "SELECT u.user_ava, cm.ID, cm.comment, u.user_name, u.ID as user_id, cm.date_modified FROM comments cm JOIN users u ON u.ID = cm.comment_author JOIN posts ON posts.ID = cm.comment_post WHERE posts.ID = ? ORDER BY date_modified DESC";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $postid);
  $stmt->execute();
  $results = $stmt->get_result();
  return $results->fetch_all(MYSQLI_ASSOC);
}


function outputComments($conn, $comments) {
  //var_dump($comments);
  foreach ($comments as $comment) {
    $commentBox =
    "<div class='card'>
      <div class='card-body'>
        <div class='row'>
            <div class='col-md-2'>
                <img src=".$comment['user_ava']." class='img img-rounded img-fluid'/>
            </div>
            <div class='col-md-10'>
                    <h5 class='float-left'><strong>".$comment['user_name']."</strong></h5>
                    <p class='float-right'>".$comment['date_modified']."</p>
               <div class='clearfix'></div>
                <p>".$comment['comment']."</p>";
    $author_edit =
    "<p>
        <a href='' class='edit-comment float-right btn btn-outline-warning ml-2'> <i class='fa fa-edit'></i> Edit</a>
        <a href='function/commentmanager.php?delete-id={$comment['ID']}' class='delete-comment float-right btn text-white btn-danger'> <i class='fa fa-trash'></i> Delete</a>
    </p>
      </div>
    </div>
  </div>
  </div>";

    $admin_edit =
    "<p>
      <a href='function/commentmanager.php?delete-id={$comment['ID']}' class='delete-comment float-right btn text-white btn-danger' id=".$comment['ID']."> <i class='fa fa-trash'></i> Delete</a>
    </p>
  </div>
  </div>
</div>
</div>";
    $viewer =
    "</div>
    </div>
  </div>
  </div>";

  if($_SESSION['loggedin'] == false){
    $commentBox.=$viewer;
  }
  elseif($_SESSION['user_id'] == $comment['user_id']){
    $commentBox.=$author_edit;
  }
  elseif($_SESSION['user_role'] == 1){
    $commentBox.=$admin_edit;
  }
  else{
    $commentBox.=$viewer;
  }
  echo $commentBox;
  }
}


function deleteComment($conn, $id) {
  $postid = getComment($id, $conn)['comment_post'];
  $sql = "DELETE FROM comments WHERE ID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  if($stmt->affected_rows == 1) {
    $location = "Location: ../post.php?id={$postid}";
    header($location);
}
}

function editComment($conn, $id){

}
 ?>
