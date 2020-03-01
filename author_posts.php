<?php include 'includes/db.php'?>
  <!-- Header -->
<?php include "includes/header.php" ?>
  <!-- Navigation -->
<?php include "includes/navigation.php" ?>
<?php
if(isset($_GET['author'])){
  $author_id=$_GET['author'];
}
$query="SELECT * FROM users WHERE user_id='{$author_id}'";
$select_user=mysqli_query($connection,$query);
$row=mysqli_fetch_assoc($select_user);
$user_firstname=$row['user_firstname'];
$author_name=$row['username'];
$user_lastname=$row['user_lastname'];
 ?>
  <!-- Page Content -->
  <div class="container">

      <div class="row">

          <!-- Blog Entries Column -->
          <div class="col-md-8">

              <h1 class="page-header">
              <?php echo $_SESSION['firstname'] ." ".$_SESSION['lastname']?>
                  <small> Posts</small>
              </h1>

              <!-- First Blog Post -->
              <?php
                $query="SELECT * FROM posts WHERE post_status='published' AND post_author='{$author_name}' ORDER BY post_date DESC";
                $posts=mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($posts)){
                    $post_id=$row['post_id'];
                    $post_title=$row['post_title'];
                    $post_author=$row['post_author'];
                    $post_date=$row['post_date'];
                    $post_image=$row['post_image'];
                    $post_views_count=$row['post_views_count'];
                    $post_content=substr($row['post_content'],0,100);
                    ?>
                    <h2>
                        <a href="/cms/post/<?php echo $post_id?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href=""><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo "Posted on ".$post_date; ?></p>
                    <p><span class="glyphicon glyphicon-eye-open"></span><?php echo " Viewed  ".$post_views_count." times"; ?></p>
                    <hr>
                    <a href="/cms/post/<?php echo $post_id?>">
                    <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="900x300">
                  </a>
                    <hr>
                    <p><?php echo $post_content . "..."; ?></p>
                    <a class="btn btn-primary" href="/cms/post/<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
              <?php  }  ?>


          </div>

          <!-- Blog Sidebar Widgets Column -->
            <?php  include "includes/sidebar.php"?>

      </div>
      <!-- /.row -->

      <hr>
      <!-- Footer -->
      <?php  include "includes/footer.php"?>
