<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>

 <?php
 if(isset($_POST['submit'])){
   $username=$_POST['username'];
   $email=$_POST['email'];

   $password=$_POST['password'];
   if(!empty($username) && !empty($email) && !empty($password)){
     $check_spaces_username=preg_replace('/\s+/','',$username);
     $check_spaces_email=preg_replace('/\s+/','',$email);

     if($check_spaces_username!==""&&$check_spaces_email!==""){
       $username=mysqli_real_escape_string($connection, $username);
       $email=mysqli_real_escape_string($connection, $email);
       $password=mysqli_real_escape_string($connection, $password);
       // if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$email)){
       //   echo "Email you have entered in invalid";
       // }else{
       // $query="SELECT randSalt FROM users";
       // $select_randsalt=mysqli_query($connection,$query);
       // if(!$select_randsalt){
       //   die("QUERY FAILED " .mysqli_error($connection));
       // }
       // $row=mysqli_fetch_assoc($select_randsalt);
       //  $salt=$row['randSalt'];
       //  $password=crypt($password,$salt);

       $query="SELECT username FROM users WHERE username='{$username}'";
       $send_query=mysqli_query($connection,$query);
       $username_count=mysqli_num_rows($send_query);
       if($username_count>0){
         $username_error="Given username is allready exists";
       }else{
         $query="SELECT user_email FROM users WHERE user_email='{$email}'";
         $send_query=mysqli_query($connection,$query);
         $user_email_count=mysqli_num_rows($send_query);
         if($user_email_count>0){
           $email_error="Given email is allready exists";
         }else{
           if(strlen($password)<6){
             $password_error="Password should be longer than 6 characters";
           }else{
          $password=password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
    $query="INSERT INTO users(username, user_email,user_password,user_role) ";
    $query.="VALUES('{$username}', '{$email}', '{$password}','subscriber')";
    $create_user=mysqli_query($connection,$query);
    $message="Your Registration has been submitted";
    $user_id=mysqli_insert_id($connection);
    $reg_query="SELECT * users WHERE user_id=$user_id";
    $send_query=mysqli_query($connection,$reg_query);
    $row=mysqli_fetch_assoc($send_query);
    $db_user_role=$row['user_role'];
    $_SESSION['username']=$username;
    $_SESSION['email']=$email;
    $_SESSION['role']=$db_user_role;
    $_SESSION['id']=$user_id;
    $_SESSION['valid']=true;
    header("Location:admin");
  }}
}}else{
    $message="Fields cannot be empty";
    if(empty($username)){
      $username_error="Username cannot be empty";
    }
    if(empty($email)){
      $email_error='Email cannot be empty';
    }
    if(empty($password)){
      $password_error="Password cannot be empty";
    }
    // echo "<script>alert('Fields cannot be empty')</script>";
  }
  }else{
        $message="Fields cannot be empty";
        if(empty($username)){
          $username_error="Username cannot be empty";
        }
        if(empty($email)){
          $email_error='Email cannot be empty';
        }
        if(empty($password)){
          $password_error="Password cannot be empty";
        }
   }
}else{
  $message="";
}
  ?>
    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center">Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h3 class="text-center"><?php if(isset($message)){ echo $message;} ?></h3>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" value="<?php echo isset($username) ? $username :"" ?>" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            <p class="text-center" style="color:red;"><?php if(isset($username_error)){echo $username_error;} ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" value="<?php echo isset($email) ? $email :"" ?>" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            <p class="text-center" style="color:red;"><?php if(isset($email_error)){echo $email_error;} ?></p>
                        </div>
                         <div class="form-group">
                           <div class="row ">
                             <div  class="col-sm-10">
                               <label for="password" class="sr-only">Password</label>
                               <input  type="password" name="password" id="key" class="form-control" placeholder="Password">
                              <p class="text-center" style="color:red;"><?php if(isset($password_error)){echo $password_error;} ?></p>
                             </div>
                             <div class="col-sm-2">
                               <input onclick="show()" id='toggle'value="show" class="btn btn-primary" type="button" name="button">
                             </div>
                           </div>

                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
