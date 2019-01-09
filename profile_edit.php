<html>
<head>
	<title>Profile edit</title>
	<link rel = 'stylesheet' type 'text/css' href = 'styles/login_style.css'>
</head>
<body>
	<?php
		error_reporting(0);
		session_start();
		$on_main_page = true;
		if(!isset($_SESSION['logged'])){
			header('Location: index.php');
			die();
		}

		require('include/database_connection.php');
		$query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$_SESSION['logged'].'"');
		$rows_number = mysqli_num_rows($query);
		if($rows_number <= 0){
			header('Location: index.php');
			die();
		}

		$row = mysqli_fetch_assoc($query);
		$group = $row['group'];
		$ign = $row['ign'];
		$create_date = $row['create_date'];
		$last_online = $row['last_online'];
		$about_me = $row['about_me'];
	?>

	<center>
		<div class = 'profile_edit_box'>
			<?php
				echo '<form action = "" method = "POST">';
					echo 'Current ign: '.$ign;
					echo '<br>';
					echo '<input class = "field" type = "text" name = "update_ign">';
					echo '<input class = "edit_button" type = "submit" name = "submit_ign" value = "Change">';
					echo '<br>';
					echo 'About me';
					echo '<br>';
					echo '<textarea name = "update_about_me"></textarea>';
					echo '<input class = "edit_button" type = "submit" name = "submit_about_me" value = "Change">';
					echo '<br>';
					echo 'Profile picture url';
					echo '<br>';
					echo '<input class = "field" type = "text" name = "update_profile_picture">';
					echo '<input class = "edit_button" type = "submit" name = "submit_profile_picture" value = "Change">';
				echo '</form>';
				echo '<a href = "index.php"><button class = "home_button"><- Back home</button></a>';

				@$update_ign = mysqli_real_escape_string($con, str_replace(' ', '', htmlspecialchars($_POST['update_ign'])));
				@$update_about_me = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_about_me']));
				@$update_profile_picture = mysqli_real_escape_string($con, htmlspecialchars($_POST['update_profile_picture']));

				if(isset($_POST['submit_ign']) && !empty($update_ign)){
					// $query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$_SESSION['logged'].'"');
					// $row = mysqli_fetch_assoc($query);

					if(strtolower($update_ign) == strtolower($row['ign'])){
						echo 'The new IGN can\'t be the same as the old one';
					}else{
						$query = mysqli_query($con, 'SELECT * FROM users WHERE ign = "'.$update_ign.'"');
						$rows_number = mysqli_num_rows($query);

						if($rows_number > 0){
							echo 'The ign is already taken';
						}else{
							$query = mysqli_query($con, 'UPDATE users SET ign = "'.$update_ign.'" WHERE username = "'.$_SESSION['logged'].'"');
							if(!$query){
								echo 'Something went wrong. ign not changed';
							}else{
								echo 'You successfully changed your ign';
							}
						}
					}
				}

				if(isset($_POST['submit_about_me']) && !empty($update_about_me)){
					$query = mysqli_query($con, 'UPDATE users SET about_me = "'.$update_about_me.'" WHERE username = "'.$_SESSION['logged'].'"');
					if(!$query){
						echo 'Something went wrong. About me not changed';
					}else{
						echo 'You successfully changed your "About me"';
					}
				}

				if(isset($_POST['submit_profile_picture']) && !empty($update_profile_picture)){
					$url_characters = strlen($update_profile_picture);
					if(
						$update_profile_picture[$url_characters - 4] == '.'
						&& $update_profile_picture[$url_characters - 3] == 'j'
						&& $update_profile_picture[$url_characters - 2] == 'p'
						&& $update_profile_picture[$url_characters - 1] == 'g' 
						||
						$update_profile_picture[$url_characters - 4] == '.'
						&& $update_profile_picture[$url_characters - 3] == 'p'
						&& $update_profile_picture[$url_characters - 2] == 'n'
						&& $update_profile_picture[$url_characters - 1] == 'g' 
						||
						$update_profile_picture[$url_characters - 4] == '.'
						&& $update_profile_picture[$url_characters - 3] == 'g'
						&& $update_profile_picture[$url_characters - 2] == 'i'
						&& $update_profile_picture[$url_characters - 1] == 'f')
					{
						$query = mysqli_query($con, 'UPDATE users SET profile_picture = "'.$update_profile_picture.'" WHERE username = "'.$_SESSION['logged'].'"');
						if(!$query){
							echo 'Something went wrong. Profile picture not changed';
						}else{
							echo 'You successfully changed your profile picture';
						}
					}else{
						echo 'Only JPG, PNG and GIF allowed';
					}
				}
			?>
		</div>
	</center>
</body>
</html>