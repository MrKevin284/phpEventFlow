<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
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
        
        <div class="caixa">
            <h1 id="todos_os_eventos">Todos os Eventos</h1>

            <?php
            // Incluir o arquivo de conexão com o banco de dados
            require_once "conexao.php";

            // Consultar os eventos no banco de dados
            $consulta = "SELECT * FROM eventos";
            $resultado = mysqli_query($conexao, $consulta);

            // Verificar se existem eventos cadastrados
            if (mysqli_num_rows($resultado) > 0) {
                // Exibir os eventos
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo '<div class="cartao">';
                    echo '<div class="cartao_esquerdo">';
                    echo '<span>' . $row["nome_evento"] . '</span>';
                    echo '<h1>' . $row["nome_evento"] . '</h1>';
                    echo '<h3>' . $row["descricao"] . '</h3>';
                    echo '<a href="evento.php?id=' . $row["idevento"] . '">Clique aqui para saber mais!</a>';
                    echo '</div>';
                    echo '<div class="cartao_direito">';
                    echo '<img id="imagem" src="' . $row["imagem"] . '" alt="Evento">';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nenhum evento encontrado.</p>';
            }

            // Fechar a conexão com o banco de dados
            mysqli_close($conexao);
            ?>
    
        </div>
    </div>
</body>
</html>
