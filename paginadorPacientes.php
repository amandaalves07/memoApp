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
		<title>Lista de pacientes</title>
		<script src="funcoes.js"></script>
		<style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card-container { display: flex; flex-direction: column; gap: 15px; }
        .card { border: 1px solid #ccc; padding: 15px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; background-color: #f9f9f9; }
        .card .nome { font-size: 1.1em; }
        .card .acoes button { margin-left: 5px; padding: 5px 10px; cursor: pointer; }
        .pagination { margin-top: 20px; }
        .pagination form { display: inline-block; margin-right: 5px; }
    </style>
	</head>
	<body>
		<h1>Lista de pacientes cadastrados</h1> <br>
		<?php
			$tamPagina=5;
			$regInicial=0;
			$pag=0;
			if (isset($_POST['tamPagina'])){
				$tamPagina=$_POST['tamPagina'];
			}
			if (isset($_POST['pag']) && $_POST['pag']>-1) {
	            $regInicial=($_POST['pag']-1)*$tamPagina;
	        } else {
	        	$regInicial=$pag*$tamPagina;
	        }
	        if (isset($_POST['pag']) && $_POST['pag']>-1){
				$pag=$_POST['pag']-1;
			}

			require ("bdconnecta.php");
			//obtendo quantidade de registros de pessoas
			$sql="SELECT COUNT(*) AS qtdePacientes FROM paciente WHERE idCuidador=?";

			$stmt=mysqli_prepare($conn, $sql);
			if (!$stmt) {
				die("Não foi possível preparar a consulta!");
			}
			if (!mysqli_stmt_bind_param($stmt, "s", $id)) {
				die("Não foi possível vincular parâmetros!");
			}
			if (!mysqli_stmt_execute($stmt)) {
				die("Não foi possível executar busca no Banco de Dados!");
			}
			if (!mysqli_stmt_bind_result($stmt, $qtdePacientes)) {
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

			if ($qtdePacientes==0) {
				//nada foi encontrado
				echo("Não foi encontrado nenhum paciente cadastrado!<br>");
				die("<a href='menu.php'>Retorne para o menu</a>!");
			} else {

				$regInicial=$pag*$tamPagina;

				//obtendo os dados dos pacientes registradss
				$sql2="SELECT idPaciente, nome FROM paciente WHERE idCuidador=? ORDER BY nome LIMIT $tamPagina OFFSET $regInicial";

				$stmt2=mysqli_prepare($conn, $sql2);
				if (!$stmt) {
					die("Não foi possível preparar a consulta!");
				}
				if (!mysqli_stmt_bind_param($stmt2, "s", $id)) {
					die("Não foi possível vincular parâmetros!");
				}
				if (!mysqli_stmt_execute($stmt2)) {
					die("Não foi possível executar busca no Banco de Dados!");
				}
				$result=mysqli_stmt_get_result($stmt2);
				if (!mysqli_stmt_close($stmt2)){
					echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
					//mandar email/sms/alerta para o programador
				}
			}
		?>

		<form name="form1" action="paginadorPacientes.php" method="POST">
			<input type="hidden" name="pag" value="-1">

			Vizualizando os <select name="tamPagina" onchange="document.form1.submit()">
				<option value="5" <?php if($tamPagina==5){ echo('selected'); } ?>>5</option>
				<option value="10" <?php if($tamPagina==10){ echo('selected'); } ?>>10</option>
				<option value="15" <?php if($tamPagina==15){ echo('selected'); } ?>>15</option>
			</select> primeiros pacientes <br> <br>
		</form>

		<div class="card-container">
			<?php
				while($linhaDados=mysqli_fetch_assoc($result)){
			        $idPaciente=$linhaDados['idPaciente'];
			        $nome=$linhaDados['nome'];

			        echo('<div class="card">');
			        echo('<div class="nome">'.$nome.'</div>');
			        echo('<div class=acoes>');

			        echo('<form method="POST" action="modPaciente01.php" style="display:inline;">');
			        echo('<input type="hidden" name="idPaciente" value="'.$idPaciente.'">');
			        echo('<button type="submit">Modificar</button>');
			        echo('</form>'); //fechamento form modificar

			        echo('<form method="POST" action="excPaciente.php" onsubmit="return confirmarExclusao(\''.$nome.'\')" style="display:inline;">');
			        echo('<input type="hidden" name="idPaciente" value="'.$idPaciente.'">');
			        echo('<button type="submit">Excluir</button>');
			        echo('</form>'); //fechamento form excluir

			        echo('</div>'); //fechamento div acoes
			        echo('</div>'); //fechamento div card
			        echo('<br>');
		    	}
		    ?>
			<br>
		</div>
		<br>
		<?php
			$qtdePags=$qtdePacientes/$tamPagina;
			if($qtdePacientes%$tamPagina!=0){
				$qtdePags++;
			}
			for($pag=1; $pag<$qtdePags; $pag++){
				echo("<button onclick='mudaPagina($pag)'>$pag</button>");
			}
		?>
		<br>
		<br>
		<a href='cadPessoa01.php'>Cadastrar novo paciente</a> <br> <br>
		Voltar para o <a href='menu.php'>menu</a>
	</body>
</html>