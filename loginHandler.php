<?php
session_start();

if ( isset($_SESSION["sessionID"]) ){
	header('location: index.php');
}

$_GET['error']=TRUE;
$errors="";
$values="";
$hash;
$id;
$dbEmail;
$email=$_POST["email"];
$isEmailValid = true;
$isPasswordValid = true;

//check if email field is empty; if not, check if input is in correct format
if ( empty($_POST["email"]) ){
	$isEmailValid = false;
	$errors.='email=required&';
}else{
	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$isEmailValid = false;
		$errors.='email=invalid&';
	}
}

if ( empty($_POST["pwd"]) ){
	$isPasswordValid = false;
	$errors.='pwd=required&';
}

//if email is valid
if( $isEmailValid ){
	
	//search it in the DB and check the entered password against the DB entry
	try {
		$db = new PDO ("sqlite:users_DB/users.db");
		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		//retrieve the password 
		$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		
		foreach($stmt as $tuple){
			$dbEmail = $tuple['email'];
			$hash = $tuple['password'];
			$id = $tuple["id"];
		}
		
		//start a session if the password is verified
		if( password_verify($_POST["pwd"], $hash) ){
			$_SESSION["sessionID"] = $id;
			header('Location: index.php');
		}
		if( !password_verify($_POST["pwd"], $hash) and $_POST["pwd"] != null ){
			header('refresh:3; login_page.php');
			echo "Incorrect password";
		}
	}catch (PDOException $e) {
			die("Exception : " .$e->getMessage());
	}
}

if($isEmailValid)
{
	$values.="email=" . $_POST["email"] . "&";
}
if($isPasswordValid)
{
	$values.="pwd=" . $_POST["pwd"] . "&";
}

//header('Location: http://10.250.94.60/~ubuntu/CRSFF/pages/index.php');
//header('location: http://10.250.94.60/~ubuntu/CRSFF/pages/login_page.php?' . $values);

?>