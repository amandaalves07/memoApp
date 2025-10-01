<?php
	session_cache_expire(5);
	
	if(!session_start()){
		die("Não foi possível iniciar a sessão!");
	}
	if(!isset($_SESSION['idSessao'])){
		//verificando se a pessoa está entrando direto
		//redirecionando para o login
		ob_clean();
		header("Location: index.php");
	}
?>