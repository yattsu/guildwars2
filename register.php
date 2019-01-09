<html>
<head>
	<title>Register</title>
	<link rel = 'stylesheet' type 'text/css' href = 'styles/register_style.css'>
</head>
<body>
	<center>
		<div class = 'register_box'>
			<form action = '' method = 'POST'>
				Username: <br>
				<input class = 'field' type = 'text' name = 'register_username'><br>
				Password: <br>
				<input class = 'field' type = 'password' name = 'register_password'><br>
				Password verify: <br>
				<input class = 'field' type = 'password' name = 'register_password_verify'><br>
				Display name IGN: <br>
				<input class = 'field' type = 'text' name = 'register_ign'><br>
				Email: <br>
				<input class = 'field' type = 'text' name = 'register_email'><br>
				<input class = 'button' type = 'submit' name = 'submit' value = 'Register'>
			</form>
				<a href = 'index.php'><button class = 'home_button'><- Back home</button></a>
		</div>
	</center>

	<center>
	<?php
		error_reporting(0);
		$on_main_page = true;
		require('include/database_connection.php');

		@$register_username = mysqli_real_escape_string($con, htmlspecialchars($_POST['register_username']));
		@$register_password = mysqli_real_escape_string($con, htmlspecialchars($_POST['register_password']));
		@$register_password_verify = mysqli_real_escape_string($con, htmlspecialchars($_POST['register_password_verify']));
		@$register_ign = mysqli_real_escape_string($con, str_replace(' ', '', htmlspecialchars($_POST['register_ign'])));
		@$register_email = mysqli_real_escape_string($con, htmlspecialchars($_POST['register_email']));
		@$submit = $_POST['submit'];
		$user_ip = mysqli_real_escape_string($con, htmlspecialchars($_SERVER['REMOTE_ADDR']));
		$date = date('d/m/Y');

		if(isset($submit)){

			// Check if empty fields
			if(empty($register_username)
				|| empty($register_password)
				|| empty($register_password_verify)
				|| empty($register_ign)
				|| empty($register_email))
			{
				echo 'Please fill all fields';
				die();
			}
			
			// Check if passwords match
			if($register_password !== $register_password_verify){
				echo 'Passwords don\'t match';
				die();
			}

			// Check if username available
			$query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$register_username.'"');
			$rows_number = mysqli_num_rows($query);

			if($rows_number !== 0){
				echo 'Username already in use';
				die();
			}

			// Check if valid email
			if(strpos($register_email, '@') == false 
				|| $register_email[strpos($register_email, '@')] == $register_email[0] 
				|| $register_email[strpos($register_email, '@')] == $register_email[strlen($register_email) - 1] 
				|| strpos($register_email, '.') == false 
				|| $register_email[strpos($register_email, '.')] == $register_email[0] 
				|| $register_email[strpos($register_email, '.')] == $register_email[strlen($register_email) - 1] 
				|| strpos($register_email, ' ') == true){

				echo 'Email not valid';
				die();
			}

			// Check if email available
			$query = mysqli_query($con, 'SELECT * FROM users WHERE email = "'.$register_email.'"');
			$rows_number = mysqli_num_rows($query);

			if($rows_number !== 0){
				echo 'Email already in use';
				die();
			}

			// Check if IGN available
			$query = mysqli_query($con, 'SELECT * FROM users WHERE ign = "'.$register_ign.'"');
			$rows_number = mysqli_num_rows($query);

			if($rows_number !== 0){
				echo 'IGN already in use';
				die();
			}

			// Check if IP is not already in the table
			$query = mysqli_query($con, 'SELECT * FROM users WHERE ip = "'.$user_ip.'"');
			$rows_number = mysqli_num_rows($query);

			if($rows_number !== 0){
				echo 'You can\'t create more accounts';
				die();
			}

			// Insert into database if nothing from above fails
			$query = mysqli_query($con, 
				'INSERT INTO 
				users (username, password, ign, email, create_date, ip) 
				VALUES ("'.$register_username.'", "'.$register_password.'", "'.$register_ign.'", "'.$register_email.'", "'.$date.'", "'.$user_ip.'")'
			);

			// Display if successfully query
			if(!$query){
				echo 'Something went wrong. Account not registered';
			}else{
				echo 'You successfully registered an account';
			}

		}
	?>
	</center>

</body>
</html>