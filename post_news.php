<html>
<head>
	<title>Post news</title>
	<link rel = 'stylesheet' type 'text/css' href = 'styles/post_news_style.css'>
</head>
<body>
	<center>
		<div class = 'post_news_box'>
			<form action = '' method = 'POST'>
				Title<br>
				<input class = 'field' type = 'text' name = 'title'><br>
				Content<br>
				<textarea name = 'content'></textarea><br>
				<input class = 'button' type = 'submit' name = 'submit' value = 'Post'>
			</form>
		</div>
	</center>

	<center>
	<?php
		error_reporting(0);
		session_start();
		$on_main_page = true;
		require('include/database_connection.php');
		$query = mysqli_query($con, 'SELECT * FROM users WHERE username = "'.$_SESSION['logged'].'"');
		$row = mysqli_fetch_assoc($query);

		if($row['group'] !== 'admin'){
			header('Location: index.php');
			die();
		}

		if(!isset($_SESSION['logged'])){
			header('Location: index.php');
			die();
		}

		@$title = mysqli_real_escape_string($con, $_POST['title']);
		@$content = mysqli_real_escape_string($con, $_POST['content']);
		@$submit = $_POST['submit'];
		$username = $_SESSION['logged'];

		if(isset($submit)){
			if(empty($title) || empty($content)){
				echo 'Please fill all fields';
			}else{
				$query = mysqli_query($con, 'SELECT ign FROM users WHERE username = "'.$username.'"');
				$row = mysqli_fetch_assoc($query);
				$author = $row['ign'];

				$creation_date = date('d/m/Y');
				$creation_time = date('H:i');

				$query = mysqli_query($con, 'INSERT INTO news(title, content, creation_date, creation_time, author) VALUES("'.$title.'", "'.$content.'", "'.$creation_date.'", "'.$creation_time.'", "'.$author.'")');
				if($query){
					echo 'News added';
				}else{
					echo 'There was a problem';
				}
			}
		}
	?>
	</center>

</body>
</html>