<html>
<head>
	<title>Members</title>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/members_style.css'>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/nav_style.css'>
</head>

<body>
	<?php
		error_reporting(0);
		session_start();
		$on_main_page = true;
		require('include/nav.php');
		require('include/database_connection.php');
	?>
	<center>
			<div class = 'members_wrapper'>
				<div class = 'members_container'>
					<div class = 'members'>
						<div class = 'search_box_container'>
							<div class = 'search_box'>
								<form action = '' method = 'POST'>
									<input class = 'field' type = 'text' name = 'member_search'>
									<input class = 'button' type = 'submit' name = 'submit' value = 'Search'>
								</form>
							</div>
								<?php
									@$member_search = htmlspecialchars(mysqli_real_escape_string($con, str_replace(' ', '', $_POST['member_search'])));
									@$submit = $_POST['submit'];

									if(isset($submit) && !empty($member_search)){
										echo '<div class = "search_box_result_container">';
											$query = mysqli_query($con, 'SELECT * FROM users WHERE ign LIKE "%'.$member_search.'%"');
											$row_number = mysqli_num_rows($query);
											if($row_number > 0){
												while($row = mysqli_fetch_assoc($query)){
													echo '<a class = "member_name" href = profile.php?user='.$row['ign'].'>';
														echo '<div class = "search_box_result">';
																if(!empty($row['profile_picture'])){
																	echo '<img class = "search_box_profile_picture" src = "'.$row['profile_picture'].'">';
																}else{
																	echo '<img class = "search_box_profile_picture" src = "images/anonymous.png">';
																}

															echo ' <b>'.$row['ign'].'</b>';
															echo ' ['.$row['group'].']';
														echo '</div>';
													echo '</a>';
												}
											}else{
												echo 'No member found';
											}
										echo '</div>';
									}
								?>
						</div>	

						<h3>Members</h3>
						<hr>
						<?php
							$query = mysqli_query($con, 'SELECT * FROM users ORDER BY id DESC');
							while($row = mysqli_fetch_assoc($query)){

								echo '<div class = "member_box">';
									echo '<div class = "profile_picture_box">';
											$profile_picture = $row['profile_picture'];
											if(!empty($profile_picture)){
												echo '<img class = "profile_picture" src = "'.$profile_picture.'">';
											}else{
												echo '<img class = "profile_picture" src = "images/anonymous.png">';
											}
									echo '</div>';
									
									echo '<div class = "member_info">';
											$group = $row['group'];
											$ign = $row['ign'];

											echo '<b><a class = "member_name" href = profile.php?user='.$ign.'>'.$ign.'</a></b>';
											echo ' ['.$group.']';
									echo '</div>';
								echo '</div>';

							}
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