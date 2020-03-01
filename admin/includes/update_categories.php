<form class="" action="" method="post">
  <div class="form-group">
    <label for="cat_title">Update Category</label>
    <?php
    if(isset($_GET['edit'])){
      $cat_id=$_GET['edit'];
      $stmt=mysqli_prepare($connection,"SELECT cat_id, cat_title FROM categories WHERE cat_id=?");
      mysqli_stmt_bind_param($stmt,'i',$cat_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt,$cat_id,$cat_title);

      while(mysqli_stmt_fetch($stmt)){
          ?>
    <input type="text" name="cat_title" class="form-control" value="<?php if(isset($cat_title)){echo $cat_title;} ?>">
  <?php }
mysqli_stmt_close($stmt);
} ?>
  <?php
  if(isset($_POST['update_category'])){
    $the_cat_title=$_POST['cat_title'];
    $check_spaces=preg_replace('/\s+/','',$the_cat_title);

    // $check_spaces=str_replace(' ','',$cat_title);
    if($the_cat_title==""||empty($the_cat_title)||$check_spaces==""){
      echo "This field should be empty";
    }else{
      $the_cat_title=mysqli_real_escape_string($connection,$the_cat_title);
      $stmt=mysqli_prepare($connection,"UPDATE categories SET cat_title=? WHERE cat_id=? ");
      mysqli_stmt_bind_param($stmt,'si',$the_cat_title,$cat_id);
      mysqli_stmt_execute($stmt);
      if(!$stmt){
        die("Query Failed" . mysqli_error($connection));
      }else{
        echo "<h1>$the_cat_title Category Updated</h1>";
      }
      mysqli_stmt_close($stmt);
      redirect('categories.php');
    }

  }
   ?>


  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
  </div>
</form>
