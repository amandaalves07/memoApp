<?php
	require ("ses_start.php");
	$id=$_SESSION['id'];
	$perfil=$_SESSION['perfil'];
	if($perfil!="C"){ header("Location: menu.php"); }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Excluir paciente</title>
	</head>
	<body>
		<?php
			if(isset($_POST['idPaciente'])){
				$idPaciente=$_POST['idPaciente'];
			}
			if(empty($_POST['idPaciente'])){
				die("ID deve ser preenchido!");
			}

			require("bdconnecta.php");

			$sql="DELETE FROM paciente WHERE idPaciente=?";
			$stmt=mysqli_prepare($conn, $sql);

			if (!$stmt){
				die("Não foi possível preparar o cadastro!");
			}

			if (!mysqli_stmt_bind_param($stmt, "s", $idPaciente)){
				die("Não foi possível vincular parâmetros!");
			}

			if (!mysqli_stmt_execute($stmt)){
				echo(mysqli_error($conn));
				die("Não foi possível excluir paciente do BD! <br>");
			} else {
				echo("Paciente excluído com sucesso! <br>");
			}

			if (!mysqli_stmt_close($stmt)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			$sql2="DELETE FROM historicopaciente WHERE idPaciente=?";
			$stmt2=mysqli_prepare($conn, $sql2);

			if (!$stmt2){
				die("Não foi possível preparar o cadastro!");
			}

			if (!mysqli_stmt_bind_param($stmt2, "s", $idPaciente)){
				die("Não foi possível vincular parâmetros!");
			}

			if (!mysqli_stmt_execute($stmt2)){
				echo(mysqli_error($conn));
				die("Não foi possível excluir paciente do BD! <br>");
			} else {
				echo("Paciente excluído com sucesso! <br>");
			}

			if (!mysqli_stmt_close($stmt2)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}
			header("Location: paginadorPacientes.php");
		?>
	</body>
</html>