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
        // Obter os dados do formulário para atualizar o evento
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

        // Verificar se a atualização do evento foi bem-sucedida
        if ($resultadoAtualizarEvento) {
            // Redirecionar para a página de eventos após a atualização bem-sucedida
            header('Location: eventos.php');
            exit();
        } else {
            // Exibir mensagem de erro caso a atualização do evento tenha falhado
            echo 'Erro ao atualizar o evento.';
        }

        // Obter os dados dos ingressos para atualizar
        $quantidades = $_POST['quantidade'];
        $valores = $_POST['valor'];

        // Atualizar os ingressos do evento no banco de dados
        $queryAtualizarIngressos = "UPDATE ingresso SET quantidade = ?, valor = ? WHERE id_ingresso = ? AND idevento = ?";
        $stmtAtualizarIngressos = $conexao->prepare($queryAtualizarIngressos);

        foreach ($quantidades as $indice => $quantidade) {
            $valor = $valores[$indice];
            $idIngresso = $indice + 1; // Supondo que os IDs dos ingressos começam em 1

            $stmtAtualizarIngressos->bind_param('ddii', $quantidade, $valor, $idIngresso, $idEvento);
            $resultadoAtualizarIngressos = $stmtAtualizarIngressos->execute();

            // Verificar se a atualização do ingresso foi bem-sucedida
            if (!$resultadoAtualizarIngressos) {
                // Exibir mensagem de erro caso a atualização do ingresso tenha falhado
                echo 'Erro ao atualizar os ingressos.';
                break; // Sair do loop em caso de erro
            }
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

    // Obter os dados dos ingressos do evento do banco de dados
    $queryObterIngressos = "SELECT * FROM ingresso WHERE idevento = ?";
    $stmtObterIngressos = $conexao->prepare($queryObterIngressos);
    $stmtObterIngressos->bind_param('i', $idEvento);
    $stmtObterIngressos->execute();
    $resultadoObterIngressos = $stmtObterIngressos->get_result();

    // Verificar se existem ingressos para o evento
    if ($resultadoObterIngressos && $resultadoObterIngressos->num_rows > 0) {
        $ingressos = $resultadoObterIngressos->fetch_all(MYSQLI_ASSOC);
    } else {
        $ingressos = array();
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

    <h2>Ingressos</h2>
    <?php foreach ($ingressos as $ingresso): ?>
        <label for="quantidade_<?php echo $ingresso['id_ingresso']; ?>">Quantidade:</label>
        <input type="number" id="quantidade_<?php echo $ingresso['id_ingresso']; ?>" name="quantidade[<?php echo $ingresso['id_ingresso']; ?>]" value="<?php echo $ingresso['quantidade']; ?>"><br><br>

        <label for="valor_<?php echo $ingresso['id_ingresso']; ?>">Valor:</label>
        <input type="text" id="valor_<?php echo $ingresso['id_ingresso']; ?>" name="valor[<?php echo $ingresso['id_ingresso']; ?>]" value="<?php echo $ingresso['valor']; ?>"><br><br>
        <label for="valor_estudante_<?php echo $ingresso['id_ingresso']; ?>">Valor Estudante:</label>
        <input type="text" id="valor_estudante_<?php echo $ingresso['id_ingresso']; ?>" name="valor_estudante[<?php echo $ingresso['id_ingresso']; ?>]" value="<?php echo $ingresso['valor']/2; ?>" readonly><br><br>
    <?php endforeach; ?>

    <input type="submit" value="Atualizar">
</form>

<br>

<form method="POST">
    <input type="submit" value="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este evento?');">
</form>
</body>
</html>
