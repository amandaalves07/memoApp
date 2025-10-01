<?php
	require ("ses_start.php");
	$id=$_SESSION['id'];

	$formOK=true;
	if(isset($_POST['id'])){
		$id=$_POST['id'];
	}
	if(isset($_POST['senhaAntiga'])){
		$senhaAntiga=$_POST['senhaAntiga'];
	}
	if(isset($_POST['senhaNova1'])){
		$senhaNova1=$_POST['senhaNova1'];
	}
	if(isset($_POST['senhaNova2'])){
		$senhaNova2=$_POST['senhaNova2'];
	}

	if (empty($_POST['id'])) {
		$formOK=false;
	}
	if (empty($_POST['senhaAntiga']) || empty($_POST['senhaNova1']) || empty($_POST['senhaNova2'])){
		$formOK=false;
		echo("Preencha corretamente as senhas! <br>");
	}

	if($senhaNova1!==$senhaNova2){
		$formOK=false;
		echo("As senhas não conferem!");
	}

	require ("cryp2graph.php");

	//verificando formatação da senha
	if(!validarFormatoSenha($senhaNova2)){
		$formOK=false;
		echo(validarFormatoSenha($senhaNova2) ."<br>");
	}

	//verificando se a senha atual está correta
	if(!senhaAtualEstaCorreta($id, $senhaAntiga)){
		$formOK=false;
		echo("Senha atual não confere!");
	}

	if (!$formOK){
		echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
		die("<br>Verifique os erros indicados acima!!");
	}

	//verificando se a senha nova já foi usada ou não
	if(PermiteSenha($id, $senhaNova2)){
		$cadOK=true;
		//se não foi usada, cadastrar na tabela de senhas
		$senha=FazSenha($id, $senhaNova2);

		require ("bdconnecta.php");

		$sql="INSERT INTO senhasantigas (id, senhaAnt) VALUES (?,?)";
		$stmt=mysqli_prepare($conn,$sql);
		if (!$stmt){
			die("Não foi possível preparar o cadastro!");
		}

		if (!mysqli_stmt_bind_param($stmt, "ss", $id, $senha)){
			die("Não foi possível vincular parâmetros!");
		}

		if (!mysqli_stmt_execute($stmt)){
			die("Não foi possível cadastrar a nova senha no BD!".mysqli_error($conn)); 
			$cadOK=false;
		} else {
			echo("Senha atualizada com sucesso! <br>");
		}

		if(!$cadOK){
			die("Não foi possível inserir dados de senha para esta pessoa! Verifique!");
		}

		if (!mysqli_stmt_close($stmt)){
			echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
			//mandar email/sms/alerta para o programador
		}

		//agora, atualizar na tabela de pessoas
		$sql2="UPDATE usuario SET senha=? WHERE id=?";

		$stmt2=mysqli_prepare($conn,$sql2);
		if (!$stmt2){
			die("Não foi possível preparar o cadastro!");
		}

		if (!mysqli_stmt_bind_param($stmt2, "ss", $senha, $id)){
			die("Não foi possível vincular parâmetros!");
		}

		if (!mysqli_stmt_execute($stmt2)){
			die("Não foi possível cadastrar a nova senha no BD!".mysqli_error($conn)); 
			$cadOK=false;
		} else {
			echo("Senha atualizada com sucesso! <br>");
		}
	} else {
		echo ("A senha nova não pode ser igual a uma senha usada anteriormente! <br>");
		die("<a href='mudaSenha01.php'>Tente novamente</a>!");
	}

	//apagando senhas antigas
	if(!ApagarSenhasAnt($id)){
		echo(mysqli_error($conn));
	}
	echo("<a href='menu.php'>Volte para o menu</a>")
?>