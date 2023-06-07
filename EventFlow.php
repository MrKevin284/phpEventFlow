<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventFlow</title>
</head>
<body>
    <div class="cabecalho">
        <div class="logo_principal">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>
        
        <nav class="botoes">
            <a href="login.php"><label>Login</label></a>
            <a href="tipo_de_usuario.php"><label>Cadastro</label></a>
            <a href="sobre_nos.php"><label>Sobre Nos</label></a>
        </nav>

        <div class="nome_usuario">
            <h2>Bem-vindo(a) ao EventFlow!</h2>
        </div>

        <div class="caixa">
            <h1 id="todos_os_eventos">Todos os Eventos:</h1>

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
                    // Obter a data de início e fim do evento
                    $dataInicio = date("d/m", strtotime($row["data_inicio_evento"]));
                    $dataFim = date("d/m", strtotime($row["data_final_evento"]));
                    echo '<div class="cartao">';
                    echo '<div class="cartao_esquerdo">';
                    echo '<span>' . $dataInicio . ' - ' . $dataFim . '</span>';
                    echo '<h1>' . $row["nome_evento"] . '</h1>';
                    echo '<h3>' . $row["palavra_chave"] . '</h3>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
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
