<?php
if(isset($_POST['create_post'])){

         $post_title        = $_POST['title'];
         $post_author         = $_POST['post_author'];
         $post_category_id  = $_POST['post_category'];
         $post_status       = $_POST['post_status'];

         $post_image        = $_FILES['image']['name'];
         $post_image_temp   = $_FILES['image']['tmp_name'];


         $post_tags         = $_POST['post_tags'];
         $post_content      = $_POST['post_content'];
         $post_date         = date('F d,Y \a\t H:i A');//August 24, 2013 at 9:00 PM
         $check_spaces_title=preg_replace('/\s+/','',$post_title);
         $check_spaces_author=preg_replace('/\s+/','',$post_author);
         $check_spaces_category_id=preg_replace('/\s+/','',$post_category_id);
         $check_spaces_status=preg_replace('/\s+/','',$post_status);
         $check_spaces_image=preg_replace('/\s+/','',$post_image);
         $check_spaces_tags=preg_replace('/\s+/','',$post_tags);


         // $check_spaces=str_replace(' ','',$cat_title);
         if($check_spaces_title==""||$check_spaces_author==""||$check_spaces_category_id==""||$check_spaces_status==""||$check_spaces_status==""||$check_spaces_image==""||$check_spaces_tags==""){
           echo "Some important fields are empty";
         }else{
         move_uploaded_file($post_image_temp, "../images/$post_image" );
         $query="INSERT INTO posts(post_category_id, post_title, post_author,
            post_date, post_image, post_content, post_tags, post_status)";
         $query.=
         "VALUES('{$post_category_id}','{$post_title}','{$post_author}',now(),'{$post_image}',
         '{$post_content}','{$post_tags}','{$post_status}')";
         $create_post_query=mysqli_query($connection,$query);
         comfirmQuery($create_post_query);
         $post_id=mysqli_insert_id($connection);
         echo "<h3 class='bg-success'>Post Updated: "."<a href='../post.php?p_id=$post_id'>View This Posts</a> or <a href='posts.php'>View All Posts` List</a></h3>";
       }
}


 ?>
    <form action="" method="post" enctype="multipart/form-data">


                <div class="form-group">
                   <label for="title">Post Title</label>
                    <input type="text" class="form-control" name="title">
                </div>

                   <div class="form-group">
                 <label for="post_category">Post Category</label>
                 <select name="post_category" id="">
                   <?php
                   $query="SELECT * FROM categories";
                   $categories_admin=mysqli_query($connection,$query);
                   comfirmQuery($categories_admin);
                   while($row=mysqli_fetch_assoc($categories_admin)){
                       $cat_id=$row['cat_id'];
                       $cat_title=$row['cat_title'];
                       echo "<option value='$cat_id'>{$cat_title}</option>";
                     }
                    ?>

                 </select>
                 <!-- <select name="post_category" id=""> -->


                 <!-- </select> -->

                </div>
                 <!-- <div class="form-group">
                 <label for="users">Users</label>
                 <select name="post_user" id="">

             </select>

                </div> -->

                <div class="form-group">
                   <label for="title">Post Author</label>
                    <input type="text" value="<?php echo $_SESSION['username'] ?>" class="form-control" name="post_author">
                </div>



                 <div class="form-group">
                   <select name="post_status" id="">
                       <option value="draft">Post Status</option>
                       <option value="published">Published</option>
                       <option value="draft">Draft</option>
                   </select>
                </div>



              <div class="form-group">
                   <label for="post_image">Post Image</label>
                    <input type="file"  name="image">
                </div>

                <div class="form-group">
                   <label for="post_tags">Post Tags</label>
                    <input type="text" class="form-control" name="post_tags">
                </div>

                <div class="form-group">
                   <label for="post_content">Post Content</label>
                   <textarea class="form-control "name="post_content" id="" cols="30" rows="10">
                   </textarea>
                </div>



                 <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
                </div>


</form>
