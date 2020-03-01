  <?php include 'includes/db.php'?>
    <!-- Header -->
<?php include "includes/header.php" ?>
    <!-- Navigation -->
<?php include "includes/navigation.php" ?>
<?php  ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Akmal Bositkhonov
                    <small>Blog Posts</small>
                </h1>

                <!-- First Blog Post -->
                <?php
                $per_page=10;
                if(isset($_GET['page'])){
                  $page=$_GET['page'];
                }else{
                  $page=1;
                }
                if($page==""||$page==1){
                  $page_num=0;
                }else{
                  $page_num=($page*$per_page)-$per_page;
                }

                if(isset($page)&&$page>3){
                  $min_page=$page-$per_page;
                $max_page=$page+$per_page;
              }else{
                $min_page=1;
                $max_page=5;

              }


                  if($_SESSION['role']=='admin'){
                      $post_query="SELECT * FROM posts  WHERE post_status='published' OR post_status='draft'";
                  }else{
                    $post_query="SELECT * FROM posts WHERE post_status='published'";
                  }
                  $all_posts=mysqli_query($connection,$post_query);
                  $posts_count=mysqli_num_rows($all_posts);
                  $count=ceil($posts_count/$per_page);
                  if($count<1){
                    echo "<h2>No posts available<h2>";
                  }else{
                  $query="SELECT * FROM posts WHERE post_status='published' ORDER BY post_date LIMIT $page_num, $per_page";
                    if($_SESSION['role']=='admin'){
                        $query="SELECT * FROM posts ORDER BY post_date LIMIT $page_num, $per_page";
                    }
                  $posts=mysqli_query($connection,$query);
                  while($row=mysqli_fetch_assoc($posts)){
                      $post_id=$row['post_id'];
                      $post_views_count=$row['post_views_count'];
                      $post_title=$row['post_title'];
                      $post_author=$row['post_author'];
                      $post_date=$row['post_date'];
                      $post_image=$row['post_image'];
                      $post_content=substr($row['post_content'],0,100);
                      ?>
                      <h2>
                          <a href="/cms/post/<?php echo $post_id?>"><?php echo $post_title; ?></a>
                      </h2>
                      <p class="lead">
                        <?php
                        $query="SELECT * FROM users WHERE username='{$post_author}'" ;
                        $send_query=mysqli_query($connection,$query);
                        $row=mysqli_fetch_assoc($send_query);
                        $user_id=$row['user_id'];
                         ?>
                          by <a href="/cms/author_posts/<?php  echo  $user_id; ?>"><?php echo $post_author; ?></a>
                      </p>
                      <p><span class="glyphicon glyphicon-time"></span><?php echo "Posted on ".$post_date; ?></p>
                      <p><span class="glyphicon glyphicon-eye-open"></span><?php echo " Viewed  ".$post_views_count." times"; ?></p>
                      <hr>
                      <a href="cms/post/<?php echo $post_id?>">
                      <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="900x300">
                    </a>
                      <hr>
                      <p><?php echo $post_content . "..."; ?></p>
                      <a class="btn btn-primary" href="/cms/post/<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                      <hr>
                <?php  }}  ?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
              <?php  include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
          <ul class="pager">


            <?php
              if(!($posts_count<=$per_page)){
            if(!($posts_count<=$per_page)){
            echo "<li><a href='index.php?page=1'>First</a></li>";
            if($page>1){
            $prev=$page-1;
          }else{
            $prev=1;
          }
            echo "<li><a href='index.php?page={$prev}'><span class='glyphicon glyphicon-chevron-left'></span></a></li>";
          }
            for($i=1;$i<=$count;$i++){

              if($page==$count){
                $min_page=$count-4;
                $max_page=$count;
              }
              if($i==$page){
              echo "<li><a class='active_link text-center' href='index.php?page={$i}'>{$i}</a></li>";
            }else{
              if($min_page>0){
              if($i<$min_page||$i>$max_page){
              echo "";
            }else{
              if($i>$max_page){
                echo "";
              }else{
              echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
          }
          }
          }
        }
        if($page<$count){
        $next=$page+1;
      }else{
        $next=$count;
      }
        if(!($posts_count<=$per_page)){
        echo "<li><a href='index.php?page={$next}'> <span class='glyphicon glyphicon-chevron-right'></span></a></li>";
        echo "<li><a href='index.php?page=$count'>Last</a></li>";
      }
    }
            ?>
          </ul>




        <!-- Footer -->
        <?php  include "includes/footer.php"?>
