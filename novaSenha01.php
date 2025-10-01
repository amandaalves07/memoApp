<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Redefinição de senha</title>
        <link rel="stylesheet" href="res/style/style.css">
        <link rel="stylesheet" href="res/style/login_style.css">
        <script src="funcoes.js"></script>
    </head>
    <body>
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

     <div id="bg-img">
            <form name="form1" action="novaSenha02.php" method="POST" onsubmit="return validaFormNovaSenha()">
                <h1 class="def-subtitle">Recuperar Senha</h1>

                <div class="form-container" id="login-form">
                    <div class="input-container">
                        <label for="uname" class="form-label">Informe seu endereço de e-mail e enviaremos um link para redefinir sua senha.</label>
                        <input type="text" placeholder="Insira seu e-mail..." id="email" name="email" class="form-input" required>
                        <div id="erroEmail" class="erro"></div>
                    </div>

                    <input type="submit" class="form-button" name="Enviar" id="btnEnviar" value="Enviar">
                </div>

                <p id="reg-link">Ainda não possue uma conta? <a href="cadUser01.php">Cadastre-se aqui</a>.</p>
            </form>
        </div>
        
    </body>
</html>