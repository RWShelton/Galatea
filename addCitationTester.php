<?php
session_start();
if ( !isset ( $_SESSION["sessionID"] ) ){
   header("Location: hahaNotLoggedIn.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<form action="addCitationTesterHandler.php" method="post">
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
                <!-- </form>
                Dynamic Add Editor Buttons-->
                <!-- <form name="add_Editor" id="add_Editor" method="POST"> -->
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field_Editor">
                      <tr>
                        <td><button type="button" name="addEditor" id="addEditor" class="btn btn-success">Add More</button></td>
                        <td><input type="text" name="EditorFirstName[]" placeholder="Editor First Name" class="form-control name_list" /></td>
                        <td><input type="text"name="EditorLastName[]" placeholder="Editor Last Name" class="form-control name_list" /></td>
                      </tr>
                    </table>
                  </div>
                <!-- </form>

                <form name="add_Translator" id="add_Translator" method="POST"> -->
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field_Translator">
                      <tr>
                        <td><button type="button" name="addTranslator" id="addTranslator" class="btn btn-success">Add More</button></td>
                        <td><input type="text" name="TranslatorFirstName[]" placeholder="Translator First Name" class="form-control name_list" /></td>
                        <td><input type="text" name="TranslatorLastName[]" placeholder="Translator Last Name" class="form-control name_list" /></td>
                      </tr>
                    </table>
                  </div>
                <!-- </form> -->
                <button type="submit" name="submit" id="submit" class="btn btn-block btn-lg btn-primary mb-5">Submit</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </header>
    <!-- Footer -->
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
