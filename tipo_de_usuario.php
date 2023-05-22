<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de Usuário</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="fundo_tipo_cadastro">
        
            <div class="logo_usuario">
                <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
            </div>
            
            <div class="tipo_de_usuario">
                <?php
                    echo '<a href="cadastro_comum.php"><h1>Cadastro Comum</h1></a>';
                    echo '<a href="cadastro_empresarial.php"><h1>Cadastro Empresarial</h1></a><br>';
                ?>
            </div>

            <div class="voltar_usuario">
                <?php
                    echo '<a href="login.php"><h1>Voltar</h1></a>';
                ?>     
            </div>
    </div>
</body>
</html>