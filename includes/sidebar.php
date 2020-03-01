<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form class="" action="/cms/search.php" method="post">
        <div class="input-group">
            <input  name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
      </form>
        <!-- /.input-group -->
    </div>
    <!--Login -->
      <?php if(!isset($_SESSION['username'])){?>
    <div class="well">

            <h4>Login</h4>
              <?php if(isset($_SESSION['valid'])){
                if($_SESSION['valid']==false){
                  echo $_SESSION['valid'];
                  echo "<h5>Wrong Credentials</h5>";
                 } }?>
                <form action="/cms/includes/login.php" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                  <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                       <button class="btn btn-primary" name="login" type="submit">Submit
                       </button>
                    </span>
                   </div>
                   <div class="form-group">
                     <a href="/cms/forgot.php?forgot=<?php echo uniqid(true) ?>">Forgot Password?</a>
                   </div>

                </form><!--search form-->
                <!-- /.input-group -->
        </div>
      <?php }else{ $username=$_SESSION['username'] ;
        $query="SELECT * FROM users WHERE username='{$username}'";
        $select_user=mysqli_query($connection,$query);
        while($row=mysqli_fetch_assoc($select_user)){
          $user_image=$row['user_image'];
        }
        if(!$select_user){
          die("QUERY FAILED ".mysqli_error($connection));
        };
         ?>
         <div class="well">

        <h4>Logged in!</h4>
        <div class="row" >
          <div class="col-lg-3">
            <img style="border: 1px solid black;width:75px;margin:5px; height:auto;" class="img-responsive img-circle" src="/cms/images/<?php echo $user_image ?>" alt="">
          </div>
          <div class="col-lg-6">
            <h3><?php echo $username ?></h3>
          </div>
          <div class="col-lg-3">
          <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>
          </div>

        </div>
</div>
      <?php } ?>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                  <?php
                    $query="SELECT * FROM categories";
                    $categories=mysqli_query($connection,$query);
                    while($row=mysqli_fetch_assoc($categories)){
                        $cat_title=$row['cat_title'];
                        $cat_id=$row['cat_id'];
                        echo "<li> <a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

  <?php include 'widget.php'; ?>

</div>
