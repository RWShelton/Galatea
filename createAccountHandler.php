<?php
$_GET['error']=TRUE;

$errors="";
$values="";
$isEmailValid = true;
$isPasswordValid = true;
$isConfirmValid = true;

//check if email field is empty and check if it's in the correct format
if ( empty($_POST["email"]) ){
	$isEmailValid = false;
	$errors.='email=required&';
}else{
	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
		$isEmailValid = false;
		$errors.='email=invalid&';
	}
 }

if ( $_POST["pwd"] == null){
	$isPasswordValid = false;
	$errors.='pwd=invalid&';
}

//confirm must not be null and must match the entered password
if ( empty($_POST["confirm"]) ){
	$isConfirmValid = false;
	$errors.='confirm=required&';
}
if ( $_POST["confirm"] !== $_POST["pwd"] ){
	$isConfirmValid = false;
	$errors.='confirm=invalid&';
}



if($isEmailValid and $isPasswordValid and $isConfirmValid)
{
	try {
	$db = new PDO ("sqlite:users_DB/users.db");
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$email = $_POST["email"];
	$pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
	$stmt = $db->prepare("insert into users (email, password) VALUES (:email, :pwd)");

	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':pwd', $pwd);


	$stmt->execute();
	$db = null;
	header('Location: http://10.250.94.60/~ubuntu/CRSFF/pages/login_page.php?');
	echo "Account created!";
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
if($isConfirmValid)
{
	$values.="confirm=" . $_POST["confirm"] . "&";
}

header('Location: http://10.250.94.60/~ubuntu/CRSFF/pages/create_account.php?' . $errors . $values);


?>
