<?php
	$formOK=true;
	if(isset($_POST["token"])){
		$token=$_POST["token"];
	}
	if(isset($_POST["senhaNova1"])){
		$senhaNova1=$_POST["senhaNova1"];
	}
	if(isset($_POST["senhaNova2"])){
		$senhaNova2=$_POST["senhaNova2"];
	}
	if(empty($senhaNova1) || empty($senhaNova2)){
		echo ("Preencha corretamente as senhas!");
		$formOK=false;
	}
	if(empty($token)){
		echo("Token não informado!");
		$formOK=false;
	}

	require ("cryp2graph.php");

	if(!validarFormatoSenha($senhaNova2)){
		$formOK=false;
		echo("A senha não está no formato exigido! <br>");
	}

	if (!$formOK){
		echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
		die("<br>Verifique os erros indicados acima!!");
	}

	if($senhaNova1!==$senhaNova2) {
	    die("As senhas não conferem!");
	}

	require ("bdconnecta.php");

	$sql="SELECT id, senha, validadeToken FROM usuario WHERE tokenDeRedefinicao=?";
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		die("Não foi possível preparar a consulta!");
	}
	if (!mysqli_stmt_bind_param($stmt, "s", $token)) {
		die("Não foi possível vincular parâmetros!");
	}
	if (!mysqli_stmt_execute($stmt)) {
		die("Não foi possível executar busca no Banco de Dados!");
	}
	if (!mysqli_stmt_bind_result($stmt, $id, $senhaBD, $validadeToken)) {
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
		echo("Usuário não localizado! <br>");
		die("Retorne para a <a href='login01.php'>página de login</a>!");
	}

	if (strtotime($validadeToken)<=time()) {
	    die("Link expirado");
	}

	if(ChecaSenha($senhaNova2, $senhaBD)) {
    	die('A nova senha não pode ser igual à senha atual!<br><button onclick="history.go(-1);">Voltar</button>!');
	}

	if(PermiteSenha($id, $senhaNova2)){
		$cadOK=true;
		//se não foi usada, cadastrar na tabela de pessoas
		$senha=FazSenha($id, $senhaNova2);
		$sql="UPDATE usuario SET senha=? WHERE id=?";
		$stmt=mysqli_prepare($conn,$sql);
		if (!$stmt){
			die("Não foi possível preparar o cadastro!");
		}
		if (!mysqli_stmt_bind_param($stmt, "ss", $senha, $id)){
			die("Não foi possível vincular parâmetros!");
		}
		if (!mysqli_stmt_execute($stmt)){
			die("Não foi possível cadastrar a nova senha no BD!".mysqli_error($conn)); 
			$cadOK=false;
		}
		if(!$cadOK){
			die("Não foi possível inserir dados de senha para esta pessoa! Verifique!");
		}
		if (!mysqli_stmt_close($stmt)){
			echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
			//mandar email/sms/alerta para o programador
		}

		//agora, atualizar na tabela de senhas
		$sql2="INSERT INTO senhasantigas (id, senhaAnt) VALUES (?,?)";
		$stmt2=mysqli_prepare($conn,$sql2);
		if (!$stmt2){
			die("Não foi possível preparar o cadastro!");
		}
		if (!mysqli_stmt_bind_param($stmt2, "ss", $id, $senha)){
			die("Não foi possível vincular parâmetros!");
		}
		if (!mysqli_stmt_execute($stmt2)){
			die("Não foi possível cadastrar a nova senha no BD!".mysqli_error($conn)); 
			$cadOK=false;
		}
		if(!$cadOK){
			die("Não foi possível inserir dados de senha para esta pessoa! Verifique!");
		}
		if (!mysqli_stmt_close($stmt2)){
			echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
			//mandar email/sms/alerta para o programador
		}
		echo("Senha alterada com sucesso! <a href='login01.html'>Faça o login</a>! <br>");

		//apagando senhas antigas da tabela de senhas antigas
		ApagarSenhasAnt($id);
	} else {
		echo ("A senha nova não pode ser igual a uma senha usada anteriormente! <br>");
		die('<button onclick="history.go(-1);">Voltar</button>');
	}
?>