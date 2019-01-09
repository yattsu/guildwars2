<html>
<head>
	<title>Guild Wars 2</title>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/index_style.css'>
	<link rel = 'stylesheet' type = 'text/css' href = 'styles/nav_style.css'>
</head>

<body>
	<!-- REQUIRE floatingLinks.php -->
	<?php
		error_reporting(0);
		$on_main_page = true;

		require('include/floatingLinks.php'); 
		require('include/nav.php');
	?>
	
	<center>
		<div class = 'banner' id = 'banner'>
		</div>

		<div class = 'header-container'>

		<?php
			require('include/stream.php');
		?>

			<div class = 'header_content_wrapper'>
				<div class = 'header_content'>
					<div class = 'header'>
						<h3>Info</h3>
						<hr>
							<p>Guild Wars 2 is a massively multiplayer online role-playing game developed by ArenaNet and published by NCSOFT. Set in the fantasy world of Tyria, the game follows the re-emergence of Destiny's Edge, a disbanded guild dedicated to fighting the Elder Dragons, a Lovecraftian species that has seized control of Tyria in the time since the original Guild Wars. The game takes place in a persistent world with a story that progresses in instanced environments.</p>

							<p>It claims to be unique in the genre by featuring a storyline that is responsive to player actions, something which is common in single player role-playing games but rarely seen in multiplayer ones. A dynamic event system replaces traditional questing, utilising the ripple effect to allow players to approach quests in different ways as part of a persistent world. Also of note is the combat system, which aims to be more dynamic than its predecessor by promoting synergy between professions and using the environment as a weapon, as well as reducing the complexity of the Magic-style skill system of the original game.</p>
					</div>

					<div class = 'header'>
						<h3>Gameplay</h3>
						<hr>
						<p>Guild Wars 2 uses a heavily modified version of the proprietary game engine developed for Guild Wars by ArenaNet. The modifications to the engine include real-time 3D environments, enhanced graphics and animations and the use of the Havok physics system. The developers say the engine now does justice to the game's critically acclaimed concept art, and that concept art will be integrated into the way the story is told to the player.</p>

						<p>The game allows a player to create a character from a combination of five races and eight professions, the five races being the humans and charr, introduced in Prophecies, the asura and norn, introduced in Eye of the North, and the sylvari, a race exclusive to Guild Wars 2. The professions, three of which do not appear in Guild Wars, are divided into armor classes: "scholars" with light armor, "adventurers" with medium armor, and "soldiers" with heavy armor. There is no dedicated healing class as the developers felt that making it necessary for every party to have a healer was restrictive.</p>
					</div>
				</div>
			</div>


			<div class = 'news_wrapper'>
				<div class = 'news_content_wrapper'>
					<div class = 'news'>
						<h3>Latest News</h3>
						<hr>
						<?php
							require('include/latest_news.php');
						?>
					</div>
				</div>
			</div>
		</div>
	</center>

	<?php
		require('include/footer.php');
	?>
</body>
</html>