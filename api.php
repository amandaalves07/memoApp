<?php
	header('Content-Type: application/json; charset=utf-8');
	require ("bdconnecta.php");
	if($_SERVER['REQUEST_METHOD']==='GET'){
		if($_GET['acao']=="perfilUser"){
			$id=$_GET['id'];
			$sql="SELECT nome, email, dataNasc, fotoPerfil, tel FROM usuario WHERE id=?";

		    $stmt=mysqli_prepare($conn,$sql);
		    if (!$stmt) {
		        die(json_encode(["erro"=>"Não foi possível preparar a consulta!"]));
		    }
		    if (!mysqli_stmt_bind_param($stmt, "s", $id)) {
		        die(json_encode(["erro"=>"Não foi possível vincular parâmetros!"]));
		    }
		    if (!mysqli_stmt_execute($stmt)) {
		        die(json_encode(["erro"=>"Não foi possível executar busca no Banco de Dados!"]));
		    }
		    if (!mysqli_stmt_bind_result($stmt, $nome, $email, $dataNasc, $fotoPerfil, $tel)) {
		        die(json_encode(["erro"=>"Não foi possível vincular resultados"]));
		    }
		    $fetch=mysqli_stmt_fetch($stmt);
		    if (!$fetch) {
		        die(json_encode(["erro"=>"Não foi possível recuperar dados"]));
		    }
		    if ($fetch==null) {
		        //nada foi encontrado
		        echo(json_encode(["erro"=>"Usuário não foi localizado!<br>"]));
		    } else {
		    	echo (json_encode(["nome"=>$nome, "email"=>$email, "dataNasc"=>$dataNasc, "fotoPerfil"=>$fotoPerfil, "tel"=>$tel]));
		    }
		} else if ($_GET['acao']=="login"){
			$sql="SELECT senha FROM usuario WHERE email=?";

		    $stmt=mysqli_prepare($conn,$sql);
		    if (!$stmt) {
		        die(json_encode(["erro"=>"Não foi possível preparar a consulta!"]));
		    }
		    if (!mysqli_stmt_bind_param($stmt, "s", $email)) {
		        die(json_encode(["erro"=>"Não foi possível vincular parâmetros!"]));
		    }
		    if (!mysqli_stmt_execute($stmt)) {
		        die(json_encode(["erro"=>"Não foi possível executar busca no Banco de Dados!"]));
		    }
		    if (!mysqli_stmt_bind_result($stmt, $senha)) {
		        die(json_encode(["erro"=>"Não foi possível vincular resultados"]));
		    }
		    $fetch=mysqli_stmt_fetch($stmt);
		    if (!$fetch) {
		        die(json_encode(["erro"=>"Não foi possível recuperar dados"]));
		    }
		    if ($fetch==null) {
		        //nada foi encontrado
		        echo(json_encode(["erro"=>"Usuário não foi localizado!<br>"]));
		    } else {
		    	require ("");
		    }
		}
	} else if($_SERVER['REQUEST_METHOD']==='POST'){

	} else if($_SERVER['REQUEST_METHOD']==='PUT'){

	} else if($_SERVER['REQUEST_METHOD']==='DELETE'){

	} else {
		die(json_encode(["erro"=>"Método não suportado"]));
	}
	mysqli_close($conn);
?>