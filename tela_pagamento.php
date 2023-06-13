<?php
include 'conexao.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processar o método de pagamento selecionado
    if (isset($_POST['metodo_pagamento'])) {
        $metodo_pagamento = $_POST['metodo_pagamento'];

        // Processar os dados do pagamento conforme o método escolhido (PIX, cartão de crédito, etc.)
        if ($metodo_pagamento == 'pix') {
            // Processar o pagamento PIX

            // Exibir a chave PIX
            $chave_pix = "1234567890"; 
            // Substitua com a chave PIX correta
            echo "Chave PIX: $chave_pix<br>";

            // Limpar os produtos do carrinho
            $query_limpar_carrinho = "DELETE FROM carrinho_ingresso";
            mysqli_query($conexao, $query_limpar_carrinho);

            echo "Compra concluída. Obrigado!";
            exit;
        } elseif ($metodo_pagamento == 'cartao') {
            // Processar o pagamento com cartão de crédito

            // Verificar se todos os campos do formulário de cartão de crédito foram preenchidos
            if (isset($_POST['numero_cartao']) && isset($_POST['nome_titular']) && isset($_POST['cvv']) && isset($_POST['data_validade'])) {
                // Obter os dados do cartão de crédito do formulário
                $numero_cartao = $_POST['numero_cartao'];
                $nome_titular = $_POST['nome_titular'];
                $cvv = $_POST['cvv'];
                $data_validade = $_POST['data_validade'];

                // Processar os dados do cartão de crédito e finalizar a compra
                // ...

                // Limpar os produtos do carrinho e exibir a mensagem de compra concluída
                $query_limpar_carrinho = "DELETE FROM carrinho_ingresso";
                mysqli_query($conexao, $query_limpar_carrinho);

                echo "Compra concluída. Obrigado!";
                exit;
            } else {
                echo "Por favor, preencha todos os campos do formulário de cartão de crédito.";
            }
        }
    }
}

// Obter os produtos do carrinho
$query_produtos = "SELECT i.nome, i.valor, ci.quantidade FROM iten_loja i
                   INNER JOIN carrinho_ingresso ci ON ci.id_ingresso = i.iditem_loja
                   INNER JOIN carrinho c ON c.idcarrinho = ci.idcarrinho";
$result_produtos = mysqli_query($conexao, $query_produtos);

// Calcular o valor total da compra
$valor_total = 0;
while ($row_produto = mysqli_fetch_assoc($result_produtos)) {
    $valor_produto = $row_produto['valor'];
    $quantidade = $row_produto['quantidade'];
    $valor_total += ($valor_produto * $quantidade);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tela de Pagamento</title>

    <script>
    function exibirFormularioCartao() {
        var metodoPagamento = document.querySelector('input[name="metodo_pagamento"]:checked').value;
        var formularioCartao = document.getElementById('formulario_cartao');
        var chavePix = document.getElementById('chave_pix');

        if (metodoPagamento === 'cartao') {
            formularioCartao.style.display = 'block';
            chavePix.style.display = 'none';
        } else {
            formularioCartao.style.display = 'none';
            chavePix.style.display = 'block';
        }
    }
</script>

</head>
<body>
    <div class="cabecalho_tela_pagamento">

        <div class="logo_tela_pagamento">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

            <nav class="botoes_tela_pagamento">
                <a href="eventos.php"><label>Eventos</label></a>
                <a href="eventos_criados.php"><label>Meus Eventos</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="login.php"><label>Logout</label></a>
            </nav>
                
        <div class="container_tela_pagamento">
            <div class="caixa_tela_pagamento">

            <center>   
                <h1 id="nome_tela_de_pagamento">Tela de Pagamento</h1>
            </center>

                <div class="informacoes_tela_pagamento">
                    <h2>Itens do Carrinho:</h2>

                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Exibir os produtos do carrinho
                            $result_produtos = mysqli_query($conexao, $query_produtos);
                            while ($row_produto = mysqli_fetch_assoc($result_produtos)) {
                                echo "<tr>";
                                echo "<td>" . $row_produto['nome'] . "</td>";
                                echo "<td>" . $row_produto['valor'] . "</td>";
                                echo "<td>" . $row_produto['quantidade'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table><hr>

                    <h2>Valor Total: <?php echo $valor_total; ?></h2><hr>

                    <h3 id="nome_opcoes_de_pagamento">Opções de Pagamento:</h3>
                    <form method="POST" action="">
                        <input type="radio" name="metodo_pagamento" value="pix" onclick="exibirFormularioCartao()">PIX<br>
                        <input type="radio" name="metodo_pagamento" value="cartao" onclick="exibirFormularioCartao()">Cartão de Crédito<br>

                        <div class="informacoes_tela_pagamento" id="formulario_cartao" style="display: none;">
                            <h3 id="nome_dados_do_cartao_de_credito">Dados do Cartão de Crédito:</h3>
                            <label>Número do Cartão:</label>
                            <input type="number" name="numero_cartao"><br>
                            <label>Nome do Titular:</label>
                            <input type="number" name="nome_titular"><br>
                            <label>CVV:</label>
                            <input type="number" name="cvv"><br>
                            <label>Data de Validade:</label>
                            <input type="number" name="data_validade"><br>
                        </div>

                        <div id="chave_pix" style="display: none;">
                            <h3 id="nome_chave_pix">Chave PIX:</h3>
                            <p>1234567890</p>
                        </div>

                </div>
                        <br>
                    <center>
                        <button type="submit" name="submit" value="Finalizar Compra">Finalizar Compra</button><br>
                
                    </form>
                    <a href="carrinho.php"><button>Voltar ao Carrinho</button></a>
                    </center>
                    
            </div>
        </div>
    </div>
</body>
</html>