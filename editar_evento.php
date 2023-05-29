
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
        $dataEvento = $_POST['data_evento'];
        $horario = $_POST['horario'];

        // Atualizar os dados do evento no banco de dados
        $queryAtualizarEvento = "UPDATE eventos SET nome_evento = '$nomeEvento', endereco = '$endereco', descricao = '$descricao', data_evento = '$dataEvento', horario = '$horario' WHERE idevento = $idEvento";
        $resultadoAtualizarEvento = mysqli_query($conexao, $queryAtualizarEvento);

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
    $queryObterEvento = "SELECT * FROM eventos WHERE idevento = $idEvento";
    $resultadoObterEvento = mysqli_query($conexao, $queryObterEvento);

    // Verificar se o evento foi encontrado
    if ($resultadoObterEvento && mysqli_num_rows($resultadoObterEvento) > 0) {
        $evento = mysqli_fetch_assoc($resultadoObterEvento);
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

        <label for="data_evento">Data do Evento:</label>
        <input type="date" id="data_evento" name="data_evento" value="<?php echo $evento['data_evento']; ?>"><br><br>

        <label for="horario">Horário:</label>
        <input type="time" id="horario" name="horario" value="<?php echo $evento['horario']; ?>"><br><br>

        <input type="submit" value="Atualizar">
    </form>

    <br>

    <form method="POST">
        <input type="submit" value="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este evento?');">
    </form>
</body>
</html>




