<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Evento</title>
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

        // Verificar o tipo de usuário
        $query_tipo_usuario = "SELECT tipo_user FROM usuario WHERE idusuario = $idusuario";
        $resultado_tipo_usuario = mysqli_query($conexao, $query_tipo_usuario);
        $row_tipo_usuario = mysqli_fetch_assoc($resultado_tipo_usuario);
        $tipo_usuario = $row_tipo_usuario['tipo_user'];
        ?>

        <nav class="botoes">
            <?php if ($tipo_usuario == 1) { ?>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="meus_eventos.php"><label>Meus Eventos</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="login.php"><label>Logout</label></a>
            <?php } elseif ($tipo_usuario == 2) { ?>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                <a href="criar_eventos.php"><label>Criar Evento</label></a>
                <a href="login.php"><label>Logout</label></a>
            <?php } ?>
        </nav>

        <div class="nome_usuario">
            <h2>Bem-vindo(a), <?php echo $nome_usuario; ?>!</h2>
        </div>

        <div class="info_evento">
            <?php
            // Verificar se foi fornecido o parâmetro de ID do evento
            if (isset($_GET['id'])) {
                // Obter o ID do evento a partir do parâmetro da URL
                $id_evento = $_GET['id'];

                // Consultar o evento no banco de dados
                $query_evento = "SELECT * FROM eventos WHERE idevento = $id_evento";
                $resultado_evento = mysqli_query($conexao, $query_evento);
                $dados_evento = mysqli_fetch_assoc($resultado_evento);

                if ($dados_evento) {
                    echo '<h1>' . $dados_evento['nome_evento'] . '</h1>';
                    echo '<p>' . $dados_evento['descricao'] . '</p>';
                    // Exibir outras informações do evento, se houver
                } else {
                    echo '<p>Evento não encontrado.</p>';
                }
            } else {
                echo '<p>ID do evento não fornecido.</p>';
            }
            ?>

            <a href="eventos.php">Voltar para a lista de eventos</a>
        </div>
    </div>
</body>
</html>
