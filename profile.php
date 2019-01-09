<html>
<head>
	<title>My Profile</title>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/profile_style.css'>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/nav_style.css'>
</head>

<body>
	<?php
		error_reporting(0);
		session_start();
		$on_main_page = true;
		require('include/nav.php');

		// If not logged redirect to index.php
		if(!isset($_SESSION['logged'])){
			header('Location: index.php');
			die();
		}

		require('include/database_connection.php');
		$user = htmlspecialchars(mysqli_real_escape_string($con, $_GET['user']));

		// If empty GET redirect to profile_admin.php (personal profile)
		if(empty($user)){
			header('Location: profile_admin.php');
			die();
		}

		$query = mysqli_query($con, 'SELECT * FROM users WHERE ign = "'.$user.'"');
		$row = mysqli_fetch_assoc($query);
		$rows_number = mysqli_num_rows($query);

		// If GET is the same as logged one redirect to profile_admin.php (personal profile)
		if($_SESSION['logged'] == $row['username']){
			header('Location: profile_admin.php');
			die();
		}

		// If user not found redirect to index.php
		if($rows_number <= 0){
			header('Location: index.php');
			die();
		}
	?>
	<center>
			<div class = 'profile_wrapper'>
				<div class = 'profile_box'>
					<div class = 'profile_picture_box'>
						<?php
							$profile_picture = $row['profile_picture'];
							if(!empty($profile_picture)){
								echo '<img class = "profile_picture" src = "'.$profile_picture.'">';
							}else{
								echo '<img class = "profile_picture" src = "images/anonymous.png">';
							}
						?>
					</div>
					
					<div class = 'profile_info'>
						<?php
							$group = $row['group'];
							$ign = $row['ign'];
							$create_date = $row['create_date'];
							$last_online = $row['last_online'];
							$about_me = $row['about_me'];

							echo 'IGN: '.'<b><a href = profile.php?user='.$ign.'>'.$ign.'</a></b>';
							echo ' ['.$group.']';

							echo '<br>';
							echo 'Member since: '.$create_date;
							echo '<br>';
							echo 'Last online: '.$last_online;
							if($last_online == date('d/m/Y')){
								echo ' (today)';
							}
							echo '<br>';
							echo '<br>';
							echo 'About me: '.$about_me;
							echo '<br>';
							echo '<br>';
							echo '<a href = messenger.php?user='.$ign.' target = "_blank">Send message</a>';
						?>
					</div>
				</div>
			</div>
	</center>

	<?php
		require('include/footer.php');
	?>
</body>
</html>