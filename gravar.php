<?php
//adaptado pra qualquer versão do apache e do sql
    include("tururu.php");
    $luser='root'; //username que será gravado
    $conn=mysqli_connect($db_server,$db_user,$db_password,$db_database) or die('Impossível conectar!');

    $foto = $_FILES["arquivojpg"]; // $foto do PHP recebe o arquivo POSTado no upload.php
    $nomeFinal = 'uploads/fotinha.jpg'; //nome do arquivo que chegou será fotinha.jpg na past uploads

    if(move_uploaded_file($foto['tmp_name'], $nomeFinal)){ //tmp_name devolve o nome que tá lá na pasta tmp e troca pro $nomeFinal
        $tamanhoImg = filesize($nomeFinal); //pega o tamanho da $nomeFinal, que é fotinha. Tamanho da foto que enviamos em bytes
        $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); //delimitador de tamanho. Começo e fim. Abre o arquivo pra "leitura" = "r" e lê o tamanho em bytes
        
        $sql = "INSERT INTO fotinhos (username, foto) VALUES ('$luser', '$mysqlImg')";
        mysqli_query($conn, $sql); //executa o sql em conn
        mysqli_close($conn); //fecha a conexão com o banco e
        echo("<script> alert('Foto gravada com sucesso!');</script>");
        
    }else{
        echo("<script> alert('Não foi possível gravar!');</script>");
    }


?>