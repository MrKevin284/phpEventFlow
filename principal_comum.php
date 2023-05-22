<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Principal | Usuário Comum</title>
    <link rel="stylesheet" href="assets/css/principal_comum.css">

</head>
<body>
    <div class="cabecalho">
        <div class="logo_principal">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>
    
        <nav class="botoes">
            <a href="principal_comum.php"> <label>Inicio</label></a>
            <a href="eventos.php"> <label>Eventos</label></a>
            <a href="ingressos.php"> <label>Ingressos</label></a>
            <a href="perfil.php"> <label>Perfil</label></a>       
        </nav>

        <div class="evento_destaque">
            <h1>Evento em destaque no EventFlow</h1>
        </div>

        <div class="caixa_evento">
            <img id="imagem_caixa" src="assets/imagens/evento_bgs.png" alt="Evento BGS">
            <h1 id="caixa_nome">Brasil Game Show</h1>
            <div class="caixa_botao">
                <?php
                    echo '<a href="evento_bgs.php">Ver Detalhes</a>';
                ?>
            </div>
        </div>

    </div>   
</body>
</html>