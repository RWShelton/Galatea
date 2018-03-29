<?php
	session_start();
	if (isset($_SESSION['sessionID']) ){
		header('location: redirect.php');
	}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin: Log-in</title>

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
<?php
// $email = $_GET["email"];
// $hash;
// $id;
// $dbEmail;

// //if email is valid
// if( $isEmailValid ){

	// //search it in the DB and check the entered password against the DB entry
	// try {
		// $db = new PDO ("sqlite:users_DB/users.db");
		// $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// //retrieve the password
		// $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
		// $stmt->bindValue(':email', $email);
		// $stmt->execute();

		// foreach($stmt as $tuple){
			// $dbEmail = $tuple['email'];
			// $hash = $tuple["password"];
			// $id = $tuple["id"];
		// }

		// //start a session if the password is verified
		// if( password_verify($_POST["pwd"], $hash) ){
			// $_SESSION["sessionID"] = $id;
		// }
		// if( !password_verify($_POST["pwd"], $hash) and $_POST["pwd"] != null ){
			// echo "Incorrect password";
		// }
	// }catch (PDOException $e) {
			// die("Exception : " .$e->getMessage());
	// }
// }
?>

<form action="loginHandler.php" method="post">

    <!-- Masthead -->

    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-1">Welcome!</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <form>
                <div class="col-12 col-md-12 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-lg" placeholder="Email Address" name = "email" required><br/>
					<!--<?php
					if($_GET["email"]==="invalid"){
						echo "<br>"."Email Address is invalid";
					}
					?>-->

                    <input type="password" class="form-control form-control-lg" placeholder="Password" name="pwd" required><br/>
                    <span class="psw"><font size="3">Forgot</font>
						<a href="forgot_password.php"><font size="3">password?</font></a><br/><br/>
					</span>
                </div>
                <div class="col-12 col-md-12">
                    <button type="submit" class="btn btn-block btn-lg btn-primary" align="center">Login</button>
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
<?php
?>
