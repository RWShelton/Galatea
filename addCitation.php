<?php
session_start();
if ( !isset ( $_SESSION["sessionID"] ) ){
   header("Location: hahaNotLoggedIn.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<form action="addCitationHandler.php" method="post">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Citation</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </head>
  <body>
          <header class="almost-masthead text-white text-center">
            <h1 class="mb-0 pb-0">Scholarship in Classical Receptions in SF & Fantasy</h1>
          </header>
      <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Search</a>
      <!--<a class="btn btn-primary" href="#">Sign In</a>-->
        <a class="navbar-brand" href="contactUs.php">Contact Us & Suggest Scholarship</a>
      </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-1">Add Citation</h1>
        </div>
      <div class="row">

        <form method="POST" name="add_stuff" id="add_stuff">
          <div class="col-md-6 col-lg-6 mb-2 mb-md-0">
            <div class="form-group">
              <div class="form-row">
                <div class="col-12 col-lg-12 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-lg" placeholder="Section Title (Optional)" name = "title" tabindex="1">
                    <input type="text" class="form-control form-control-lg" placeholder="Source Name" name = "name" tabindex="1" required>
                </div>
                <div class="col-6 col-lg-6 mb-2 mb-md-0">
                  <!--<input type="text" class="form-control form-control-lg" placeholder="Author First Name" name = "author_fname" tabindex="4">-->
                  <input type="text" class="form-control form-control-lg" placeholder="Language" name = "language" tabindex="2" required>
                  <input type="text" class="form-control form-control-lg" placeholder="Year of Publication" name = "year_of_publication" tabindex="8" required>
                  <input type="text" class="form-control form-control-lg" placeholder="Page Start" name = "page_start" tabindex="8">
                  <input type="text" class="form-control form-control-lg" placeholder="Original Year" name = "original_year" tabindex="8">
                </div>
                <div class="col-6 col-lg-6 mb-2 mb-md-0">
                  <input type="text" class="form-control form-control-lg" placeholder="Publisher" name = "publisher" tabindex="9">
                  <input type="text" class="form-control form-control-lg" placeholder="Place of Publication" name = "place_of_publication" tabindex="8">
                  <input type="text" class="form-control form-control-lg" placeholder="Page End" name = "page_end" tabindex="8">
                  <input type="text" class="form-control form-control-lg" placeholder="Edition" name = "edition" tabindex="8">
                </div>
              </div>
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-block btn-lg btn-primary mb-5">Submit</button>
          </div>
          <div class="col-md-6 col-lg-6 mb-2 mb-md-0">
            <div class="form-group">
              <!--Dynamic Add Author Buttons-->
                <!-- <form name="add_Author" id="add_Author" method="POST"> -->
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field_Author">
                      <tr>
                        <td><button type="button" name="addAuthor" id="addAuthor" class="btn btn-success">Add More</button></td>
                        <td><input type="text" name="AuthorFirstName[]" placeholder="Author First Name" class="form-control name_list" /></td>
                        <td><input type="text" name="AuthorLastName[]" placeholder="Author Last Name" class="form-control name_list" /></td>
                      </tr>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field_Editor">
                      <tr>
                        <td><button type="button" name="addEditor" id="addEditor" class="btn btn-success">Add More</button></td>
                        <td><input type="text" name="EditorFirstName[]" placeholder="Editor First Name" class="form-control name_list" /></td>
                        <td><input type="text"name="EditorLastName[]" placeholder="Editor Last Name" class="form-control name_list" /></td>
                      </tr>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field_Translator">
                      <tr>
                        <td><button type="button" name="addTranslator" id="addTranslator" class="btn btn-success">Add More</button></td>
                        <td><input type="text" name="TranslatorFirstName[]" placeholder="Translator First Name" class="form-control name_list" /></td>
                        <td><input type="text" name="TranslatorLastName[]" placeholder="Translator Last Name" class="form-control name_list" /></td>
                      </tr>
                    </table>
                  </div>
            </div>
          </div>
        </form>

        </div>
      </div>
    </header>
    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
            <ul class="list-inline mb-2">
              <!-- <li class="list-inline-item">
                <a href="#">About</a>
              </li> -->
              <!-- <li class="list-inline-item">&sdot;</li> -->
              <li class="list-inline-item">
                <a href="contactUs.php">Contact</a>
              </li>
              <!-- <li class="list-inline-item">&sdot;</li> -->
              <!-- <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li> -->
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="login_page.php">Administration</a>
              </li>
              <?php
  									if (isset($_SESSION["sessionID"])){
  										echo "<li class=\"list-inline-item\">&sdot;</li>
  													<li class=\"list-inline-item\"><a href=\"logout.php\">Logout</a></li>
  													<li class=\"list-inline-item\">&sdot;</li>
  													<li class=\"list-inline-item\"><a href=\"addCitation.php\">Add Citation</a></li>
  													<li class=\"list-inline-item\">&sdot;</li>
  													<li class=\"list-inline-item\"><a href=\"create_account.php\">Create New Account</a></li>";
  									}
  						?>
            </ul>

          </div>
          <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item mr-3">
                <a href="https://www.facebook.com/ClassicalTraditionsScienceFiction/">
                  <i class="fa fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="https://twitter.com/CTSFMF">
                  <i class="fa fa-twitter fa-2x fa-fw"></i>
                </a>
              </li>
              <li class="list-inline-item mr-3">
                <a href="https://www.facebook.com/classicaltraditionsinmodernfantasy/">
                  <i class="fa fa-facebook fa-2x fa-fw"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</form>
</html>
<script>
$(document).ready(function(){
     var i=1;
     $('#addAuthor').click(function(){
          i++;
          $('#dynamic_field_Author').append('<tr id="row'+i+'"><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td><td><input type="text" name="AuthorFirstName[]" placeholder="Author First Name" class="form-control" /></td><td><input type="text" name="AuthorLastName[]" placeholder="Author Last Name" class="form-control" /></td></tr>');
     });
     $('#addEditor').click(function(){
          i++;
          $('#dynamic_field_Editor').append('<tr id="row'+i+'"><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td><td><input type="text" name="EditorFirstName[]" placeholder="Editor First Name" class="form-control" /></td><td><input type="text" name="EditorLastName[]" placeholder="Editor Last Name" class="form-control" /></td></tr>');
     });
     $('#addTranslator').click(function(){
          i++;
          $('#dynamic_field_Translator').append('<tr id="row'+i+'"><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td><td><input type="text" name="TranslatorFirstName[]" placeholder="Translator First Name" class="form-control" /></td><td><input type="text" name="TranslatorLastName[]" placeholder="Translator Last Name" class="form-control" /></td></tr>');
     });
     $(document).on('click', '.btn_remove', function(){
          var button_id = $(this).attr("id");
          $('#row'+button_id+'').remove();
     });
});
</script>
