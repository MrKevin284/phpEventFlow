<?php
session_start();

// Verificar se o carrinho de compras já existe na sessão
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array(); // Inicializar carrinho vazio
}

// Verificar se foi enviado o formulário de adicionar ao carrinho
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_ingresso']) && isset($_POST['quantidade'])) {
    $id_ingresso = $_POST['id_ingresso'];
    $quantidade = $_POST['quantidade'];

    // Validar quantidade (certifique-se de adicionar suas próprias validações, se necessário)
    if (!is_numeric($quantidade) || $quantidade <= 0) {
        echo 'Quantidade inválida. Por favor, insira um valor válido.';
        exit;
    }

    // Adicionar ingresso ao carrinho
    $item = array(
        'id_ingresso' => $id_ingresso,
        'quantidade' => $quantidade
    );

    $_SESSION['carrinho'][] = $item;
}

// Exibir conteúdo do carrinho
if (empty($_SESSION['carrinho'])) {
    echo 'O carrinho está vazio.';
} else {
    foreach ($_SESSION['carrinho'] as $item) {
        echo 'ID do ingresso: ' . $item['id_ingresso'] . ', Quantidade: ' . $item['quantidade'] . '<br>';
    }
}
?>
