<?php
session_start();
include 'header_footer_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<form>
  <?php
    header_function();
  ?>
    <!-- Masthead -->
    <header>
      <div class="overlay"></div>
      <div class="container" >
        <div class="row" >
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <div>
              <h1 class="mb-1" align="center">Search for Scholarship</h1>
            </div>
            <form action = "advanced_search_handler.php" method="post">
              <div class="form-row">
                <div class="col-12 col-md-12 mb-12 mb-md-0">
                    <input type="text" class="form-control form-control-lg" placeholder="Title" name = "title" tabindex="1">
                </div>
                <div class="col-12 col-md-12 mb-12 mb-md-0" style="margin-top: 10px">
                    <input type="text" class="form-control form-control-lg" placeholder="Keywords (Semicolon Separated)" name = "keyword" tabindex="3">
                </div>
                <div class="col-12 col-md-12 mb-12 mb-md-0" style="margin-top: 10px">
                    <input type="text" class="form-control form-control-lg" placeholder="Language" name = "language" tabindex="2">
                </div>
                <div class = "col-6 col-md-6 mb-12 mb-md-0" style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Author First Name" name = "author_fname" tabindex="4">
                </div>
                <div class = "col-6 col-md-6 mb-12 mb-md-0" style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Author Last Name" name = "author_lname" tabindex="5">
                </div>
                <div class = "col-6 col-md-6 mb-12 mb-md-0" style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Editor First Name" name = "editor_fname" tabindex="6">
                </div>
                <div class = "col-6 col-md-6 mb-12 mb-md-0" style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Editor Last Name" name = "editor_lname" tabindex="7">
                </div>
                <div class="col-12 col-md-12 mb-12 mb-md-0"style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Year of Publication" name = "year_of_publication" tabindex="8">
                </div>
                <div class="col-12 col-md-12 mb-12 mb-md-0" style="margin-top: 10px">
                  <input type="text" class="form-control form-control-lg" placeholder="Publisher" name = "publisher" tabindex="9">
                </div>
                <div class="col-12 col-md-12" style="margin-top: 10px">
                    <button type="submit" class="btn btn-block btn-lg btn-primary" align="center">Search</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>
    <?php
      footer_function();
      ?>
     <!-- Bootstrap core JavaScript -->
     <script src="vendor/jquery/jquery.min.js"></script>
     <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 </body>
 </form>
 </html>
