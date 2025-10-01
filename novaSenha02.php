<?php 
	$formOK=true;

	if (isset($_POST['email'])){
		$email=$_POST['email'];
	}
	if (empty($email)){
		$formOK=false;
		echo("Preencha o e-mail <br>");
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		echo ("O email informado não é válido <br>");
  		$formOK=false;
	}

	if (!$formOK){
		echo('<button onclick="history.go(-1);">Voltar</button><br>');
		die("<br>Verifique os erros indicados acima!!");
	}

	require ("bdconnecta.php");
	require ("cryp2graph.php");
	require ("email.php");

	$sql="SELECT id, nome FROM usuario WHERE email=?";
	$stmt = mysqli_prepare($conn,$sql);
	if (!$stmt) {
		die("Não foi possível preparar a consulta!");
	}
	if (!mysqli_stmt_bind_param($stmt, "s", $email)) {
		die("Não foi possível vincular parâmetros!");
	}
	if (!mysqli_stmt_execute($stmt)) {
		die("Não foi possível executar busca no Banco de Dados!");
	}
	if (!mysqli_stmt_bind_result($stmt, $id, $nome)) {
		die("Não foi possível vincular resultados");
	}
	$fetch=mysqli_stmt_fetch($stmt);
	if (!$fetch) {
		die("Não foi possível recuperar dados");
	}
	if (!mysqli_stmt_close($stmt)) {
		echo("Não foi possível efetuar limpeza da conexão. Avise o setor de TI");
		// Mandar email/sms/alerta para o Programador
	}

	if($fetch==null){
		echo("E-mail não localizado! <br>");
		die("Retorne para a <a href='index.php'>página de login</a>!");
	} else {
		$tokenDeRedefinicao=CriaAlgo(8);
		$validadeToken=date("Y-m-d H:i:s", time()+60*30);
		$message="Clique <a href='http://localhost/memo/novaSenha03.php?t=$tokenDeRedefinicao'>aqui</a> para redefinir sua senha";

		$resultadoEmail=mandarEmail($nome, $email,"Recuperação de Senha",$message);
		if (!$resultadoEmail){
			die("Não foi possível enviar e-mail com nova senha");
		}

		//inserino token e validade do token no banco de dados
		$sql2="UPDATE usuario SET tokenDeRedefinicao=?, validadeToken=? WHERE id=?";
		$stmt2=mysqli_prepare($conn,$sql2);
		if (!$stmt2) {
			die("Não foi possível preparar a consulta!");
		}
		if (!mysqli_stmt_bind_param($stmt2, "sss", $tokenDeRedefinicao, $validadeToken, $id)) {
			die("Não foi possível vincular parâmetros!");
		}
		if (!mysqli_stmt_execute($stmt2)) {
			die("Não foi possível executar busca no Banco de Dados!");
		}
		if (!mysqli_stmt_close($stmt2)) {
			echo("Não foi possível efetuar limpeza da conexão. Avise o setor de TI");
			// Mandar email/sms/alerta para o Programador
		}

		echo('Link para redefinição de senha enviado! Verifique sua caixa de entrada (e também o SPAM, etc.)! <br>
			<a href="index.php">Voltar para a página inicial</a>');
	}
?>