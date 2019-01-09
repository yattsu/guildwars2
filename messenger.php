<html>
<head>
	<title>Messenger</title>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/messenger_style.css'>

	<script>
		function scroll(){
			window.scrollTo(0, document.body.scrollHeight);
		}

		var timer;
		timer = 0;
		function keyChange(){
			var fieldValue = document.getElementById('field').value;
			clearTimeout(timer);
			if(fieldValue.length > 0){
				timer = setTimeout(refresh, 180000);
			}

			if(fieldValue.length == 0){
				timer = setTimeout(refresh, 3000);
			}

			window.scrollTo(0, document.body.scrollHeight);
		}

		function refresh(){
			location.reload();
			window.scrollTo(0, document.body.scrollHeight);
		}

		window.onload = keyChange;
	</script>
</head>
<body>
	<?php
		session_start();
		$on_main_page = true;
		require('include/database_connection.php');
		$user = strtolower(mysqli_real_escape_string($con, $_GET['user']));
		$session = strtolower($_SESSION['logged']);

		// If not logged redirect to index.php
		if(!isset($_SESSION['logged'])){
			header('Location: index.php');
			die();
		}

		// If GET user is empty redirect to index.php
		if(empty($_GET['user'])){
			header('Location: index.php');
			die();
		}

		// If GET user doesn't exist in the database redirect to index.php
		$query = mysqli_query($con, 'SELECT * FROM users WHERE ign = "'.$user.'"');
		$rows_number = mysqli_num_rows($query);
		if($rows_number < 1){
			header('Location: index.php');
			die();
		}

		// If IGN of the current user is the same as the GET user redirect to index.php
		$query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$session.'"');
		$row = mysqli_fetch_assoc($query);
		$ign = $row['ign'];
		if(strtolower($user) == strtolower($ign)){
			header('Location: index.php');
			die();
		}

		// Check how the table should be called
		$table_name1 = $ign.'_'.$user;
		$table_name2 = $user.'_'.$ign;
		$create_table1 = mysqli_query($con, 'SELECT * FROM '.$table_name1.'');
		$create_table2 = mysqli_query($con, 'SELECT * FROM '.$table_name2.'');

		if(!$create_table1 && !$create_table2){
			$query = mysqli_query($con, 'CREATE TABLE '.$table_name1.' 
				(
				id int NOT NULL AUTO_INCREMENT, 
				author varchar(50) NOT NULL, 
				message varchar(200) NOT NULL, 
				send_date varchar(20) NOT NULL, 
				send_time varchar(20) NOT NULL,
				PRIMARY KEY (id)
				)
			');
		}

		$check_table1 = mysqli_query($con, 'SELECT * FROM '.$table_name1.'');
		$check_table2 = mysqli_query($con, 'SELECT * FROM '.$table_name2.'');

		$table = $check_table1 ? $table_name1 : $table_name2;

		$query = mysqli_query($con, 'SELECT * FROM '.$table.' ORDER BY id');
		$rows_number = mysqli_num_rows($query);
		if($rows_number < 1){
			echo 'no messages';
		}else{
			echo '<div class = messages_container>';
				while($row = mysqli_fetch_assoc($query)){
					$author = htmlspecialchars($row['author']);
					$message = htmlspecialchars($row['message']);
					$send_time = $row['send_time'];
					
					if($ign == $author){
						echo '<div class = "right">';
							echo htmlspecialchars('<'.$row['author'].'> ');
							echo $message;
							echo '<br>';
						echo '</div>';
					}else{
						echo '<div class = "left">';
							echo htmlspecialchars('<'.$row['author'].'> ');
							echo $message;
							echo '<br>';
						echo '</div>';
					}
				}
				echo '<div class = "divider">';
				echo '</div>';
			echo '</div>';
		}
	?>

	<div class = 'message_box'>
		<form action = '' method = 'POST'>
			root@<?php
				$query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$session.'"');
				$row = mysqli_fetch_assoc($query);

				echo $row['ign'];
			?>:~#
			<input onkeydown = 'keyChange()' id = 'field' class = 'field' type = 'text' name = 'message' maxlength = '200' autocomplete = 'off' autofocus>
			<input class = 'button' type = 'submit' name = 'submit' value = 'Send'>
		</form>
	</div>

	<?php
		@$message = mysqli_real_escape_string($con, $_POST['message']);
		@$submit = $_POST['submit'];

		if(isset($submit) && !empty($message)){
			if(strlen($message) > 200){
				echo 'Message too long (limit: 200)';
			}else{
				$send_date = date('d/m/Y');
				$send_time = date('H:i');

				$query = mysqli_query($con, 'INSERT INTO '.$table.' 
					(author, message, send_date, send_time) 
					VALUES ("'.$ign.'", "'.$message.'", "'.$send_date.'", "'.$send_time.'")
				');
			}
		}
	?>
</body>
</html>