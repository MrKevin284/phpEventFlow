<?php
// Incluir o arquivo de conexão com o banco de dados
require_once "conexao.php";

// Verificar se o usuário está logado
session_start();
if (!isset($_SESSION['idusuario'])) {
    header("location: login.php");
    exit();
}

// Verificar se foi fornecido o parâmetro de ID do evento
if (isset($_GET['id'])) {
    // Obter o ID do evento a partir do parâmetro da URL
    $id_evento = $_GET['id'];

    // Verificar se o usuário é o criador do evento
    $id_usuario = $_SESSION['idusuario'];
    $query_verificar_criador = "SELECT idevento FROM eventos WHERE idevento = $id_evento AND idusuario = $id_usuario";
    $resultado_verificar_criador = mysqli_query($conexao, $query_verificar_criador);

    if (mysqli_num_rows($resultado_verificar_criador) > 0) {
        // Excluir os ingressos relacionados ao evento
        $query_excluir_ingressos = "DELETE FROM ingresso WHERE idevento = $id_evento";
        mysqli_query($conexao, $query_excluir_ingressos);

        // Excluir o evento
        $query_excluir_evento = "DELETE FROM eventos WHERE idevento = $id_evento";
        mysqli_query($conexao, $query_excluir_evento);

        header("location: eventos.php");
        exit();
    } else {
        echo "Você não tem permissão para excluir este evento.";
    }
} else {
    echo "Evento não especificado.";
}
?>
