<?php 
	$conn = mysqli_connect("localhost","root","130956Ev@","23042");

	if(!$conn){
		//echo(mysqli_connect_error());
		die("<br>Não foi possível conectar ao banco de dados");
	}
	date_default_timezone_set('Brazil/East');
	mysqli_query($conn, "SET NAMES 'utf8'");
?>