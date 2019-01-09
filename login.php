<html>
<head>
	<title>Login</title>
	<link rel = 'stylesheet' type 'text/css' href = 'styles/login_style.css'>
</head>
<body>
	<center>
		<div class = 'login_box'>
			<form action = '' method = 'POST'>
				Username:<br>
				<input class = 'field' type = 'text' name = 'username'><br>
				Password:<br>
				<input class = 'field' type = 'password' name = 'password'><br>
				<input class = 'button' type = 'submit' name = 'submit' value = 'Login'>
			</form>
		</div>
	</center>

	<center>
	<?php
		error_reporting(0);
		session_start();
		$on_main_page = true;

		if(isset($_SESSION['logged'])){
			header('Location: index.php');
			die();
		}

		@$username = $_POST['username'];
		@$password = $_POST['password'];
		@$submit = $_POST['submit'];
		@$back_home = $_POST['back_home'];

		if(isset($submit)){

			// Check if empty username or password
			if(empty($username) || empty($password)){
				echo 'Please fill all fields';
				die();
			}

			// Require database_connection.php and check if can can connect
			require('include/database_connection.php');
			if(!$con){
				echo 'Can\'t connect to the database';
				die();
			}

			$username = mysqli_real_escape_string($con, $_POST['username']);
			$password = mysqli_real_escape_string($con, $_POST['password']);

			// Check if account exist
			$query = mysqli_query($con, 
				'SELECT * FROM users 
				WHERE BINARY username = "'.$username.'" 
				AND BINARY password = "'.$password.'"'
			);

			$row = mysqli_fetch_assoc($query);
			$rows_number = mysqli_num_rows($query);

			if($rows_number < 1){
				echo 'Incorrect username or password';
				die();
			}

			// Set session if nothing from above fails
			$_SESSION['logged'] = $username;
			$date = date('d/m/Y');

			$query = mysqli_query($con, 
				'UPDATE users 
				SET last_online = "'.$date.'" 
				WHERE username = "'.$username.'"'
			);

			header('Location: index.php');
			die();
			
		}
	?>
	</center>

</body>
</html>