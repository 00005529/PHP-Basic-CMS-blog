<?php
include "includes/delete_modal.php";
if(isset($_POST['submit'])){
  foreach ($_POST['checkBoxArray'] as $postValueId) {
   $bulk_options=$_POST['bulk_options'];
    if($bulk_options=='published'){
      $query="UPDATE posts SET post_status='published' WHERE post_id=$postValueId";
      $publish_posts=mysqli_query($connection,$query);
      comfirmQuery($publish_posts);
    }
    if($bulk_options=='draft'){
      $query="UPDATE posts SET post_status='draft' WHERE post_id=$postValueId";
      $draft_posts=mysqli_query($connection,$query);
      comfirmQuery($draft_posts);
    }
    if($bulk_options=='delete'){
      $query="DELETE FROM posts WHERE post_id=$postValueId";
      $delete_posts=mysqli_query($connection,$query);
      comfirmQuery($delete_posts);
    }
    if($bulk_options=='clone'){
      $query="SELECT * FROM posts WHERE post_id=$postValueId";
      $select_posts=mysqli_query($connection,$query);
      comfirmQuery($select_posts);
      $row=mysqli_fetch_assoc($select_posts);
      $post_category_id=$row['post_category_id'];
      $post_title=$row['post_title'];
      $post_author=$row['post_author'];
      $post_date=$row['post_date'];
      $post_image=$row['post_image'];
      $post_content=$row['post_content'];
      $post_tags=$row['post_tags'];
      $query="INSERT INTO posts(post_category_id, post_title, post_author,
         post_date, post_image, post_content, post_tags, post_status)";
      $query.=
      "VALUES('{$post_category_id}','{$post_title}','{$post_author}',now(),'{$post_image}',
      '{$post_content}','{$post_tags}','published')";
      $clone_post_query=mysqli_query($connection,$query);
      comfirmQuery($clone_post_query);
          }
  }
}
 ?>
  <form class="" method="post">


<table class="table table-bordered table-hover">
  <div id="bulkOptionContainer" class="col-xs-4">

<select class="form-control" name="bulk_options" id="">
<option value="">Select Options</option>
<option value="published">Publish</option>
<option value="draft">Draft</option>
<option value="delete">Delete</option>
 <option value="clone">Clone</option>
</select>

</div>


<div class="col-xs-4">

<input type="submit" name="submit" class="btn btn-success" value="Apply">
<a class="btn btn-primary" href="posts.php?source=add_posts">Add New</a>

</div>
  <thead>
    <tr>
      <th><input id="selectAllBoxes" type="checkbox"></th>
      <th>Id</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Com</th>
      <th>Date</th>
      <th>Views</th>
      <th>Options</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $query="SELECT * FROM posts ORDER BY post_id DESC";
      $posts=mysqli_query($connection,$query);
      while($row=mysqli_fetch_assoc($posts)){
          $post_id=$row['post_id'];
          $post_author=$row['post_author'];
          $post_title=$row['post_title'];
          $post_category_id=$row['post_category_id'];
          $post_status=$row['post_status'];
          $post_image=$row['post_image'];
          $post_tags=$row['post_tags'];
          $post_comment_count=$row['post_comment_count'];
          $post_date=$row['post_date'];
          $post_views_count=$row['post_views_count'];
          echo "<tr>";
        ?>
        <td><input class='checkBoxes' name='checkBoxArray[]' value='<?php echo $post_id ?>' type='checkbox'></td>
        <?php
          echo "<td>$post_id</td>";
          echo "<td>$post_author</td>";
          echo "<td><a href='../post.php?p_id={$post_id}'>$post_title</a></td>";
          $query="SELECT * FROM categories WHERE cat_id={$post_category_id}";
          $categories_admin=mysqli_query($connection,$query);
          while($row=mysqli_fetch_assoc($categories_admin)){
              $cat_id=$row['cat_id'];
              $cat_title=$row['cat_title'];
          echo "<td>$cat_title</td>";
        }
          echo "<td>$post_status</td>";
          echo "<td><img width=100 src='../images/$post_image' alt='900x300'></td>";
          echo "<td>$post_tags</td>";
          $query="SELECT * FROM comments WHERE comment_post_id=$post_id";
          $send_query=mysqli_query($connection,$query);
          $comment_count=mysqli_num_rows($send_query);
          echo "<td><a href='post_comments.php?p_id=$post_id'>$comment_count</a></td>";
          echo "<td>$post_date</td>";
          echo "<td>$post_views_count</td>";
          echo "<td><a class='delete_link btn btn-info' rel={$post_id} href='javascript:void(0)'>Options</a></td>";

          echo "</tr>";
        }?>
  </tbody>



</table>
</form>
<script type="text/javascript">

      $(document).ready(function(){
        $('.delete_link').on('click',function(){
          var id=$(this).attr('rel');
          var edit_url="posts.php?source=edit_post&p_id="+id+" ";
          var delete_url="posts.php?delete="+id+" ";
          var view_post_url="../post.php?p_id="+id+" ";
          var reset_url="posts.php?reset="+id+" ";
          $('.modal_delete_link').attr('href',delete_url);
          $('.modal_edit_link').attr('href',edit_url);
          $('.modal_view_link').attr('href',view_post_url);
            $('.modal_reset_link').attr('href',reset_url);
          $('#myModal').modal('show');

        })
      })

</script>
<?php
if(isset($_GET['delete'])){
  if(isset($_SESSION['role'])){
    if($_SESSION['role']=='admin'){
    $the_post_id=$_GET['delete'];

  $query="DELETE FROM posts WHERE post_id={$the_post_id}";
  $delete_query=mysqli_query($connection,$query);
  $comment_delete_query="DELETE FROM comments WHERE comment_post_id={$the_post_id}";
  $comment_delete_query=mysqli_query($connection,$comment_delete_query);
  redirect("posts.php");
}
}
}
if(isset($_GET['reset'])){
  if(isset($_SESSION['role'])){
    if($_SESSION['role']=='admin'){
  $the_post_id=$_GET['reset'];
  $query="UPDATE posts SET post_views_count=0 WHERE post_id={$the_post_id}";
  $delete_query=mysqli_query($connection,$query);
  redirect("posts.php");
}
}
}
 ?>
