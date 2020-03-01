<?php
function redirect($location){


    header("Location:" . $location);
    exit;

}




function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function isLoggedIn(){

    if(isset($_SESSION['role'])){

        return true;
      }

   return false;

}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

    if(isLoggedIn()){

        redirect($redirectLocation);

    }

}






function login_user($username, $password)
{

    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);


    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {

        die("QUERY FAILED" . mysqli_error($connection));

    }


    while ($row = mysqli_fetch_array($select_user_query)) {

        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];


        if (password_verify($password,$db_user_password)) {

            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_user_firstname;
            $_SESSION['lastname'] = $db_user_lastname;
            $_SESSION['role'] = $db_user_role;
            $_SESSION['valid']=true;



            redirect("/cms/admin");


        } else {


            return false;
            $_SESSION['valid']=false;


        }



    }

    return true;

}





function email_exists($email){

    global $connection;


    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    comfirmQuery($result);

    if(mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }



}







function insert_categories(){
        global $connection;
  if(isset($_POST['submit'])){
    $cat_title=$_POST['cat_title'];
    $check_spaces=preg_replace('/\s+/','',$cat_title);

    // $check_spaces=str_replace(' ','',$cat_title);
    if($cat_title==""||empty($cat_title)||$check_spaces==""){
      echo "This field should be empty";
    }else{
      $cat_title=mysqli_real_escape_string($connection,$cat_title);
      $stmt=mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUES(?) ");
      mysqli_stmt_bind_param($stmt,'s',$cat_title);
      mysqli_stmt_execute($stmt);
      if(!$stmt){
        die("Query Failed " . mysqli_error($connection));
      }else{
        echo "<h1>$cat_title Category created</h1>";
      }
      mysqli_stmt_close($stmt);
    }

  }
}
function findAllCategories(){
  global $connection;
  $query="SELECT * FROM categories ORDER BY cat_id ASC";
  $categories_admin=mysqli_query($connection,$query);
  while($row=mysqli_fetch_assoc($categories_admin)){
      $cat_id=$row['cat_id'];
      $cat_title=$row['cat_title'];
      echo "<tr>";
      echo "<td>{$cat_id}</td>";
      echo "<td>{$cat_title}</td>";
      echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
      echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
      echo "</tr>";
  }
}
function deleteCategory(){
    global $connection;
  if(isset($_GET['delete'])){
    $the_cat_id=$_GET['delete'];
    $query="DELETE FROM categories WHERE cat_id={$the_cat_id}";
    $delete_query=mysqli_query($connection,$query);
    header("Location: categories.php");
  }
}
function comfirmQuery($conn){
  global $connection;
  if(!$conn){
    die("QUERY FAILED ".mysqli_error($connection));
  }
}

function users_online() {



    if(isset($_GET['onlineusers'])) {

    global $connection;

    if(!$connection) {

        session_start();

        include("../includes/db.php");

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

            if($count == NULL) {

            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");


            } else {

            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");


            }

        $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);


    }






    } // get request isset()


}

users_online();

function recordCount($table){
  global $connection;
  $query="SELECT * FROM $table";
  $send_query=mysqli_query($connection,$query);
  $result=mysqli_num_rows($send_query);
  comfirmQuery($result);
  if($result==null){
    $result=0;
  }
  return $result;
}
?>
