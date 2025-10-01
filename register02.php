<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cadastre-se</title>
	</head>
	<body>
		<?php
			$formOK=true;

			if (isset($_POST['nome'])){
				$nome=$_POST['nome'];
			}
			if (isset($_POST['email'])){
				$email=$_POST['email'];
			}
			if (isset($_POST['senha'])){
				$senha=$_POST['senha'];
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
			if (empty($senha)){
				echo("A senha precisa ser preenchida!");
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

			require ("cryp2graph.php");

			//verificando formatação da senha nova
			if(!validarFormatoSenha($senha)){
				$formOK=false;
				echo("A senha não está no formato exigido!<br>");
			}

			if (!$formOK){
				echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
				die("<br>Verifique os erros indicados acima!!");
			}

			$id=CriaID(10);
			$senhaCAD=FazSenha($id, $senha);
			$cadOK=true;

			require ("bdconnecta.php");
			//cadastrando o usuário na tabela de usuários
			$sql="INSERT INTO usuario (id, nome, senha, email, dataNasc, sexo, perfil, tel) VALUES (?,?,?,?,?,?,?,?)";
			$stmt=mysqli_prepare($conn,$sql);

			if (!$stmt){
				die("Não foi possível preparar o cadastro!");
			}

			if (!mysqli_stmt_bind_param($stmt, "ssssssss", $id, $nome, $senhaCAD, $email, $dataNasc, $sexo, $perfil, $tel)){
				die("Não foi possível vincular parâmetros!");
			}

			if (!mysqli_stmt_execute($stmt)){
				echo(mysqli_error($conn));
				die("Não foi possível cadastrar a pessoa no BD! <br>"); 
				$cadOK=false;
			} else {
				echo("Pessoa cadastrada com sucesso! <br>");
			}

			if(!$cadOK){
				die("Não foi possível inserir dados pessoais para esta pessoa! Verifique!");
			}

			if (!mysqli_stmt_close($stmt)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			if(isset($_FILES["fotoPerf"])){
				$fotoPerf=$_FILES["fotoPerf"];

				$nomeFinal = 'uploads/fotoPerf.jpg';

			    if(move_uploaded_file($fotoPerf['tmp_name'], $nomeFinal)){
			        $tamanhoImg=filesize($nomeFinal);
			        $mysqlImg=addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
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

			//cadastrando o usuário na tabela de senhas
			$sql3="INSERT INTO senhasantigas (id, senhaAnt) VALUES (?,?)";
			$stmt3=mysqli_prepare($conn, $sql3);

			if(!$stmt3){
				die("Não foi possível preparar o cadastro de senha(s)!");
			}

			if (!mysqli_stmt_bind_param($stmt3, "ss", $id, $senhaCAD)){
				die("Não foi possível vincular parâmetros!");
			}

			if (!mysqli_stmt_execute($stmt3)){
				die("Não foi possível cadastrar senha no BD!"); 
				$cadOK=false;
			} else {
				echo("Senha cadastrada com sucesso! <br>");
			}

			if(!$cadOK){
				die("Não foi possível inserir dados de senha para esta pessoa! Verifique!");
			}

			if (!mysqli_stmt_close($stmt3)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			echo ("Faça o login <a href='login.html'>aqui</a>!");
		?>
	</body>
</html>