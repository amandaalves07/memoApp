<?php 
	require ("ses_start.php");
	$id=$_SESSION['id'];

	$formOK=true;

	if (isset($_POST['nome'])){
		$nome=$_POST['nome'];
	}
	if (isset($_POST['email'])){
		$email=$_POST['email'];
	}
	if (isset($_POST['dataNasc'])){
		$dataNasc=$_POST['dataNasc'];
	}
	if (isset($_POST['sexo'])){
		$sexo=$_POST['sexo'];
	}
	if (isset($_POST['tel'])){
		$tel=$_POST['tel'];
	}
	if (isset($_POST['cuidador'])) {
	    if ($_POST['cuidador']=="S") {
	        $perfil="C";
	    } else {
	        $perfil="U";
	    }
	}

	if (empty($nome)){
		echo("O nome precisa ser preenchido!");
		$formOK=false;
	}
	if (empty($email)){
		echo("O e-mail precisa ser preenchido!");
		$formOK=false;
	}
	if (empty($dataNasc)){
		echo("A data de nascimento precisa ser preenchida!");
		$formOK=false;
	}
	if (empty($tel)){
		echo("O telefone precisa ser preenchido!");
		$formOK=false;
	}
	if (empty($perfil)){
		echo("Perfil do usuário precisa ser preenchido!");
		$formOK=false;
	}

	if (!$formOK){
		echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
		die("<br>Verifique os erros indicados acima!!");
	}

	require ("bdconnecta.php");
	$cadOK=true;

	$sql="UPDATE usuario SET nome=?, email=?, dataNasc=?, sexo=?, perfil=?, tel=? WHERE id=?";
	$stmt=mysqli_prepare($conn,$sql);
	if (!$stmt){
		die("Não foi possível preparar o cadastro!");
	}
	if (!mysqli_stmt_bind_param($stmt, "sssssss", $nome, $email, $dataNasc, $sexo, $perfil, $tel, $id)){
		die("Não foi possível vincular parâmetros!");
	}
	if (!mysqli_stmt_execute($stmt)){
		echo(mysqli_error($conn));
		die("Não foi possível cadastrar o paciente no BD! <br>"); 
		$cadOK=false;
	} else {
		echo("Dados alterados com sucesso! <br>");
	}
	if(!$cadOK){
		die("Não foi possível inserir dados de paciente para esta pessoa! Verifique!");
	}
	if (!mysqli_stmt_close($stmt)){
		echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
		//mandar email/sms/alerta para o programador
	}

	if(isset($_FILES["fotoPerf"])){
		$fotoPerf=$_FILES["fotoPerf"];

		$nomeFinal = 'uploads/fotoPerf.jpg'; //nome do arquivo que chegou será fotinha.jpg na past uploads

	    if(move_uploaded_file($fotoPerf['tmp_name'], $nomeFinal)){
	        $tamanhoImg = filesize($nomeFinal);
	        $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
	        $sql2="UPDATE usuario SET fotoPerfil=? WHERE id=?";
	        $stmt2=mysqli_prepare($conn, $sql2);

	        if(!$stmt2){
				die("Não foi possível preparar o cadastro de senha(s)!");
			}

			if (!mysqli_stmt_bind_param($stmt2, "ss", $mysqlImg, $id)){
				die("Não foi possível vincular parâmetros!");
			}

			if (!mysqli_stmt_execute($stmt2)){
				die("Não foi possível cadastrar foto no BD!"); 
				$cadOK=false;
			} else {
				echo("Foto cadastrada com sucesso! <br>");
			}

			if(!$cadOK){
				die("Não foi possível inserir foto para esta pessoa! Verifique!");
			}

			if (!mysqli_stmt_close($stmt2)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}
	    }
	}
	header("Location: user.php");
?>