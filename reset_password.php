<?php
session_start();
// if ( !isset ( $_SESSION["sessionID"] ) ){
   // header("Location: hahaNotLoggedIn.php");
// } ?>
<!DOCTYPE html>
<html lang="en">
<form action = "resetPasswordHandler.php" method="post">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reset Password</title>
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


<!-- Masthead -->
<!---CODE NOT FINISHED, JUST REFORMATTING-->
<header class="masthead text-white text-center">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-xl-9 mx-auto">
				<h1 class="mb-5">Reset Password</h1>
			</div>
			<div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
				<form>
					<div class="form-row">
						<div class="col-12 col-md-12 mb-md-3">
								<?php
									echo '<input type="hidden" name="email" value="';
									if (isset($_GET["email"]) ){
										echo $_GET["email"];
									}
									echo '" />';
								?>
						</div>
						<div class="col-12 col-md-12 mb-md-3">
								<input class="form-control form-control-lg" placeholder="Password" type="password" name="pwd" required><br/>
						</div>
						<div class="col-12 col-md-12 mb-md-3">
								<input class="form-control form-control-lg" placeholder="Confirm Password" type="password" name="confirm" required><br/>
						</div>
						<div class="col-12 col-md-12 mb-md-3">
							<?php
								echo '<input type="hidden" name="q" value="';
								if (isset($_GET["q"]) ){
									echo $_GET["q"];
								}
								echo '" />'
							?>
						</div>
						<div class="col-12 col-md-12">
								<button type="submit" name="ResetPasswordForm" class="btn btn-block btn-lg btn-primary" align="center">Reset Password</button><br/>
								<a href="http://10.250.94.60/~ubuntu/CRSFF/pages/login_page.php"><font size="3">Return to login</font></a>
						</div>

					</div>
				</form>

			</div>
		</div>
	</div>
</header>


  <!-- Footer -->
	<footer class="footer bg-light">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 h-100 text-center text-lg-left my-auto">
					<ul class="list-inline mb-2">
						<li class="list-inline-item">
							<a href="contactUs.php">Contact</a>
						</li>
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
													<li class=\"list-inline-item\"><a href=\"addKeyword.php\">Add Keywords</a></li>
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
