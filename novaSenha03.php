<?php
	$formOK=true;
	if(isset($_GET["t"])){
		$token=$_GET["t"];
	}
	if(empty($token)){
		echo("Token não informado!");
		$formOK=false;
	}

	if (!$formOK){
		echo('<br><button onclick="history.go(-1);">Voltar</button><br>');
		die("<br>Verifique os erros indicados acima!!");
	}

	require ("bdconnecta.php");

	//pegando id do usuário de acordo com o token
	$sql="SELECT id FROM usuario WHERE tokenDeRedefinicao=?";
	$stmt = mysqli_prepare($conn,$sql);
	if (!$stmt) {
		die("Não foi possível preparar a consulta!");
	}
	if (!mysqli_stmt_bind_param($stmt, "s", $token)) {
		die("Não foi possível vincular parâmetros!");
	}
	if (!mysqli_stmt_execute($stmt)) {
		die("Não foi possível executar busca no Banco de Dados!");
	}
	if (!mysqli_stmt_bind_result($stmt, $id)) {
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
		die("Retorne para a <a href='index.php'>página de login</a>!");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Redefinição de senha</title>
		<script src="funcoes.js" async></script>
	</head>
	<body>
		Redefinição de senha <br>
		<form name="form1" action="novaSenha04.php" method="POST" onsubmit="">
			<input type="hidden" name="token" value="<?php echo($token) ?>">
			<div class="password-information">
                <!--div contendo informações da formatação de senha-->
                Sua senha nova deve conter: <br>
                <div id="password-length">8 ou mais caracteres</div>
                <div id="password-uppercase">1 letra maiúscula</div>
                <div id="password-lowercase">1 letra minúscula</div>
                <div id="password-number">1 número</div>
                <div id="password-symbol">1 caractere especial</div>
            </div>
            <div class="input-container">
                <label for="senhaLogin" class="form-label">Nova senha:</label> <br>
                <input type="password" placeholder="Insira sua nova senha" name="senhaNova1" class="form-input" required oninput="return validarSenha()"> <br>
                <input type="password" placeholder="Confirme sua nova senha" name="senhaNova2" class="form-input" required oninput="return validarSenha()">
            </div>
            <p id="erroSenhaNova1" style="color: red;"></p>
            <p id="erroSenhaNova2" style="color: red;"></p>
            <input type="submit" class="form-button" name="login" id="btnEntre" value="Salvar">
		</form>
	</body>
</html>