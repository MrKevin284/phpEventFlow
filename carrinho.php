<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link rel="stylesheet" href="assets/css/style2.css">
</head>
<body>
    <div class="cabecalho_carrinho">
        <div class="logo_carrinho">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <nav class="botoes_carrinho">
            <a href="eventos.php"><label>Eventos</label></a>
            <a href="eventos_criados.php"><label>Meus Eventos</label></a>
            <a href="carrinho.php"><label>Carrinho</label></a>
            <a href="perfil.php"><label>Perfil</label></a>
            <a href="login.php"><label>Logout</label></a>
        </nav>

        <center>
            <div class="nome_carrinho">
                <h1>Carrinho</h1>
            </div>
        </center>

        <div class="container_carrinho">
            <div class="conteudo_carrinho">
                <?php
                session_start();

                // Incluir o arquivo de conexão com o banco de dados
                include 'conexao.php';

                // Verificar se foi enviado o ID do item da loja
                if (isset($_GET['id'])) {
                    $iditem_loja = $_GET['id'];

                    // Consultar o item do carrinho pelo ID
                    $query_carrinho = "SELECT iten_loja.*, carrinho_ingresso.quantidade FROM iten_loja INNER JOIN carrinho_ingresso ON iten_loja.iditem_loja = carrinho_ingresso.id_ingresso WHERE iten_loja.iditem_loja = $iditem_loja";
                    $result_carrinho = mysqli_query($conexao, $query_carrinho);

                    // Verificar se a consulta foi executada corretamente
                    if (!$result_carrinho) {
                        die('Erro na consulta: ' . mysqli_error($conexao));
                    }

                    // Verificar se há itens no carrinho
                    if (mysqli_num_rows($result_carrinho) > 0) {
                        $row_carrinho = mysqli_fetch_assoc($result_carrinho);
                        $total_valor = $row_carrinho['valor'] * $row_carrinho['quantidade'];

                        echo '<table>';
                        echo '<tr><th>Nome</th><th>Descrição</th><th>Quantidade</th><th>Valor</th><th>Ação</th></tr>';
                        echo '<tr>';
                        echo '<td>' . $row_carrinho['nome'] . '</td>';
                        echo '<td>' . $row_carrinho['descricao'] . '</td>';
                        echo '<td>';
                        echo '<form action="" method="POST">';
                        echo '<div class="dados_carrinho">';
                        echo '<input type="hidden" name="iditem_loja" value="' . $row_carrinho['iditem_loja'] . '">';
                        echo '<input type="number" name="quantidade" value="' . $row_carrinho['quantidade'] . '">';
                        echo '<button type="submit" name="atualizar_quantidade" value="Atualizar">Atualizar</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</td>';
                        echo '<td>' . $row_carrinho['valor'] . '</td>';
                        echo '<td>';
                        echo '<form action="" method="POST">';
                        echo '<div class="dados_carrinho">';
                        echo '<input type="hidden" name="remover_item" value="' . $row_carrinho['iditem_loja'] . '">';
                        echo '<button type="submit" value="Remover">Remover</button>';
                        echo '</div>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                        echo '</table><hr>';

                        // Exibir o valor total da compra
                        echo '<p>Total: R$ ' . $total_valor . '</p>';

                        // Botão de finalizar compra
                        echo '<form class="form_carrinho" action="tela_pagamento.php" method="POST">';
                        echo '<div class="botao_carrino">';
                        echo '<input type="hidden" name="total_valor" value="' . $total_valor . '">';
                        echo '<button type="submit" value="Finalizar Compra">Finalizar Compra</button><br>';
                        echo '</form>';
                        // Botão para voltar à loja
                        echo '<button><a href="loja.php">Continuar Comprando</a></button>';
                        echo '</div>';
                    } else {
                        echo '<center>';
                        echo '<div class="botao_carrino">';
                        echo '<p id="nome_o_carrinho_esta_vazio">O carrinho está vazio.</p>';
                        // Botão para voltar à loja
                        echo '<button><a href="loja.php">Continuar Comprando</a></button>';
                        echo '</div>';
                        echo '</center>';
                    }
                } else {
                    echo '<p>Nenhum item selecionado.</p>';
                    echo '<button><a href="loja.php">Voltar à Loja</a></button>';
                }

                // Verificar se foi enviado o ID do item para remover do carrinho
                if (isset($_POST['remover_item'])) {
                    $iditem_loja_remover = $_POST['remover_item'];

                    // Remover o item do carrinho
                    $query_delete = "DELETE FROM carrinho_ingresso WHERE id_ingresso = $iditem_loja_remover";
                    mysqli_query($conexao, $query_delete);
                }

                // Verificar se foi enviado o formulário para atualizar a quantidade
                if (isset($_POST['atualizar_quantidade'])) {
                    $iditem_loja = $_POST['iditem_loja'];
                    $quantidade = $_POST['quantidade'];

                    // Atualizar a quantidade do item no carrinho
                    $query_atualizar = "UPDATE carrinho_ingresso SET quantidade = $quantidade WHERE id_ingresso = $iditem_loja";
                    mysqli_query($conexao, $query_atualizar);
                }

                // Fechar a conexão com o banco de dados
                mysqli_close($conexao);
                ?>
            </div>
        </div>
    </div>
</body>
</html>