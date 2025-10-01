<?php
    /*require ("ses_start.php");
    $id=$_SESSION['id'];
    $nome=$_SESSION['nome'];
    $perfil=$_SESSION['perfil'];
    if($perfil!="C"){ header("Location: menu.php"); }*/
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="res/style/style.css">
    <link rel="stylesheet" href="res/style/user_profile_style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
            <div class="navbar-left">
                <a href="index.php" class="navbar-logo">MEMO</a>
            </div>
            <ul class="navbar-links">
                <li><a href="articles.php">Artigos</a></li>
                <li><a href="download.php">Download</a></li>
                <li><a href="login.html" class="navbar-login-btn">Login</a></li>
            </ul>
        </nav>

    <main>
        <section id="profile">
            <div class="profile-header">
                <h1><?php echo($nome); ?></h1>
                <span class="user-type"><?php echo($perfil); ?></span>
            </div>

            <div class="profile-content">
                <div class="profile-image-section">
                    <div class="profile-image-container">
                        <img class="profile-image" src="<?php echo /*$user['foto_perfil'] isso aqui é só um placeholder qualquer pra depois colocar o php certo*/ ("res/img/placeholder-icon.png"); ?>" alt="Foto do perfil">
                        <div class="edit-image-icon">
                            
                        </div>
                    </div>
                </div>

                <div class="profile-form-section">
                    <form id="profile-form" method="POST" action="">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" value="<?php //echo ($user['nome']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail (ID):</label>
                            <input type="email" id="email" name="email" value="<?php //echo htmlspecialchars($user['email']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone:</label>
                            <input type="tel" id="telefone" name="telefone" value="<?php //echo htmlspecialchars($user['telefone']); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="dt_nasc">Data de Nascimento:</label>
                            <input type="date" id="dt_nasc" name="dt_nasc" value="<?php //echo $user['dt_nasc']; ?>" readonly>
                        </div>

                        <div class="form-actions">
                            <button type="button" id="edit-btn" class="btn btn-primary">Alterar dados</button>
                            <button type="submit" id="save-btn" name="update_profile" class="btn btn-success" style="display: none;">Salvar alterações</button>
                            <button type="button" id="cancel-btn" class="btn btn-secondary" style="display: none;">Cancelar</button>
                            <a href="mudaSenha01.php" class="btn btn-link">Trocar senha</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="patients-section">
            <h2>Pacientes cadastrados</h2>
                    <div class="patient-card" onclick="window.location.href='patient.php?id=1'">
                        <img class="patient-image" src="<?php echo /* placeholder qualquer pra depois colocar o php certo*/ ("res/img/placeholder-icon.png"); ?>" alt="Paciente 1">
                        <div class="patient-info">
                            <h3><?php echo ("[Nome do paciente]") ?></h3>
                            <p><?php echo ("[Idade do paciente]") ?></p>
                        </div>
                    </div>
                    <div class="patient-card" onclick="window.location.href='patient.php?id=2'">
                        <img class="patient-image" src="<?php echo /* placeholder qualquer pra depois colocar o php certo*/ ("res/img/placeholder-icon.png"); ?>" alt="Paciente 2">
                        <div class="patient-info">
                            <h3><?php echo ("[Nome do paciente]") ?></h3>
                            <p><?php echo ("[Idade do paciente]") ?></p>
                        </div>
                    </div>
                    <div class="patient-card" onclick="window.location.href='patient.php?id=3'">
                        <img class="patient-image" src="<?php echo /* placeholder qualquer pra depois colocar o php certo*/ ("res/img/placeholder-icon.png"); ?>" alt="Paciente 3">
                        <div class="patient-info">
                            <h3><?php echo ("[Nome do paciente]") ?></h3>
                            <p><?php echo ("[Idade do paciente]") ?></p>
                        </div>
                    </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <span>Site name</span>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-right">
                <div class="footer-column">
                    <h4>Topic</h4>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                </div>
                <div class="footer-column">
                    <h4>Topic</h4>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                </div>
                <div class="footer-column">
                    <h4>Topic</h4>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                    <a href="#">Page</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtn = document.getElementById('edit-btn');
            const saveBtn = document.getElementById('save-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const form = document.getElementById('profile-form');
            const inputs = form.querySelectorAll('input[readonly]');
            
            let originalValues = {};

            editBtn.addEventListener('click', function() {
                // Store original values
                inputs.forEach(input => {
                    originalValues[input.name] = input.value;
                    input.removeAttribute('readonly');
                });
                
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';
                cancelBtn.style.display = 'inline-block';
            });

            cancelBtn.addEventListener('click', function() {
                // Restore original values
                inputs.forEach(input => {
                    input.value = originalValues[input.name];
                    input.setAttribute('readonly', true);
                });
                
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            });

            // Handle form submission
            form.addEventListener('submit', function(e) {
                inputs.forEach(input => {
                    input.setAttribute('readonly', true);
                });
                
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            });
        });
    </script>
</body>
</html> 