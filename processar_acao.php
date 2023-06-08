<?php
// Incluir o arquivo de conexão com o banco de dados
require_once "conexao.php";

// Verificar se a ação foi enviada via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar qual ação foi solicitada
    $acao = $_POST['acao'];

    if ($acao == 'adicionar_carrinho') {
        // Obter os dados do formulário
        $id_ingresso = $_POST['id_ingresso'];
        $id_evento = $_POST['id_evento'];
        $quantidade = $_POST['quantidade'];

        // Validar os dados

        // Adicionar ao carrinho (lógica de adicionar ao carrinho aqui)

        // Iniciar a sessão, se ainda não estiver iniciada
        session_start();

        // Verificar se o carrinho já existe na sessão
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        // Verificar se o item já existe no carrinho
        $item_existe = false;
        foreach ($_SESSION['carrinho'] as $key => $item) {
            if ($item['id_ingresso'] == $id_ingresso) {
                // Atualizar a quantidade
                $_SESSION['carrinho'][$key]['quantidade'] += $quantidade;
                $item_existe = true;
                break;
            }
        }

        // Se o item não existe, adicionar ao carrinho
        if (!$item_existe) {
            $novo_item = array(
                'id_ingresso' => $id_ingresso,
                'quantidade' => $quantidade
            );
            $_SESSION['carrinho'][] = $novo_item;
        }

        // Redirecionar para o carrinho
        header("Location: carrinho.php");
        exit();
    } elseif ($acao == 'comprar') {
        // Obter os dados do formulário
        $id_ingresso = $_POST['id_ingresso'];
        $id_evento = $_POST['id_evento'];
        $quantidade = $_POST['quantidade'];

        // Validar os dados

        // Processar a compra (lógica de processar compra aqui)

        // Redirecionar para a página de confirmação de compra
        header("Location: pagamentos.php");
        exit();
    }
}

// Redirecionar para a página de eventos caso nenhum POST seja recebido
header("Location: eventos.php");
exit();
?>
