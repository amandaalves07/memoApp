<?php
    require ("ses_start.php");
    $id=$_SESSION['id'];
    $perfil=$_SESSION['perfil'];
    if($perfil!="C"){ header("Location: menu.php"); }

    $tamPagina = 5;
    $pag = 0;
    if (isset($_POST['tamPagina'])) $tamPagina = $_POST['tamPagina'];
    if (isset($_POST['pag']) && $_POST['pag']>-1) $pag = $_POST['pag']-1;
    $regInicial = $pag*$tamPagina;

    require ("bdconnecta.php");

    // quantidade de pacientes
    $sql="SELECT COUNT(*) AS qtdePacientes FROM paciente WHERE idCuidador=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $qtdePacientes);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($qtdePacientes==0) {
        echo("Não foi encontrado nenhum paciente cadastrado!<br>");
        die("Retorne para a <a href='login01.html'>página de login</a>!");
    }

    // buscar pacientes
    $sql2="SELECT idPaciente, nome FROM paciente WHERE idCuidador=? ORDER BY nome LIMIT $tamPagina OFFSET $regInicial";
    $stmt2=mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "s", $id);
    mysqli_stmt_execute($stmt2);
    $result=mysqli_stmt_get_result($stmt2);
    mysqli_stmt_close($stmt2);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Pacientes</title>
    <script src="funcoes.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card-container { display: flex; flex-direction: column; gap: 15px; }
        .card { border: 1px solid #ccc; padding: 15px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; background-color: #f9f9f9; }
        .card .nome { font-weight: bold; font-size: 1.1em; }
        .card .acoes button { margin-left: 5px; padding: 5px 10px; cursor: pointer; }
        .pagination { margin-top: 20px; }
        .pagination form { display: inline-block; margin-right: 5px; }
    </style>
</head>
<body>
    <h1>Lista de pacientes cadastrados</h1>

    <form name="form1" action="paginadorPacientes.php" method="POST">
        Visualizando os 
        <select name="tamPagina" onchange="document.form1.submit()">
            <option value="5" <?= $tamPagina==5?'selected':'' ?>>5</option>
            <option value="10" <?= $tamPagina==10?'selected':'' ?>>10</option>
            <option value="15" <?= $tamPagina==15?'selected':'' ?>>15</option>
        </select> primeiros pacientes
        <input type="hidden" name="pag" value="-1">
    </form>
    <br>

    <div class="card-container">
        <?php while($linha=mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <div class="nome"><?= htmlspecialchars($linha['nome']) ?></div>
                <div class="acoes">
                    <form method="POST" action="modPaciente01.php" style="display:inline;">
                        <input type="hidden" name="mod" value="<?= $linha['idPaciente'] ?>">
                        <button type="submit">Modificar</button>
                    </form>
                    <form method="POST" action="excUser01.php" style="display:inline;" onsubmit="return confirm('Deseja excluir <?= htmlspecialchars($linha['nome']) ?>?')">
                        <input type="hidden" name="exc[]" value="<?= $linha['idPaciente'] ?>">
                        <button type="submit">Excluir</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="pagination">
        <?php
            $qtdePags = ceil($qtdePacientes / $tamPagina);
            for($i=1; $i<=$qtdePags; $i++):
        ?>
            <form method="POST" action="paginadorPacientes.php">
                <input type="hidden" name="pag" value="<?= $i ?>">
                <input type="hidden" name="tamPagina" value="<?= $tamPagina ?>">
                <button type="submit"><?= $i ?></button>
            </form>
        <?php endfor; ?>
    </div>

    <br>
    <a href="cadPessoa01.php">Cadastrar novo paciente</a><br><br>
    <a href="menu.php">Voltar para o menu</a>
</body>
</html>