<?php
if(isset($_SESSION['username'])){
$username=$_SESSION['username'];
$user_email=$_SESSION['email'];

  if(isset($_POST['create_comment'])){
    $the_post_id=$_GET['p_id'];
    // $comment_author=$_POST['comment_author'];
    // $comment_email=$_POST['comment_email'];
    $comment_content=$_POST['comment_content'];
    if(empty($comment_content)){
      echo "<script> alert('Comment field cannot be empty')</script";
    }else{
    $query="INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status)";
    $query.="VALUES ($the_post_id, '{$username}', '{$user_email}', '{$comment_content}', 'approved')";
    $create_comment_query=mysqli_query($connection,$query);
    if(!$create_comment_query){
      die("QUERY FAILED ".mysqli_error($connection));
    }
  }
  }
}
 ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="post" role="form">
                    <!--    <div class="form-group">
                          <label for="comment_author">Author</label>
                            <textarea type="text" class="form-control"  rows="1" name="comment_author"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <textarea type="email" class="form-control"  rows="1" name="comment_email" ></textarea>
                        </div> -->
                        <?php if(!isset($_SESSION['username'])){
                            echo    "<h4>Please login to write a comment</h4>";


                      }else{
                        $username=$_SESSION['username'];
                        $user_email=$_SESSION['email'];
                      echo "  <div class='form-group'>
                            <label for='comment_content'>Comment</label>
                            <textarea name='comment_content' class='form-control' rows='3'></textarea>
                        </div>

                        <button type='submit' name='create_comment' class='btn btn-primary'>Submit</button>";
                       } ?>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                $query="SELECT * FROM comments WHERE comment_post_id={$the_post_id}";
                $query.=" AND comment_status='approved'";
                $query.=" ORDER BY comment_id DESC";
                $select_comment_query=mysqli_query($connection, $query);
                if(!$select_comment_query){
                  die("QUERY FAILED " .mysqli_error($connection));
                }
                while($row=mysqli_fetch_assoc($select_comment_query)){
                  $comment_date=$row['comment_date'];
                  $comment_content=$row['comment_content'];
                  $comment_author=$row['comment_author'];
                  ?>
                  <div class="media">
                      <a class="pull-left" href="#">
                        <?php
                         $query="SELECT * FROM users WHERE username='{$comment_author}'";
                         $select_user=mysqli_query($connection,$query);
                         while($row=mysqli_fetch_assoc($select_user)){
                           $user_image=$row['user_image'];

                          ?>
                          <img style="width:75px;height:75px;border: 1px solid black" class="img-responsive img-circle" class="media-object" src="images/<?php echo $user_image ?>" alt="pic">
                        <?php } ?>
                      </a>
                      <div  class="media-body">
                          <h4 class="media-heading"><strong><?php echo $comment_author; ?></strong>
                              <small><?php echo $comment_date; ?></small>
                          </h4>
                          <?php echo $comment_content; ?>
                      </div>
                  </div>
              <?php  } ?>
