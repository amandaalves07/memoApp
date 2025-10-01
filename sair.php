<?php
	require("ses_start.php");
	unset($_SESSION['idSessao']);
	session_destroy();
	header("Location: index.html"); 
?>