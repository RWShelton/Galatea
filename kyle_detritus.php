
<!DOCTYPE html>



<h2>Create an account</h2>



	Email Address:<br/><input type="text" name="email" required <?php
		if($_GET["emailvalue"] != null){
			echo 'value =' . trim($_GET["emailvalue"], "/");
		}
		?> />
		<?php
		if($_GET["email"]==="invalid"){
			echo "<br>"."Email format is invalid";
		}
		?> <br/><br/>

	Password:<br/><input type="password" name="pwd" required <?php
		if($_GET["passwordvalue"] != null){
			echo 'value =' . trim($_GET["passwordvalue"], "/");
		} ?> />
		<?php
		if($_GET["pwd"]==="invalid"){
			echo "<br>"."This is a required field";
		}
		?> <br/><br/>

	Confirm Password:<br/><input type="password" name="confirm" required <?php
		if($_GET["confirmvalue"] != null){
			echo 'value =' . trim($_GET["confpassvalue"], "/");
		}

		?> />
		<?php
		if($_GET["confirm"]==="required"){
			echo "<br>"."This is a required field";
		}
		if($_GET["confirm"]==="invalid"){
			echo "<br>"."Paswords do not match";
		} ?> <br/><br/>

	<button type="submit">Create Account</button>
	<br/><br/>
	<a href="http://10.250.94.60/~ubuntu/CRSFF/pages/login_page.php"><font size="2" color="white">Return to login</font></a>

</html>
