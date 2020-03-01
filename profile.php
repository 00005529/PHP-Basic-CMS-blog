<?php include "includes/db.php" ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php
if(isset($_SESSION['username'])){
  $username= $_SESSION['username'];
}
$query="SELECT * FROM users WHERE username='{$username}'";
$select_user=mysqli_query($connection,$query);
while($row=mysqli_fetch_assoc($select_user)){
  $username=$row['username'];
  $user_firstname=$row['user_firstname'];
  $user_lastname=$row['user_lastname'];
  $user_email=$row['user_email'];
  $user_image=$row['user_image'];
  $user_role=$row['user_role'];
  $user_password=$row['user_password'];
    $the_user_id=$row['user_id'];
  }


  if(isset($_POST['edit_profile'])){
    $username        = $_POST['username'];
    $user_firstname         = $_POST['user_firstname'];
    $user_lastname  = $_POST['user_lastname'];
    $user_email       = $_POST['user_email'];
    $user_password=$_POST['user_password'];
    $user_image        = $_FILES['image']['name'];
    $user_image_temp   = $_FILES['image']['tmp_name'];
    $user_id=$the_user_id;
    move_uploaded_file($user_image_temp, "./images/$user_image" );
    $username=mysqli_real_escape_string($connection, $username);
    $user_password=mysqli_real_escape_string($connection, $user_password);
    $user_email=mysqli_real_escape_string($connection, $user_email);
    $user_lastname=mysqli_real_escape_string($connection, $user_lastname);
    $user_firstname=mysqli_real_escape_string($connection, $user_firstname);
    // $hashFormat='$2y$10$';
    // $salt='iusesomecrazystrings22';
    // $hashF_and_salt=$hashFormat . $salt ;
    // $user_password = crypt($user_password,$hashF_and_salt);

    // $post_content      = $_POST['post_content'];
    // $post_date         = date('F d,Y \a\t H:i A');//August 24, 2013 at 9:00 PM
    $check_spaces_username=preg_replace('/\s+/','',$username);
    $check_spaces_firstname=preg_replace('/\s+/','',$user_firstname);
    $check_spaces_lastname=preg_replace('/\s+/','',$user_lastname);
    $check_spaces_email=preg_replace('/\s+/','',$user_email);
    $check_spaces_role=preg_replace('/\s+/','',$user_role);


    // $check_spaces=str_replace(' ','',$cat_title);
    if(empty($user_image)){
      $query="SELECT * FROM users WHERE user_id='{$user_id}'";
      $selected_user=mysqli_query($connection,$query);
      while($row=mysqli_fetch_assoc($selected_user)){
        $user_image=$row['user_image'];
      }
    }
    $query="UPDATE users SET username='{$username}',";
      $query.=" user_firstname='{$user_firstname}',";
      $query.=" user_lastname='{$user_lastname}',";
      $query.=" user_email='{$user_email}',";
      $query.=" user_image='{$user_image}'";
      $query.=" WHERE user_id=$user_id";
    $edit_user_query=mysqli_query($connection,$query);
    if(!$edit_user_query){
      die("QUERY FAILED ".mysqli_error($connection));
    }
      header("Location: index.php");

}

 ?>

    <div id="wrapper">

        <!-- Navigation -->

          <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          Profile Page
                            <small>Welcome, <?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname'] ?></small>

                        </h1>
                        <form action="" method="post" enctype="multipart/form-data">


                                    <div class="form-group">
                                       <label for="username">Username</label>
                                        <input type="text" value="<?php echo $username ?>" class="form-control" name="username">
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
                                        <input type="text" value="<?php if(isset($username)){ echo $user_firstname ;}?>"  class="form-control" name="user_firstname">
                                    </div>



                                     <div class="form-group">
                                       <label for="user_lastname">Lastname</label>
                                        <input type="text" value="<?php if(isset($user_lastname)){echo $user_lastname ;}?>"  class="form-control" name="user_lastname">
                                       <!-- <select name="post_status" id="">
                                           <option value="draft">Post Status</option>
                                           <option value="published">Published</option>
                                           <option value="draft">Draft</option>
                                       </select> -->
                                    </div>
                                  <div class="form-group">
                                       <label for="post_image">User Image</label>
                                       <img width="100" src="./images/<?php echo $user_image; ?>" alt="">
                                        <input type="file"  name="image">
                                    </div>

                                    <div class="form-group">
                                       <label for="user_email">Email</label>
                                        <input value="<?php echo $user_email ?>"  type="email" class="form-control" name="user_email">
                                    </div>
<div class="row">
  <div class="col-sm-2">
    <div class="form-group">
       <input class="btn btn-primary" type="submit" name="edit_profile" value="Update Profile">
   </div>
  </div>
  <div class="col-sm-2">
    <div class="form-group">
       <a class="btn btn-primary" href='password.php' >Change Password</a>
   </div>
  </div>
</div>



                        </form>
                      </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include "includes/footer.php"; ?>
