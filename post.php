<?php
    include 'function/config.php';
    include 'includes/header.php';
    include 'function/postmanager.php';
    include 'function/commentmanager.php';

    if(isset($_GET['id'])) {
        $post = getPost($_GET['id'], $conn);
        $comments = getComments($post['ID'], $conn);
      }
?>

       <hr>
       <div class="container post">
         <div class="row">
           <?php if ($post == false): ?>
             <h2 class="display-4">404 Post Not Found!</h2>
            </div>
           <?php else: ?>
             <div class="col-md-8 offset-md-2">
                <img style="height: 50vh; " src="<?php echo $post['post_img']; ?>" class="img-fluid" alt="">
                <h2 class="font-weight-light mt-4"><?php echo htmlspecialchars($post['post_title']); ?></h2>
                <p><i>Author: <?php echo getAuthorInfo($conn, $post['post_author'])['user_name']; ?>
                </i></p>
                <h5><em><?php echo htmlspecialchars($post['date_modified']); ?>
                </em></h5>
                 <p><?php echo htmlspecialchars($post['post_body']); ?></p>

            <?php if($_SESSION['loggedin'] == true && $_SESSION['user_id'] == $post['post_author']):?>
            <div class="container edit">
                  <div class="row">
                    <div class="col-md-6">
                      <a href="editpost.php?id=<?php echo $post['ID']?>&edit=false" class="btn btn-block btn-outline-warning">Edit</a>
                    </div>
                    <div class="col-md-6">
                      <a href="deletepost.php?id=<?php echo $post['ID']?>&delete=false" class="btn btn-block btn-outline-danger">Delete</a>
                    </div>
                  </div>
                 </div>
             <!-- end of edit for author -->
            <?php elseif($_SESSION['loggedin'] == true && $_SESSION['user_role'] == 1):?>
            <div class="container edit">
                  <div class="row">
                  <a href="deletepost.php?id=<?php echo $post['ID']?>&delete=false" class="btn btn-block btn-outline-danger">Delete</a>
                  </div>
                 </div>
            <?php endif; ?>
          </div> 

           </div> <!-- end of post row -->
      
           <!-- comment row -->
           <?php if($_SESSION['loggedin'] == true): ?>
            <hr>
            <h3 class="display-4 mt-3 mb-3">Comments</h3>
            <hr>
           <div class="row comments" style="padding: 1rem;;">
             <div class="col-md-8 form">
               <form class="comment-form" method="POST" action="function/ajaxmanager.php">
                 <textarea name="comment" class="form-control" rows="4" cols="80"></textarea>
                 <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SERVER['QUERY_STRING']); ?>">
                 <button type="submit" name="comment-submit" class="btn btn-outline-success mt-2"><i class="far fa-comment"></i> Add Comment</button>
               </form>
             </div>
           </div>
           <?php else: ?>
            <hr>
            <h3 class="display-4 mt-3 mb-3"><a href="login.php">Log in</a> to comment</h3>
            <hr>
           <?php endif; ?>
           <?php endif; ?>
      <!-- all comments output-->

       <div class="container comment" style="padding: 2rem, 2rem;">
         <?php outputComments($conn, $comments); ?>
       </div>

       <hr>
  </div>

<?php
    include 'includes/footer.php';
?>
