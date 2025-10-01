<?php
	require ("ses_start.php");
	$id=$_SESSION['id'];
	$perfil=$_SESSION['perfil'];
	if($perfil!="C"){ header("Location: menu.php"); }

	require ("cryp2graph.php");
	$idPaciente=CriaID(10);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cadastro de Paciente</title>
		<script src="funcoes.js"></script>
	</head>
	<body>
		<h2>Cadastro de Paciente</h2>
		<form name="form1" action="cadPaciente02.php" method="POST" enctype=multipart/form-data onsubmit="return validarFormCadPaciente()">
			<input type="hidden" name="idCuidador" value="<?php echo($id) ?>">
			<input type="hidden" name="idPaciente" value="<?php echo($idPaciente) ?>">
			<fieldset>
				*Dados obrigatórios <br> <br>
				<legend>Dados Pessoais</legend>
				<label for="nome">Nome completo:*</label><br>
				<input type="text" id="nome" name="nome" maxlength="100" required><br><br>
				<label for="sexo">Sexo:*</label><br>
				<select id="sexo" name="sexo">
					<option value="">Selecione</option>
					<option value="F">Feminino</option>
					<option value="M">Masculino</option>
					<option value="N">Prefiro não informar</option>
				</select><br><br>
				<label for="dataNasc">Data de nascimento:*</label><br>
				<input type="date" id="dataNasc" name="dataNasc" required><br><br>
				<label for="foto">Foto de perfil (opcional):</label><br>
				<input type="file" id="foto" name="foto" accept="image/*"><br>
			</fieldset>
			<br>
			<fieldset>
				<legend>Contato de Emergência</legend>
				<label for="tel">Telefone de emergência:*</label><br>
				<input type="text" id="tel" name="tel" maxlength="11" required><br><br>
				<label for="planoSaude">Plano de saúde:</label><br>
				<input type="text" id="planoSaude" name="planoSaude" maxlength="30"><br>
			</fieldset>
			<br>
			<fieldset>
				<legend>Histórico Médico</legend>
				<label for="doencasAnt">Doenças autoimunes:</label><br>
				<textarea id="doencasAnt" name="doencasAnt" rows="2"></textarea><br><br>
				<label for="alergias">Alergias:</label><br>
				<textarea id="alergias" name="alergias" rows="2"></textarea><br><br>
				<label for="histFamiliar">Histórico familiar de doenças:</label><br>
				<textarea id="histFamiliar" name="histFamiliar" rows="2"></textarea><br><br>
				<label for="medicamentos">Medicamentos de uso contínuo:</label><br>
				<textarea id="medicamentos" name="medicamentos" rows="2"></textarea><br><br>
				<label for="vacinas">Vacinas:</label><br>
				<textarea id="vacinas" name="vacinas" rows="2"></textarea>
			</fieldset>
			<br>
			<fieldset>
				<legend>Sintomas</legend>
				<label for="sintomas">Sintomas do Alzheimer:</label><br>
				<textarea id="sintomas" name="sintomas" rows="3"></textarea>
			</fieldset>
			<br>
			<input type="submit" value="Cadastrar">
		</form>
	</body>
</html>