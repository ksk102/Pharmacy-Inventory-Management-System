<?php
	require_once '../php_function/general.php'; //general php function

	session_start();

	if(session_destroy()) // Destroying All Sessions
	{
		$conn->close();
		header("Location: ../index.php"); // Redirecting To Home Page
	}
?>