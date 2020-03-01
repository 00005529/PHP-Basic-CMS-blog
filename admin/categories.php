<?php include 'includes/header.php' ?>


    <div id="wrapper">

        <!-- Navigation -->

          <?php include "includes/navigation.php" ?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author: Akmal Bositkhonov</small>
                        </h1>
                        <?php
                        //CREATE CATEGORY QUERY
                        insert_categories();
                        //DELETE QUERY
                        deleteCategory();
                         ?>
                        <div class="col-xs-6">
                          <form class="" action="" method="post">
                            <div class="form-group">
                              <label for="cat_title">Create New Category</label>
                              <input type="text" name="cat_title" class="form-control" value="" placeholder="Category Name">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-primary" type="submit" name="submit" value="Add Categoty">
                            </div>
                          </form>
                          <?php
                          //UPDATE AND INCLUDE
                            if(isset($_GET['edit'])){
                              $cat_id=$_GET['edit'];
                              include 'includes/update_categories.php';
                            }
                           ?>
                        </div>
                        <div class="col-xs-6">
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Category Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              findAllCategories();

                                ?>

                            </tbody>
                          </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include "includes/footer.php" ?>
