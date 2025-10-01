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
		<title>Modificar dados do paciente</title>
	</head>
	<body>
		<?php
			$formOK=true;
			$idPaciente=$_POST['idPaciente'];

			if (isset($_POST['nome'])){
				$nome=$_POST['nome'];
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
			if(isset($_POST['planoSaude'])){
				$planoSaude=$_POST['planoSaude'];
			}
			if(isset($_POST['doencasAnt'])) {
				$doencasAnt=$_POST['doencasAnt'];
			}
			if(isset($_POST['alergias'])){
				$alergias=$_POST['alergias'];
			}
			if(isset($_POST['histFamiliar'])){
				$histFamiliar=$_POST['histFamiliar'];
			}
			if(isset($_POST['medicamentos'])){
				$medicamentos=$_POST['medicamentos'];
			}
			if(isset($_POST['vacinas'])){
				$vacinas=$_POST['vacinas'];
			}
			if(isset($_POST['sintomas'])){
				$sintomas=$_POST['sintomas'];
			}

			if (empty($nome)) {
				echo("O nome precisa ser preenchido!");
				$formOK=false;
			}
			if (empty($dataNasc)) {
				echo("A data de nascimento precisa ser preenchida!");
				$formOK=false;
			}
			if (empty($sexo)){
				echo("O sexo precisa ser preenchido!");
				$formOK=false;
			}
			if (empty($tel)) {
				echo("O telefone precisa ser preenchido!");
				$formOK=false;
			}

			if (empty($planoSaude) || strtolower($planoSaude)=="não"){
				$planoSaude="N";
			}
			if (empty($doencasAnt) || strtolower($doencasAnt)=="não"){
				$doencasAnt="N";
			}
			if (empty($alergias) || strtolower($alergias)=="não") {
				$alergias="N";
			}
			if (empty($histFamiliar)  || strtolower($histFamiliar)=="não"){
				$histFamiliar="N";
			}
			if (empty($medicamentos)  || strtolower($medicamentos)=="não") {
				$medicamentos="N";
			}
			if (empty($vacinas)  || strtolower($vacinas)=="não") {
				$vacinas="N";
			}
			if (empty($sintomas)  || strtolower($sintomas)=="não") {
				$sintomas="N";
			}

			if (!$formOK){
				echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
				die("<br>Verifique os erros indicados acima!!");
			}

			require ("bdconnecta.php");

			$cadOK=true;

			$sql="UPDATE paciente SET nome=?, dataNasc=?, sexo=?, telEmergencia=?, planoSaude=? WHERE idPaciente=?";
			$stmt=mysqli_prepare($conn,$sql);
			if (!$stmt){
				die("Não foi possível preparar o cadastro!");
			}
			if (!mysqli_stmt_bind_param($stmt, "ssssss", $nome, $dataNasc, $sexo, $tel, $planoSaude, $idPaciente)){
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt)){
				echo(mysqli_error($conn));
				die("Não foi possível cadastrar o paciente no BD! <br>"); 
				$cadOK=false;
			} else {
				echo("Paciente cadastrado com sucesso! <br>");
			}
			if(!$cadOK){
				die("Não foi possível inserir dados de paciente para esta pessoa! Verifique!");
			}
			if (!mysqli_stmt_close($stmt)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			$sql2="UPDATE historicoPaciente SET doencasAnt=?, alergias=?, histFamiliar=?, medicamentos=?, vacinas=?, sintomas=? WHERE idPaciente=?";
			$stmt2=mysqli_prepare($conn,$sql2);
			if (!$stmt2){
				die("Não foi possível preparar o cadastro!");
			}
			if (!mysqli_stmt_bind_param($stmt2, "sssssss", $doencasAnt, $alergias, $histFamiliar, $medicamentos, $vacinas, $sintomas, $idPaciente)){
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt2)){
				echo(mysqli_error($conn));
				die("Não foi possível cadastrar o histórico do paciente no BD! <br>"); 
				$cadOK=false;
			} else {
				echo("Paciente cadastrado com sucesso! <br>");
			}
			if(!$cadOK){
				die("Não foi possível inserir dados do histórico do paciente para esta pessoa! Verifique!");
			}
			if (!mysqli_stmt_close($stmt2)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}
			header("Location: paginadorPacientes.php");
		?>
	</body>
</html>