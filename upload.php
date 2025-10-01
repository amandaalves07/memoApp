<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload de arquivo jpg</title>
    </head>
    <body>
        <h2>Upload de arquivo JPG</h2>
        <form action="gravar.php" method = "POST" enctype="multipart/form-data">
            Selecione o arquivo: <input type="file" name="arquivojpg"><br>
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>