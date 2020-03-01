
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Categories <b class="caret"></b></a>
                  <ul class="dropdown-menu">

              <?php

                $query="SELECT * FROM categories";
                $categories=mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($categories)){
                    $cat_title=$row['cat_title'];
                    $cat_id=$row['cat_id'];

                    $category_class='';
                    $registration_class='';
                    $page_name=basename($_SERVER['PHP_SELF']);
                    $registration='registration.php';
                    if(isset($_GET['category'])&&$_GET['category']==$cat_id){
                      $category_class='active';
                    }else if($page_name==$registration){
                      $registration_class='active';
                    }

                    echo "<li> <a class='{$category_class}' href='/cms/category/$cat_id'>$cat_title</a></li><li class='divider'></li>";

                }
                ?>
              </ul>
            </li>
                <?php if(isset($_SESSION['role'])){
                  if($_SESSION['role']=='admin'){?>
                <li>
                    <a href="/cms/admin">Admin</a>
                </li>
                <?php if(isset($_GET['p_id'])){
                  $the_post_id=$_GET['p_id'];
                  ?>
                  <li>
                      <a href="admin/posts.php?source=edit_post&p_id=<?php echo $the_post_id?>">Edit this Post</a>
                  </li>

              <?php }}} ?>
              <?php if(!isset($_SESSION['username'])){?>
                <li>
                    <a class="<?php echo $registration_class ?>" href="/cms/registration">Registration</a>
                </li>
                <li>
                    <a class="<?php echo $registration_class ?>" href="/cms/login">Login</a>
                </li>
              <?php } ?>
              <li>
                  <a class="<?php echo $registration_class ?>" href="/cms/contact">Contact</a>
              </li>
                <!--
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
                <?php if(isset($_SESSION['username'])){
                  $username=$_SESSION['username']
                ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo  $_SESSION['username']  ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/cms/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/cms/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                  </li>

                <?php } ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
