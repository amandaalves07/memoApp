<?php
	require ("ses_start.php");
	$id=$_SESSION['id'];

	require ("bdconnecta.php");

    $sql="SELECT nome, email, dataNasc, sexo, fotoPerfil, perfil, tel FROM usuario WHERE id=?";

    $stmt=mysqli_prepare($conn,$sql);
    if (!$stmt) {
        die("Não foi possível preparar a consulta!");
    }
    if (!mysqli_stmt_bind_param($stmt, "s", $id)) {
        die("Não foi possível vincular parâmetros!");
    }
    if (!mysqli_stmt_execute($stmt)) {
        die("Não foi possível executar busca no Banco de Dados!");
    }
    if (!mysqli_stmt_bind_result($stmt, $nome, $email, $dataNasc, $sexo, $fotoPerfil, $perfil, $tel)) {
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
        echo("Dados do usuário não foram encontrados! <br>");
        die("Retorne para a <a href='login01.html'>página de login</a>!");
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Alterar dados pessoais</title>
		<script src="funcoes.js"></script>
		<link rel="stylesheet" href="res/style/style.css">
	</head>
	<body>
		<!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-left">
                <a href="index.php" class="navbar-logo">MEMO</a>
            </div>
            <ul class="navbar-links">
                <li><a href="#artigos">Artigos</a></li>
                <li><a href="download.html">Download</a></li>
                <li><a href="#contatos">Contatos</a></li>
                <li><a href="login.html" class="navbar-login-btn">Login</a></li>
            </ul>
        </nav>

        <main>
            <section id="profile">

                <div class="info-profile">

                	<form name="form1" action="modUser02.php" method="POST" enctype="multipart/form-data" onsubmit="return validaFormMod()">
                        <?php 
                            if(!empty($fotoPerfil) || $fotoPerfil!==null){
                                $img=base64_encode($fotoPerfil);
                                echo ('<img src="data:image/jpeg;base64,'.$img.'" alt="Foto de Perfil" width="150" height="150">');
                            }
                        ?>
	                    <div class="info-profile-bit">
	                        <h2 class="profile-desc">Nome:</h2>
	                        <input type="text" id="nome" name="nome" value="<?php echo($nome); ?>" required>
	                    </div>
	                    
	                    <div class="info-profile-bit">
	                        <h2 class="profile-desc">Telefone:</h2>
	                        <input type="tel" id="tel" name="tel" value="<?php echo($tel); ?>" required>
	                    </div>

	                    <div class="info-profile-bit">
	                        <h2 class="profile-desc">E-mail:</h2>
	                        <input type="email" id="email" name="email" value="<?php echo($email); ?>" required>
	                    </div>

	                	<div class="info-profile-bit">
	                        <h2 class="profile-desc">Data de Nascimento:</h2>
	                        <input type="date" id="dataNasc" name="dataNasc" value="<?php echo($dataNasc); ?>" required>
	                    </div>

	                    <div class="info-profile-bit">
	                    	<h2 class="profile-desc">Sexo:</h2>
	                    	<select id="sexo" name="sexo">
	                            <option value="F" <?php if($sexo == "F") echo ("checked"); ?> >Feminino</option>
	                            <option value="M" <?php if($sexo == "M") echo ("checked"); ?> >Masculino</option>
	                            <option value="N" <?php if($sexo == "N") echo ("checked"); ?> >Prefiro não informar</option>
	                        </select>
	                    </div>

	                    <div class="info-profile-bit">
	                    	<label for="perfil">Você é cuidador(a) de alguma pessoa com Alzheimer?</label><br>
							<input type="radio" id="cuidadorSim" name="cuidador" value="S" <?php if($perfil == "C") echo ("checked"); ?> required>
							<label for="cuidadorSim">Sim</label><br>
							<input type="radio" id="cuidadorNao" name="cuidador" value="N" <?php if($perfil == "U") echo ("checked"); ?> required>
							<label for="cuidadorNao">Não</label><br>
	                    </div>

	                    <input type="submit" name="enviar" value="Salvar alterações">

                	</form>

                </div>

            </section>

        </main>

        <footer>

        </footer>
	</body>
</html>