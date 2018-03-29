<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<form action="thank_you.php" method="post">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Contact Us</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
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
<div class="container">
  <div class="row">
    <div class="col-xl-9 mx-auto">
      <h1 class="mb-3 mt-3">Contact us!</h1>
    </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
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


<!-- Not sure if we need this, but I'm leaving it in just in case?-->
<script language="JavaScript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("myemailform");
frmvalidator.addValidation("name","req","Please provide your name");
frmvalidator.addValidation("email","req","Please provide your email");
frmvalidator.addValidation("email","email","Please enter a valid email address");
</script>
</body>
</html>


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
