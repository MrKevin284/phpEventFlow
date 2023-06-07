<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Criados</title>
</head>
<body>
    <div class="cabecalho">
        <div class="logo_principal">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <?php
        // Incluir o arquivo de conexão com o banco de dados
        require_once "conexao.php";

        // Verificar se o usuário está logado
        session_start();
        if (!isset($_SESSION['idusuario'])) {
            header("location: login.php");
            exit();
        }

        // Obter informações do usuário logado
        $idusuario = $_SESSION['idusuario'];
        $query_usuario = "SELECT nome FROM usuario WHERE idusuario = $idusuario";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome_usuario = $row_usuario['nome'];
        ?>

        <nav class="botoes">
            <a href="eventos.php"><label>Eventos</label></a>
            <a href="criar_evento.php"><label>Criar Evento</label></a>
            <a href="carrinho.php"><label>Carrinho</label></a>
            <a href="perfil.php"><label>Perfil</label></a>
            <a href="EventFlow.php"><label>Logout</label></a>
        </nav>

        <div class="nome_usuario">
            <h2>Bem-vindo(a), <?php echo $nome_usuario; ?>!</h2>
        </div>

        <div class="eventos_criados">
            <h1>Eventos Criados:</h1>
            <?php
            // Consultar os eventos criados pelo usuário
            $query_eventos_criados = "SELECT * FROM eventos WHERE idusuario = $idusuario";
            $resultado_eventos_criados = mysqli_query($conexao, $query_eventos_criados);

            if (mysqli_num_rows($resultado_eventos_criados) > 0) {
                while ($dados_evento = mysqli_fetch_assoc($resultado_eventos_criados)) {
                    echo '<a href="info_evento.php?id=' . $dados_evento["idevento"] . '" class="caixa_evento">';
                    echo '<div class="cartao">';
                    echo '<div class="cartao_esquerdo">';
                    echo '<span>' . $dados_evento["nome_evento"] . '</span>';
                    echo '<h1>' . $dados_evento["nome_evento"] . '</h1>';
                    echo '<h3>' . $dados_evento["descricao"] . '</h3>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
            } else {
                echo '<p>Nenhum evento criado.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
