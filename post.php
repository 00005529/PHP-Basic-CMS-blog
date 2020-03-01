<?php include 'includes/db.php'?>
  <!-- Header -->
<?php include "includes/header.php" ?>
  <!-- Navigation -->
<?php include "includes/navigation.php" ?>
  <!-- Page Content -->
  <div class="container">

      <div class="row">

          <!-- Blog Entries Column -->
          <div class="col-md-8">


              <!-- First Blog Post -->
              <?php
              if(isset($_GET['p_id'])){
                $the_post_id=$_GET['p_id'];
                  $view_query="UPDATE posts SET post_views_count = post_views_count+1 WHERE post_id=$the_post_id";
                  $send_query=mysqli_query($connection,$view_query);
                $query="SELECT * FROM posts WHERE post_id=$the_post_id";
                $posts=mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($posts)){
                    $post_title=$row['post_title'];
                    $post_author=$row['post_author'];
                    $post_date=$row['post_date'];
                    $post_image=$row['post_image'];
                    $post_content=$row['post_content'];
                    $post_views_count=$row['post_views_count'];
                  }

                    ?>
                    <h2>
                        <a href="#"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo "Posted on ".$post_date; ?></p>
                    <p><span class="glyphicon glyphicon-eye-open"></span><?php echo " Viewed  ".$post_views_count." times"; ?></p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="900x300">
                    <hr>
                    <p><?php echo $post_content; ?></p>

                    <hr>
              <?php  }  ?>
              <?php include "includes/add_comments.php" ?>

          </div>

          <!-- Blog Sidebar Widgets Column -->
            <?php  include "includes/sidebar.php"?>

      </div>
      <!-- /.row -->

      <hr>
      <!-- Footer -->
      <?php  include "includes/footer.php"?>
