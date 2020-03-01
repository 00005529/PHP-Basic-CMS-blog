<?php
if(isset($_POST['create_user'])){

         $username        = $_POST['username'];
         $user_firstname         = $_POST['user_firstname'];
         $user_lastname  = $_POST['user_lastname'];
         $user_email       = $_POST['user_email'];
         $user_password=$_POST['user_password'];
         $user_image        = $_FILES['image']['name'];
         $user_image_temp   = $_FILES['image']['tmp_name'];
         $user_role        = $_POST['user_role'];

         $username=mysqli_real_escape_string($connection, $username);
         $user_password=mysqli_real_escape_string($connection, $user_password);
         $user_email=mysqli_real_escape_string($connection, $user_email);
         $user_lastname=mysqli_real_escape_string($connection, $user_lastname);
         $user_firstname=mysqli_real_escape_string($connection, $user_firstname);
         $user_password=password_hash($user_password, PASSWORD_BCRYPT,array('cost'=>12));
         $check_spaces_username=preg_replace('/\s+/','',$username);
         $check_spaces_firstname=preg_replace('/\s+/','',$user_firstname);
         $check_spaces_lastname=preg_replace('/\s+/','',$user_lastname);
         $check_spaces_email=preg_replace('/\s+/','',$user_email);
         $check_spaces_role=preg_replace('/\s+/','',$user_role);


         if($check_spaces_username==""||$check_spaces_firstname==""||$check_spaces_lastname==""||$check_spaces_email==""||$check_spaces_role==""||empty($user_password)||empty($user_email)){
           echo "Some important fields are empty";
         }else{
         move_uploaded_file($user_image_temp, "../images/$user_image" );
         $query="INSERT INTO users(username,user_password, user_firstname, user_lastname,
            user_email, user_image, user_role)";
         $query.=
         "VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}',
         '{$user_image}','{$user_role}')";
         $create_user_query=mysqli_query($connection,$query);
         comfirmQuery($create_user_query);
         echo "<h3>User Created "."<a href='users.php'>View Users</a></h3>";
       }
}


 ?>
    <form action="" method="post" enctype="multipart/form-data">


                <div class="form-group">
                   <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>

                   <!-- <div class="form-group">
                 <label for="post_category">Post Category Id</label>
                 <select name="post_category" id=""> -->
                   <?php
                   // $query="SELECT * FROM categories";
                   // $categories_admin=mysqli_query($connection,$query);
                   // comfirmQuery($categories_admin);
                   // while($row=mysqli_fetch_assoc($categories_admin)){
                   //     $cat_id=$row['cat_id'];
                   //     $cat_title=$row['cat_title'];
                   //     echo "<option value='$cat_id'>{$cat_title}</option>";
                   //   }
                    ?>

                 <!-- </select> -->
                 <!-- <select name="post_category" id=""> -->


                 <!-- </select> -->
<!--
                </div> -->
                 <!-- <div class="form-group">
                 <label for="users">Users</label>
                 <select name="post_user" id="">

             </select>

                </div> -->

                <div class="form-group">
                   <label for="user_firstname">Firstname</label>
                    <input type="text" class="form-control" name="user_firstname">
                </div>



                 <div class="form-group">
                   <label for="user_lastname">Lastname</label>
                    <input type="text" class="form-control" name="user_lastname">
                   <!-- <select name="post_status" id="">
                       <option value="draft">Post Status</option>
                       <option value="published">Published</option>
                       <option value="draft">Draft</option>
                   </select> -->
                </div>
                <div class="form-group">
                <select name="user_role" id="">
                  <option value="subscriber">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="subscriber">Subscriber</option>
                </select>
              </div>

              <div class="form-group">
                   <label for="post_image">User Image</label>
                    <input type="file"  name="image">
                </div>

                <div class="form-group">
                   <label for="user_email">Email</label>
                    <input type="email" class="form-control" name="user_email">
                </div>

                <div class="form-group">
                   <label for="user_password">Password</label>
                    <input type="password" class="form-control" name="user_password">
                </div>



                 <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
                </div>


</form>
