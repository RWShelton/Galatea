<?php
session_start();
include "header_footer_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
  <form action="thank_you.php" method="post">
  <?php header_function(); ?>
    <body>
      <div class="container">
          <div class="row">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
              <div class = "text-center">
                <h1 class="mb-3 mt-3">Contact us!</h1>
              </div>
              <form method="post" name="myemailform" action="form-to-email.php">
                <div class="form-row">
                  <div class="col-12 col-md-12 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-lg" placeholder="Name" name = "name" tabindex="1">
                    <input type="text" class="form-control form-control-lg" placeholder="Email" name = "email" tabindex="2">
                    <textarea type="text" class="form-control form-control-lg" rows="7" placeholder="Enter your message or suggestion here." name = "message" tabindex="3"></textarea>
                  </div>
                  <div class="col-12 col-md-12">
                    <button type="submit" class="btn btn-block btn-lg btn-primary" align="center" name = "submit">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>
  </form>
</html>
