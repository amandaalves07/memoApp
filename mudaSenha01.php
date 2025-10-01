<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: login01.php");
        exit();
    }
    $id=$_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alteração de senha</title>
        <link rel="stylesheet" href="res/style/style.css">
        <link rel="stylesheet" href="res/style/login_style.css">
        <script src="funcoes.js" async></script>
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
                <li><a href="login01.php" class="navbar-login-btn">Login</a></li>
            </ul>
        </nav>
        
        <main>

            <div id="bg-img">
                <form class="baseform" name="form1" action="mudaSenha02.php" method="POST" onsubmit="return validaFormMudaSenha()">
                    <input type="hidden" name="id" value="<?php echo($id); ?>">
                    <h1 class="def-subtitle">Alteração de senha</h1>

                    <div class="form-container" id="login-form">
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
                            <label for="senhaLogin" class="form-label">Senha atual:</label>
                            <input type="password" placeholder="Insira sua senha atual" name="senhaAntiga" class="form-input" required>
                            <input type="password" placeholder="Insira sua nova senha" name="senhaNova1" class="form-input" required oninput="return validarSenha()">
                            <input type="password" placeholder="Confirme sua nova senha" name="senhaNova2" class="form-input" required oninput="return validarSenha()">
                        </div>
                        <p id="erroSenhaAnt" style="color: red;"></p>
                        <p id="erroSenhaNova1" style="color: red;"></p>
                        <p id="erroSenhaNova2" style="color: red;"></p>
                        <input type="submit" class="form-button" name="login" id="btnEntre" value="Salvar">
                    </div>

                    <p id="reg-link"><a href="novaSenha01.php">Esqueceu a senha?</a>.</p>
                    <p id="reg-link">Ainda não possue uma conta? <a href="cadUser01.php">Cadastre-se aqui</a>.</p>
                </form>
            </div>
        </main>
    </body>	
</html>