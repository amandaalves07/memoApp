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
<html lang="pt-br">
    <head>
    	<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title><?php echo($nome); ?></title>
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

                <?php 
                    if(!empty($fotoPerfil) || $fotoPerfil!==null){
                        $img=base64_encode($fotoPerfil);
                        echo ('<img src="data:image/jpeg;base64,'.$img.'" width="150" height="150">');
                    }
                ?>

                <div class="info-profile">

                    <div class="info-profile-bit">
                        <h2 class="profile-desc">Nome:</h2>
                        <input type="text" value="<?php echo($nome); ?>" readonly>
                    </div>
                    
                    <div class="info-profile-bit">
                        <h2 class="profile-desc">Telefone:</h2>
                        <input type="tel" value="<?php echo($tel); ?>" readonly>
                    </div>

                    <div class="info-profile-bit">
                        <h2 class="profile-desc">E-mail:</h2>
                        <input type="email" value="<?php echo($email); ?>" readonly>
                    </div>

                     <div class="info-profile-bit">
                        <h2 class="profile-desc">Data de Nascimento:</h2>
                        <input type="date" value="<?php echo($dataNasc); ?>" readonly>
                    </div>

                    <div class="info-profile-bit">
                        <h2 class="profile-desc">Sexo:</h2>
                        <select id="sexo" name="sexo" disabled>
                            <option value="0"></option>
                            <option value="F" <?php if($sexo=="F"){ echo('selected'); } ?>>Feminino</option>
                            <option value="M" <?php if($sexo=="M"){ echo('selected'); } ?>>Masculino</option>
                            <option value="N" <?php if($sexo=="N"){ echo('selected'); } ?>>Prefiro não informar</option>
                        </select>
                    </div>

                </div>

                <button class="form-button" onclick="window.location.href='modUser01.php'">Alterar dados</button>

                <button onclick="window.location.href='mudaSenha01.php'">Alterar senha</button>
            </section>

            <section id="card-carousel"> <!-- mesmo styling dos artigos (se forem editar esses elementos, mantenham as classes o mais genéricas possível, para fins de reuso.) -->
    			<h2 class="def-subtitle">Pacientes cadastrados</h2>
    			<div class="card">
    				<img class="card-img-small" href="">
    				<h3 class="def-subtitle-small"><a class="head-link">Lorem ipsum</a></h3>
    				<p class="card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sagittis,</p>
    			</div>
    			<div class="card">
    				<img class="card-img-small" href="">
    				<h3 class="def-subtitle-small"><a class="head-link">Lorem ipsum</a></h3>
    				<p class="card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sagittis,</p>
    			</div>
    			<div class="card">
    				<img class="card-img-small" href="">
    				<h3 class="def-subtitle-small"><a class="head-link">Lorem ipsum</a></h3>
    				<p class="card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sagittis,</p>
                </div>
    		</section>
         </main>

         <footer>

         </footer>
    </body>
</html>