<?php
include "db.php";
session_start();
if(isset($_POST['login'])){
  $username=$_POST['username'];
  $password=$_POST['password'];
  $username=mysqli_real_escape_string($connection,$username);
  $password=mysqli_real_escape_string($connection,$password);
  $query="SELECT * FROM users WHERE username='{$username}'";
  $select_user=mysqli_query($connection,$query);
  while($row=mysqli_fetch_assoc($select_user)){
    $db_user_id=$row['user_id'];
    $db_username=$row['username'];
    $db_user_firstname=$row['user_firstname'];
    $db_user_lastname=$row['user_lastname'];
    $db_user_password=$row['user_password'];
    $db_user_role=$row['user_role'];
    $db_user_email=$row['user_email'];
    $db_user_image=$row['user_image'];
  }

 if($username===$db_username && password_verify($password,$db_user_password)){
    $_SESSION['username']=$db_username;
    $_SESSION['firstname']=$db_user_firstname;
    $_SESSION['email']=$db_user_email;
    $_SESSION['lastname']=$db_user_lastname;
    $_SESSION['role']=$db_user_role;
    $_SESSION['image']=$db_user_image;
    $_SESSION['id']=$db_user_id;
    $_SESSION['valid']=true;
    header("Location:/cms/admin");
  }else{
    $_SESSION['valid']=false;
    header("Location: /cms");

  }
}
 ?>
