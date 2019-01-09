<html>
<head>
	<title>News</title>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/news_style.css'>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/nav_style.css'>
</head>

<body>
	<?php
		error_reporting(0);
		$on_main_page = true;
		require('include/nav.php');
	?>
	<center>
		<div class = 'header-container'>
			<?php
				if(!isset($_SESSION['logged'])){
					echo '<h3 class = "news_title">You must be logged in to see the news</h3>';
				}else{
					require('include/database_connection.php');
					$query_news = mysqli_query($con, 'SELECT * FROM news ORDER BY id DESC LIMIT 30');

					while($row_news = mysqli_fetch_assoc($query_news)){

						$query_users = mysqli_query($con, 'SELECT * FROM users WHERE ign = "'.$row_news['author'].'"');
						$row_users_number = mysqli_num_rows($query_users);
						$row_users = mysqli_fetch_assoc($query_users);
						$profile_picture = $row_users['profile_picture'];

						echo '<div class = "news_header">';
							echo '<div class = "news_info">';
								echo '<h3 class = "news_title">'.htmlspecialchars($row_news['title']).'</h3>';
								if($row_users_number < 1){
									echo '<img class = profile_picture src = "images/anonymous.png">';
								}else{
									echo '<img class = profile_picture src = "'.$profile_picture.'">';
								}
								echo ' <b><a class = "profile_link" href = "profile.php?user='.$row_news['author'].'">'.htmlspecialchars($row_news['author']).'</a></b>'.' on '.$row_news['creation_date'].' - '.$row_news['creation_time'];
							echo '</div>';
							echo '<p class = "news_content">'.htmlspecialchars($row_news['content']).'</p>';
						echo '</div>';
					}
				}
			?>
		</div>
	</center>

	<?php
		require('include/footer.php');
	?>
</body>
</html>