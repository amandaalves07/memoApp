<?php
	require ("ses_start.php");
	$id=$_SESSION['id'];
	$perfil=$_SESSION['perfil'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Menu</title>
	</head>
	<body>
		<?php
			//echo("Olá $nomeCompleto!<br><hr>");
			if($perfil=="C"){
				echo ('<button onclick="window.location.href=\'cadPaciente01.php\'">Cadastrar paciente</button>');
				echo("<br><br>");
				echo ('<button onclick="window.location.href=\'paginadorPacientes.php\'">Vizualizar pacientes</button>');
				echo("<br><br>");
				echo ('<button onclick="window.location.href=\'user.php\'">Vizualizar perfil</button>');
				echo("<br><br>");

			}
		?>
		<button onclick="window.location.href='mudaSenha01.php'">Trocar Senha</button>
		<br><br>
		<button onclick="window.location.href='sair.php'">Sair</button>
	</body>
</html>