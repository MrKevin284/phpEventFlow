<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
</head>
<body>
    <div class="cabecalho_loja">

        <div class="logo_loja">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <center>
            <div class="nome_loja">
                <h1>Loja</h1>
            </div>
            <?php
            echo '<div class="botao_cadastro_produto"><a href="cadastro_produto.php">Cadastro de Produto</a></div>';
            ?>
        </center>

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

        <nav class="botoes_loja">
            <?php if ($tipo_usuario == 1): ?>
                <a href="eventos.php"><label>Eventos</label></a>
                <a href="eventos_criados.php"><label>Meus Eventos</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="EventFlow.php"><label>Logout</label></a>
            <?php elseif ($tipo_usuario == 2): ?>
                <a href="eventos.php"><label>Eventos</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="criar_eventos.php"><label>Criar Evento</label></a>
                <a href="EventFlow.php"><label>Logout</label></a>
            <?php endif; ?>
        </nav>

        <div class="container_loja">
            
                <?php
                // Incluir o arquivo de conexão com o banco de dados
                include 'conexao.php';

                // Consultar os produtos da tabela iten_loja
                $query = "SELECT * FROM iten_loja";
                $result = mysqli_query($conexao, $query);

                // Verificar se há produtos na tabela
                if (mysqli_num_rows($result) > 0) {
                    // Exibir os produtos
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="caixa_loja">';
                        echo '<h2>' . $row['nome'] . '</h2>';
                        echo '<p>' . $row['descricao'] . '</p>';
                        echo '<p>Quantidade: ' . $row['quantidade'] . '</p>';
                        echo '<p>Valor: R$ ' . $row['valor'] . '</p>';
                        echo '<form action="carrinho.php" method="POST">';
                        echo '<input type="hidden" name="iditem_loja" value="' . $row['iditem_loja'] . '">';
                        echo '<input type="submit" value="Adicionar ao carrinho">';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<p id="nenhum_produto_disponivel_na_loja">Nenhum produto disponível na loja.</p>';
                }

                // Fechar a conexão com o banco de dados
                mysqli_close($conexao);
                ?>
            <p></p>
        </div>
    </div>
</body>
</html>