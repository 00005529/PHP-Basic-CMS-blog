<?php include "includes/db.php" ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php
if(isset($_SESSION['username'])){
  $username= $_SESSION['username'];
  $the_user_id=$_SESSION['id'];
}
$query="SELECT * FROM users WHERE username='{$username}'";
$select_user=mysqli_query($connection,$query);
while($row=mysqli_fetch_assoc($select_user)){
  $db_user_password=$row['user_password'];
}

  if(isset($_POST['change_password'])){
    $old_user_password=$_POST['old_user_password'];
    $new_user_password=$_POST['new_user_password'];
    $confirm_user_password=$_POST['confirm_user_password'];

    $old_user_password=mysqli_real_escape_string($connection, $old_user_password);
    $new_user_password=mysqli_real_escape_string($connection, $new_user_password);
    $confirm_user_password=mysqli_real_escape_string($connection, $confirm_user_password);
    if(!empty($new_user_password)&&!empty($confirm_user_password)){
if(password_verify($old_user_password,$db_user_password)){
  if( $confirm_user_password==$new_user_password){
   $confirm_user_password=password_hash($confirm_user_password,PASSWORD_BCRYPT,array('cost'=>12));
    $query="UPDATE users SET";
    $query.=" user_password='{$confirm_user_password}'";
      $query.=" WHERE user_id=$the_user_id";
    $edit_user_query=mysqli_query($connection,$query);
    if(!$edit_user_query){
      die("QUERY FAILED ".mysqli_error($connection));
    }
    $message="Password Changed";
      $_SESSION['id']=$confirm_user_password;
}else{
  $message="Wrong Old Password";
}
}else{
  $message="Password Not Confirmed";
}
}else{
  echo "<script>alert('Fields Empty')</script>";
}
}else{
  $message="";
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

                          <h3><?php echo $message ?></h3>


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
                                        <input placeholder="Old Password" onclick="" type="password"  class="form-control" name="old_user_password">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="New Password" type="password"  class="form-control" name="new_user_password">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Confirm Password" type="password" class="form-control" name="confirm_user_password">
                                    </div>



                                     <div class="form-group">
                                        <input class="btn btn-primary" type="submit" name="change_password" value="Change Password">
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
