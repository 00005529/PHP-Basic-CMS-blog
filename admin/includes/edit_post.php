
<?php
if(isset($_GET['p_id'])){
$the_post_id=$_GET['p_id'];
}
$query="SELECT * FROM posts WHERE post_id=$the_post_id";
$select_post=mysqli_query($connection,$query);
while($row=mysqli_fetch_assoc($select_post)){
    $post_id=$row['post_id'];
    $post_author=$row['post_author'];
    $post_title=$row['post_title'];
    $post_category_id=$row['post_category_id'];
    $post_status=$row['post_status'];
    $post_image=$row['post_image'];
    $post_tags=$row['post_tags'];
    $post_content=$row['post_content'];
    $post_comment_count=$row['post_comment_count'];
    $post_date=$row['post_date'];
  }
  if(isset($_POST['update_post'])){
    $post_author=$_POST['post_author'];
    $post_title=$_POST['post_title'];
    $post_category_id=$_POST['post_category_id'];
    $post_status=$_POST['post_status'];
    $post_tags=$_POST['post_tags'];
    $post_content=$_POST['post_content'];
    $post_image        = $_FILES['image']['name'];
    $post_image_temp   = $_FILES['image']['tmp_name'];
    move_uploaded_file($post_image_temp, "../images/$post_image" );
    if(empty($post_image)){
      $query="SELECT * FROM posts WHERE post_id=$the_post_id";
      $selected_post=mysqli_query($connection,$query);
      while($row=mysqli_fetch_assoc($selected_post)){
        $post_image=$row['post_image'];
      }
    }
      $query = "UPDATE posts SET ";
      $query .="post_title  = '{$post_title}', ";
      $query .="post_category_id = '{$post_category_id}', ";
      $query .="post_date   =  now(), ";
      $query .="post_status = '{$post_status}', ";
      $query .="post_tags   = '{$post_tags}', ";
      $query .="post_content= '{$post_content}', ";
      $query .="post_image  = '{$post_image}' ";
      $query .= "WHERE post_id = {$the_post_id} ";

      $update_post=mysqli_query($connection, $query);
      comfirmQuery($update_post);

      echo "<h3 class='bg-success'>Post Updated: "."<a href='../post.php?p_id=$post_id'>View This Posts</a> or <a href='posts.php'>View All Posts` List</a></h3>";

  }

 ?>
 <div class="container container-fluid">
<form action="" method="post" enctype="multipart/form-data">


            <div class="form-group">
               <label for="title">Post Title</label>
                <input value="<?php echo $post_title?>" type="text" class="form-control" name="post_title">
            </div>

               <div class="form-group">
             <select name="post_category_id" id="">
               <?php
               $query="SELECT * FROM categories";
               $categories_admin=mysqli_query($connection,$query);
               comfirmQuery($categories_admin);
               while($row=mysqli_fetch_assoc($categories_admin)){
                   $cat_id=$row['cat_id'];
                   $cat_title=$row['cat_title'];
                   if($cat_id==$post_category_id){
                   echo  "<option selected value='$cat_id'>{$cat_title}</option>";
                 }else{
                echo   "<option value='$cat_id'>{$cat_title}</option>";
                 }
                 }
                ?>

               <?php
               // $query="SELECT * FROM categories WHERE NOT cat_id=$post_category_id";
               // $categories_admin=mysqli_query($connection,$query);
               // comfirmQuery($categories_admin);
               // while($row=mysqli_fetch_assoc($categories_admin)){
               //     $cat_id=$row['cat_id'];
               //     $cat_title=$row['cat_title'];
               //     echo "<option value='$cat_id'>{$cat_title}</option>";
               //   }
                ?>

             </select>

            </div>
             <!-- <div class="form-group">
             <label for="users">Users</label>
             <select name="post_user" id="">

         </select>

            </div> -->

            <div class="form-group">
               <label for="title">Post Author</label>
                <input value="<?php echo $post_author?>"  type="text" class="form-control" name="post_author">
            </div>



             <div class="form-group">
               <label for="status">Post Status</label>
               <select name="post_status" id="">
                   <option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
                  <?php  if($post_status=='draft'){?>
                   <option value="published">published</option>
                 <?php }else{ ?>
                   <option value="draft">draft</option>
                 <?php } ?>
               </select>
            </div>



          <div class="form-group">
             <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
                <input type="file"  name="image">
            </div>

            <div class="form-group">
               <label for="post_tags">Post Tags</label>
                <input value="<?php echo $post_tags;?>" type="text" class="form-control" name="post_tags">
            </div>

            <div class="form-group">
               <label for="post_content">Post Content</label>
               <textarea class="form-control "name="post_content" id="" cols="30" rows="10"><?php echo $post_content;?>
               </textarea>
            </div>



             <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
            </div>


</form>
</div>
