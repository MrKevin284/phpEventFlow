<!DOCTYPE html>
<html>
<head>
    <title>Editar Evento</title>
</head>
<body>

<div class="logo_principal">
    <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
</div>

<a href="eventos.php">Eventos</a>
<a href="eventos_criados.php">Eventos Criados</a>
<a href="perfil.php">Perfil</a>
<a href="login.php">Logout</a>

<h1>Editar Evento</h1>

<?php
// Incluir o arquivo de conexão com o banco de dados
require_once 'conexao.php';

// Verificar se o ID do evento foi fornecido via GET
if (isset($_GET['id'])) {
    $idEvento = $_GET['id'];

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obter os dados do formulário
        $nomeEvento = $_POST['nome_evento'];
        $endereco = $_POST['endereco'];
        $descricao = $_POST['descricao'];
        $dataInicioEvento = $_POST['data_inicio_evento'];
        $dataFinalEvento = $_POST['data_final_evento'];
        $horarioInicial = $_POST['horario_inicial'];
        $horarioFinal = $_POST['horario_final'];

        // Atualizar os dados do evento no banco de dados
        $queryAtualizarEvento = "UPDATE eventos SET nome_evento = ?, endereco = ?, descricao = ?, data_inicio_evento = ?, data_final_evento = ?, horario_inicial = ?, horario_final = ? WHERE idevento = ?";
        $stmtAtualizarEvento = $conexao->prepare($queryAtualizarEvento);
        $stmtAtualizarEvento->bind_param('sssssisi', $nomeEvento, $endereco, $descricao, $dataInicioEvento, $dataFinalEvento, $horarioInicial, $horarioFinal, $idEvento);
        $resultadoAtualizarEvento = $stmtAtualizarEvento->execute();

        // Verificar se a atualização foi bem-sucedida
        if ($resultadoAtualizarEvento) {
            // Redirecionar para a página de eventos após a atualização bem-sucedida
            header('Location: eventos.php');
            exit();
        } else {
            // Exibir mensagem de erro caso a atualização tenha falhado
            echo 'Erro ao atualizar o evento.';
        }
    }

    // Obter os dados do evento do banco de dados
    $queryObterEvento = "SELECT * FROM eventos WHERE idevento = ?";
    $stmtObterEvento = $conexao->prepare($queryObterEvento);
    $stmtObterEvento->bind_param('i', $idEvento);
    $stmtObterEvento->execute();
    $resultadoObterEvento = $stmtObterEvento->get_result();

    // Verificar se o evento foi encontrado
    if ($resultadoObterEvento && $resultadoObterEvento->num_rows > 0) {
        $evento = $resultadoObterEvento->fetch_assoc();
    } else {
        // Redirecionar para a página de eventos se o evento não for encontrado
        header('Location: eventos.php');
        exit();
    }
} else {
    // Redirecionar para a página de eventos se o ID do evento não for fornecido
    header('Location: eventos.php');
    exit();
}
?>

<form method="POST">
    <label for="nome_evento">Nome do Evento:</label>
    <input type="text" id="nome_evento" name="nome_evento" value="<?php echo $evento['nome_evento']; ?>"><br><br>

    <label for="endereco">Endereço:</label>
    <input type="text" id="endereco" name="endereco" value="<?php echo $evento['endereco']; ?>"><br><br>

    <label for="descricao">Descrição:</label><br>
    <textarea id="descricao" name="descricao"><?php echo $evento['descricao']; ?></textarea><br><br>

    <label for="data_inicio_evento">Data de Início do Evento:</label>
    <input type="date" id="data_inicio_evento" name="data_inicio_evento" value="<?php echo $evento['data_inicio_evento']; ?>"><br><br>

    <label for="data_final_evento">Data de Término do Evento:</label>
    <input type="date" id="data_final_evento" name="data_final_evento" value="<?php echo $evento['data_final_evento']; ?>"><br><br>

    <label for="horario_inicial">Horário de Início:</label>
    <input type="time" id="horario_inicial" name="horario_inicial" value="<?php echo $evento['horario_inicial']; ?>"><br><br>

    <label for="horario_final">Horário de Término:</label>
    <input type="time" id="horario_final" name="horario_final" value="<?php echo $evento['horario_final']; ?>"><br><br>

    <input type="submit" value="Atualizar">
</form>

<br>

<form method="POST">
    <input type="submit" value="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este evento?');">
</form>
</body>
</html>
