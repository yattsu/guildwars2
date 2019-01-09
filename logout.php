<?php
	error_reporting(0);
	session_start();

	if(!isset($_SESSION['logged'])){
		header('Location: index.php');
		die();
	}

	session_unset();
	session_destroy();
	header('Location: index.php');
	die();
?>