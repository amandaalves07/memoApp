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
		<script src="funcoes.js"></script>
		<?php 
			if(isset($_POST['idPaciente'])){
				$idPaciente=$_POST['idPaciente'];
			}
			if(empty($_POST['idPaciente'])){
				die("ID deve ser preenchido!");
			}

			require ("bdconnecta.php");

			$sql="SELECT nome, sexo, dataNasc, telEmergencia, planoSaude FROM paciente WHERE idPaciente=?";

			$stmt=mysqli_prepare($conn,$sql);
			if (!$stmt) {
				die("Não foi possível preparar a consulta!");
			}
			if (!mysqli_stmt_bind_param($stmt, "s", $idPaciente)) {
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt)) {
				die("Não foi possível executar busca no Banco de Dados!");
			}
			if (!mysqli_stmt_bind_result($stmt, $nome, $sexo, $dataNasc, $telEmergencia, $planoSaude)) {
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

			if ($fetch==null) {
				//nada foi encontrado
				echo("Dados do paciente não foram encontrados! <br>");
				die("Retorne para a <a href='login01.html'>página de login</a>!");
			}

			$sql2="SELECT doencasAnt, alergias, histFamiliar, medicamentos, vacinas, sintomas FROM historicopaciente WHERE idPaciente=?";

			$stmt2=mysqli_prepare($conn,$sql2);
			if (!$stmt2) {
				die("Não foi possível preparar a consulta!");
			}
			if (!mysqli_stmt_bind_param($stmt2, "s", $idPaciente)) {
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt2)) {
				die("Não foi possível executar busca no Banco de Dados!");
			}
			if (!mysqli_stmt_bind_result($stmt2, $doencasAnt, $alergias, $histFamiliar, $medicamentos, $vacinas, $sintomas)) {
				die("Não foi possível vincular resultados");
			}
			$fetch2=mysqli_stmt_fetch($stmt2);
			if (!$fetch2) {
				die("Não foi possível recuperar dados");
			}
			if (!mysqli_stmt_close($stmt2)){
				echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
				//mandar email/sms/alerta para o programador
			}

			if ($fetch2==null) {
				//nada foi encontrado
				echo("Histórico do paciente não foi encontrado! <br>");
				die("Retorne para a <a href='login01.html'>página de login</a>!");
			}
		?>
	</head>
	<body>
		<h1>Modificar dados do paciente</h1> <br>
		<form name="form1" action="modPaciente02.php" method="POST" enctype=multipart/form-data onsubmit="return validarFormCadPaciente()">
			<input type="hidden" name="idPaciente" value="<?php echo($idPaciente) ?>">
			<fieldset>
				<legend>Dados Pessoais</legend>
				<label for="nome">Nome completo:</label><br>
				<input type="text" id="nome" name="nome" maxlength="100" value="<?php echo($nome); ?>" required><br><br>
				<label for="sexo">Sexo:</label><br>
				<select id="sexo" name="sexo">
					<option value="">Selecione</option>
					<option value="F" <?php if($sexo=="F"){ echo('selected'); } ?>>Feminino</option>
					<option value="M" <?php if($sexo=="M"){ echo('selected'); } ?>>Masculino</option>
					<option value="N" <?php if($sexo=="n"){ echo('selected'); } ?>>Prefiro não informar</option>
				</select><br><br>
				<label for="dataNasc">Data de nascimento:</label><br>
				<input type="date" id="dataNasc" name="dataNasc" value="<?php echo("$dataNasc"); ?>" required><br><br>
				<label for="foto">Foto de perfil (opcional):</label><br>
				<input type="file" id="foto" name="foto" accept="image/*"><br>
			</fieldset>
			<br>
			<fieldset>
				<legend>Contato de Emergência</legend>
				<label for="tel">Telefone de emergência:</label><br>
				<input type="text" id="tel" name="tel" maxlength="11" value="<?php echo($telEmergencia); ?>" required><br><br>
				<label for="planoSaude">Plano de saúde:</label><br>
				<input type="text" id="planoSaude" name="planoSaude" maxlength="30" value="<?php echo($planoSaude); ?>"><br>
			</fieldset>
			<br>
			<fieldset>
				<legend>Histórico Médico</legend>
				<label for="doencasAnt">Doenças autoimunes:</label><br>
				<textarea id="doencasAnt" name="doencasAnt" rows="2"><?php echo($doencasAnt); ?></textarea><br><br>
				<label for="alergias">Alergias:</label><br>
				<textarea id="alergias" name="alergias" rows="2"><?php echo($alergias); ?></textarea><br><br>
				<label for="histFamiliar">Histórico familiar de doenças:</label><br>
				<textarea id="histFamiliar" name="histFamiliar" rows="2"><?php echo($histFamiliar); ?></textarea><br><br>
				<label for="medicamentos">Medicamentos de uso contínuo:</label><br>
				<textarea id="medicamentos" name="medicamentos" rows="2"><?php echo($medicamentos); ?></textarea><br><br>
				<label for="vacinas">Vacinas:</label><br>
				<textarea id="vacinas" name="vacinas" rows="2"><?php echo($vacinas); ?></textarea>
			</fieldset>
			<br>
			<fieldset>
				<legend>Sintomas</legend>
				<label for="sintomas">Sintomas do Alzheimer:</label><br>
				<textarea id="sintomas" name="sintomas" rows="3"><?php echo($sintomas) ?></textarea>
			</fieldset>
			<br>
			<input type="submit" value="Salvar">
		</form>
	</body>
</html>