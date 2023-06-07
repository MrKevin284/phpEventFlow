<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
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
        $query_usuario = "SELECT nome, tipo_user FROM usuario WHERE idusuario = $idusuario";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome_usuario = $row_usuario['nome'];
        $tipo_usuario = $row_usuario['tipo_user'];
        ?>


        <nav class="botoes">
            <?php if ($tipo_usuario == 1): ?>
                <a href="eventos.php"><label>eventos</label></a>
                <a href="meus_eventos.php"><label>Meus Eventos</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="EventFlow.php"><label>Logout</label></a>
            <?php elseif ($tipo_usuario == 2): ?>
                <a href="eventos.php"><label>eventos</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="criar_eventos.php"><label>Criar Evento</label></a>
                <a href="EventFlow.php"><label>Logout</label></a>
            <?php endif; ?>
        </nav>

        <div class="nome_usuario">
            <h2>Bem-vindo(a), <?php echo $nome_usuario; ?>!</h2>
        </div>

        <div class="caixa">
            <h1 id="loja">Loja</h1>

            <?php
            // Consultar os produtos na loja
            $consulta = "SELECT * FROM iten_loja";
            $resultado = mysqli_query($conexao, $consulta);

            // Verificar se existem produtos cadastrados
            if (mysqli_num_rows($resultado) > 0) {
                // Exibir os produtos
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo '<div class="produto">';
                    echo '<h2>' . $row["nome_produto"] . '</h2>';
                    echo '<p>' . $row["descricao"] . '</p>';
                    echo '<p>R$' . $row["preco"] . '</p>';
                    echo '<button class="adicionar_carrinho">Adicionar ao Carrinho</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nenhum produto encontrado.</p>';
            }

            // Fechar a conexão com o banco de dados
            mysqli_close($conexao);
            ?>
        </div>
    </div>
</body>
</html>
