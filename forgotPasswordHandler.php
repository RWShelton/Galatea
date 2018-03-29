<?php
session_start();
// if ( !isset ( $_SESSION["sessionID"] ) ){
   // header("Location: hahaNotLoggedIn.php");
// } ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Forgot Password</title>
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
$_GET['error']=TRUE;

$email;
$password;
$dbEmail;

//connect to users.db
try {
$db = new PDO("sqlite:users_DB/users.db");
$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
        die("Exception : ".$e->getMessage());
}

// if the forgot_password.php form was submitted...
if (isset($_POST["ForgotPassword"])) {

	// pull the email address if it is in the correct format
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$email = $_POST["email"];

	}
	else{
		$printStuff = "Email is not valid";
		exit;
	}

	// Check to see if this email is in the DB
	$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');

	$stmt->bindValue(':email', $email);
	$stmt->execute();
	foreach ( $stmt as $tuple ){
		$dbEmail = $tuple["email"];
	}
	$db = null;

	if ($dbEmail === $_POST["email"])
	{
		// Create the unique user password reset key
		$password = password_hash($dbEmail, PASSWORD_DEFAULT);

		// Create a url which we will direct them to reset their password
		$pwrurl = "http://10.250.94.60/~ubuntu/CRSFF/pages/reset_password.php?"."email=".$email."&q=".$password;

		// Mail them their key
		$email_from = "kchiu132@gmail.com";
		$email_subject = "CRSFF - Password Reset";
		//$headers = 'MIME-Version: 1.0';
		$headers = "From: ".$email_from;
		$mailbody = "Dear user,\n\nIf this email does not apply to you, please ignore it.\n\nYou have requested a password reset for your CRSFF account. To reset your password, please click the link below. If you cannot click it, paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
		//make sure lines are not longer than 70 characters
		$mailbody = wordwrap($mailbody,70);
		//and make sure no full stops are found at the beginning of new lines
		$email_body = str_replace("\n.", "\n..", $mailbody);

		//send out the email
		mail($dbEmail, $email_subject, $mailbody, $headers);
		//and then return the user to the search page
		// header('refresh:5; index.php');
		$printStuff = "Your password recovery key has been sent to your email address.";

	}
	else{
		// header('refresh:3; forgot_password.php');
		$printStuff = "No user with that email address exists.";
	}
}
?>
<header class="masthead text-white text-center">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-xl-9 mx-auto">
				<h1 class="mb-1"><?php echo $printStuff; ?></h1>
				<a href="http://10.250.94.60/~ubuntu/CRSFF/pages/login_page.php"><font size="3">Return to login.</font></a>
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
