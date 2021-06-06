<?php
// check the post title and body; pass the errors array by reference
function checkPost($title, $body, &$errors) {
  // ensure the body and title are not empty
  if($title == '' || $body == '') {
  $errors['text'] = "You must fill in all fields!";
  }

}

function createPost($title, $body, $img_path, $conn) {
  $sql = "INSERT INTO posts (post_title, post_body, post_author, post_img) VALUES (?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssis", $title, $body, $_SESSION['user_id'], $img_path);
  
  $stmt->execute();
  var_dump($stmt);
  if($stmt->affected_rows == 1) {
    // redirect user to the post they created
    $location = "Location: post.php?id=" . $stmt->insert_id . "&created=true";
    header($location);
  }
}

function getPost($id, $conn) {
  $sql = "SELECT * FROM posts WHERE ID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows == 1) {
    return $result->fetch_assoc();
  } else {
    return false;
  }
}
function getUserPosts($conn, $userid) {
  $sql = "SELECT * FROM posts where post_author = ? ORDER BY date_modified DESC ";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $results = $stmt->get_result();
  return $results->fetch_all(MYSQLI_ASSOC);
}
// create these two functions and call them on the homepage
function getPosts($limit, $conn, $offset = 0) {
  $sql = "SELECT * FROM posts ORDER BY date_modified DESC LIMIT ?,?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $offset, $limit);
  $stmt->execute();
  $results = $stmt->get_result();
  return $results->fetch_all(MYSQLI_ASSOC);
}

function deletePost($conn, $id){
  $sql = "DELETE FROM posts WHERE ID = ?";
  $stmt = $conn->prepare($sql);
  var_dump($id);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  if($stmt->affected_rows == 1) {
    $location = "Location: index.php?delete=true";
    header($location);
  }
}

function getAuthorInfo($conn, $userID){
  $sql = "SELECT * FROM users WHERE ID = ?";
  $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    return $result;
}


function outputPosts($conn,$posts) {
  $key = 2;
  foreach ($posts as $key=>$post) {
    $detail = substr($post['post_body'],0,50);
    $author = getAuthorInfo($conn, $post['post_author']);
    $card =
    "<div class='col-md-4' style='padding: 1rem;'>
    <div class='card' >
        <div class='container' style='height: 15rem; overflow: hidden;'> 
            <img class='card-img-top' src=".$post['post_img']." alt='thumbnail'>
        </div>
        <div class='card-body'>
            <h5 class='card-title'>".$post['post_title']."</h5>
            <i>Author: ".$author['user_name']."</i>
            <p class='card-text'>".$detail."...</p>
            <a href='post.php?id=".$post['ID']."' class='btn btn-primary'>Read >></a>
        </div>
    </div>
    </div>";

    $row =
    "<div class='row'>";
    if($key%3 == 0){
        $card = "<div class='row'>".$card;
    }
    elseif($key%3==2){
        $card.="</div>";
    }
    echo $card;
}
if($key % 3 != 2){echo "</div>";}
}

function editPost($id, $title, $body, $img_path, $conn){
  //var_dump()
  $sql = "UPDATE posts SET post_title=?, post_body=?, date_modified=?, post_img=? WHERE ID = ?";
  date_default_timezone_get();
  $date_modified = date('Y-m-d H:i:s');
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $title, $body, $date_modified, $img_path, $id);
  $stmt->execute();
  if($stmt->affected_rows == 1) {
    $location = "Location: post.php?id=".$id."&edit=true";
    header($location);
  }
}
