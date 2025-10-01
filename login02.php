<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Fazer Login</title>
	</head>
	<body>
		<?php
			$formOK=true;

			if(isset($_POST['email'])){
				$email=$_POST['email'];
			}
			if(isset($_POST['senha'])){
				$senha=$_POST['senha'];
			}

			if (empty($email)) {
				echo("O e-mail precisa ser preenchido!");
				$formOK=false;
			}
			if (empty($senha)) {
				echo("A senha precisa ser preenchida!");
				$formOK=false;
			}
			
			require("bdconnecta.php");
			require ("cryp2graph.php");

			$sql="SELECT id, nome, senha, perfil FROM usuario WHERE email=?";

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
			if (!mysqli_stmt_bind_result($stmt, $id, $nome, $senhaBD, $perfil)) {
				die("Não foi possível vincular resultados");
			}
			$fetch=mysqli_stmt_fetch($stmt);
			if (!$fetch) {
				die("Não foi possível recuperar dados");
			}
			if (!mysqli_stmt_close($stmt)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			if ($fetch=="") {
				//nada foi encontrado
				echo("Essa combinação de E-mail/Senha não foi localizada! <br>");
				die("Retorne para a <a href='login01.html'>página de login</a>!");
			} else {
				if (ChecaSenha($senha, $senhaBD)) {
					//usuário acertou os dados do login
					if (!session_start()) {
						die("Não foi possível iniciar sessão!");
					}
					$_SESSION['idSessao']=session_id();
					$_SESSION['id']=$id;
					$_SESSION['nome']=$nome;
					$_SESSION['perfil']=$perfil;

					header("Location: menu.php");
				} else {
					echo("Essa combinação de E-mail/Senha não foi localizada! <br>");
					die("Retorne para a <a href='login01.html'>página de login</a>!");
				}
			}
		?>
	</body>
</html>