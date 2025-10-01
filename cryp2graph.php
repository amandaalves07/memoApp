<?php
	//função para criar ID único
	function CriaID($tamanho) {
		if ($tamanho==0) { $tamanho=10; }
		$sLetras ='abcdefghijklmnopqrstuvwxyz';
		$sNumeros='0123456789';

		$lnt=$tamanho;
		$id='';
		for($lni=0; $lni<$lnt; $lni++) {
			if (($lni % 2)==0) {
				$sorte=intval(rand(0,25));
				$id.=substr($sLetras,$sorte,1);
			} else {
			    $sorte=intval(rand(0,9));
			    $id.=substr($sNumeros,$sorte,1);
			}
		}
		return $id;
	}

	//função para criptografar a senha informada no cadastro
	function FazSenha($username,$password) {
		$salt = hash('sha256', uniqid(mt_rand(), true) . CriaAlgo(18) . strtolower($username));
		$hash = $salt . $password;
		$loops=15;
		for ( $i = 0; $i < $loops; $i ++ ) {
			$hash = hash('sha256', $hash);
		}
		$hash = $salt . $hash;
		return $hash;
	}

	//função para criar senha nova
	function CriaAlgo($tamanho) {
		if ($tamanho==0) { $tamanho=8; }
		$sLetras ='ABCDEFGHIJKLMNOPQRSTUVXYWZ';
		$sNumeros='0123456789';
		$lnt=$tamanho;
		$novaSenha='';
		for( $lni=0; $lni<$lnt; $lni++) {
			if (($lni % 2)==0) {
			    $sorte=intval(rand(0,25));
			    $novaSenha.=substr($sLetras,$sorte,1);
			} else {
			    $sorte=intval(rand(0,9));
			    $novaSenha.=substr($sNumeros,$sorte,1);
			}
		}
		return $novaSenha;
	}

	//função para verificar se a senha informada está correta
	function ChecaSenha($password,$dbpassword) {
		$salt = substr($dbpassword, 0, 64);
		$hash = $salt . $password;
		$loops=15;
		for ($i = 0; $i < $loops; $i ++) {
			$hash = hash('sha256', $hash);
		}
		$hash = $salt . $hash;
		if ($hash == $dbpassword) {
			return true;
		} else {
			return false;
		}
	}

	//função para verificar se a nova senha já foi usada
	function PermiteSenha($id,$novaSenha){
		$retorno=true;
		require("bdconnecta.php");
		$sql="SELECT senhaAnt FROM senhasantigas WHERE id=? ORDER BY dthrAlt DESC";

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
		$result=mysqli_stmt_get_result($stmt);
		while ($linhaBD=mysqli_fetch_assoc($result)){
			$umaSenhaAntiga=$linhaBD['senhaAnt'];
			if(ChecaSenha($novaSenha, $umaSenhaAntiga)){
				$retorno=false;
			}
		}
		if (!mysqli_stmt_close($stmt)){
			echo("Não foi possível efetuar a limpeza da conexão. Avise o setor de TI.");
			//mandar email/sms/alerta para o programador
		}
		return $retorno;
	}

	//função para contar qtde de senhas cadastradas no banco de dados
	function getQtdeSenhas($id){
		require ("bdconnecta.php");
		$qtdeSenhas=false;
		$sql="SELECT COUNT(senhaAnt) AS valor FROM senhasantigas WHERE id='$id'";
		$dataSet=mysqli_query($conn,$sql);
		if(!$dataSet){
			die("(função getQtdeSenhas) Não foi possível procurar parâmetro $id no BD!");
		}
		$linhaDados=mysqli_fetch_assoc($dataSet);
		if(!$linhaDados){
			echo(mysqli_error($conn));
			die("(função getQtdeSenhas) Não foi possível localizar parâmetro $id no BD!");
		}
		$qtdeSenhas=$linhaDados['valor'];
		return $qtdeSenhas;
	}

	//função para apagar senhas antigas
	function ApagarSenhasAnt($id){
		require("bdconnecta.php");

		//recuperando total de senhas cadastradas no BD
		$qtdeSenhas=getQtdeSenhas($id);

		if($qtdeSenhas>=3){
			//comando para apagar as senhas antigas
			$sql="delete from senhasantigas where id='$id' order by dthrAlt asc limit 1";
			$resultado=mysqli_query($conn,$sql);
			if(!$resultado){
				die("Não foi possível excluir senhas antigas");
			} else {
				echo("Senhas antigas apagadas com sucesso <br>");
			}
		}
	}

	//função para validar formatação da senha nova
	function validarFormatoSenha($senha){
		if(strlen($senha)<8) {
        	return ("A senha deve ter no mínimo 8 caracteres");
	    }
	    if(!preg_match('/[A-Z]/', $senha)) {
	        return ("A senha deve conter pelo menos uma letra maiúscula");
	    }
	    if(!preg_match('/[a-z]/', $senha)) {
	        return ("A senha deve conter pelo menos uma letra minúscula");
	    }
	    if(!preg_match('/[0-9]/', $senha)) {
	        return ("A senha deve conter pelo menos um número");
	    }
	    if(!preg_match('/[\W_]/', $senha)) {
	        return ("A senha deve conter pelo menos um caractere especial");
	    }
	    return true;
	}

	function senhaAtualEstaCorreta($id, $senhaASerVerificada){
		$retorno=true;
		require("bdconnecta.php");
		$sql="SELECT senha FROM usuario WHERE id=?";
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
		if (!mysqli_stmt_bind_result($stmt, $senhaBD)) {
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
		if(!ChecaSenha($senhaASerVerificada, $senhaBD)){
			$retorno=false;
		}
		return $retorno;
	}
?>