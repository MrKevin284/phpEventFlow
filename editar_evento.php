<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    // Verificar se o usuário está logado e é um usuário empresarial
    session_start();
    if (!isset($_SESSION['idusuario'])) {
        header("location: login.php");
        exit();
    }

    $idusuario = $_SESSION['idusuario'];
    require_once "conexao.php";

    $query_usuario = "SELECT tipo_user FROM usuario WHERE idusuario = $idusuario";
    $resultado_usuario = mysqli_query($conexao, $query_usuario);
    $row_usuario = mysqli_fetch_assoc($resultado_usuario);
    $tipo_usuario = $row_usuario['tipo_user'];

    if ($tipo_usuario != 2) {
        echo "Acesso negado. Esta página é restrita para usuários empresariais.";
        exit();
    }

    // Verificar se o ID do evento foi fornecido como parâmetro
    if (!isset($_GET['id'])) {
        echo "ID do evento não fornecido.";
        exit();
    }

    $id_evento = $_GET['id'];

    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obter os dados do formulário
        $nome_evento = $_POST['nome_evento'];
        $endereco = $_POST['endereco'];
        $descricao = $_POST['descricao'];
        $data_evento = $_POST['data_evento'];
        $horario = $_POST['horario'];

        // Atualizar o evento no banco de dados
        $atualizar_evento = "UPDATE eventos SET nome_evento = '$nome_evento', endereco = '$endereco', descricao = '$descricao', data_evento = '$data_evento', horario = '$horario' WHERE idevento = $id_evento";

        if (mysqli_query($conexao, $atualizar_evento)) {
            echo "Evento atualizado com sucesso.";
            echo "<br>";
            echo '<a href="eventos_criados.php">Voltar para a lista de eventos criados</a>';
        } else {
            echo "Erro ao atualizar o evento: " . mysqli_error($conexao);
        }

        // Verificar se foram fornecidos ingressos
        if (isset($_POST['ingressos'])) {
            // Excluir os ingressos antigos do evento
            $excluir_ingressos = "DELETE FROM ingresso WHERE idevento = $id_evento";
            mysqli_query($conexao, $excluir_ingressos);

            // Inserir os novos ingressos no banco de dados
            foreach ($_POST['ingressos'] as $id_tipoingresso => $ingresso) {
                $quantidade_ingressos = $ingresso['quantidade'];
                $preco_ingresso = $ingresso['preco'];

                $inserir_ingresso = "INSERT INTO ingresso (quantidade, valor, id_tipoingresso, idevento) VALUES ($quantidade_ingressos, $preco_ingresso, $id_tipoingresso, $id_evento)";
                mysqli_query($conexao, $inserir_ingresso);
            }
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conexao);
    } else {
        // Consultar as informações do evento no banco de dados
        $consulta_evento = "SELECT * FROM eventos WHERE idevento = $id_evento";
        $resultado_evento = mysqli_query($conexao, $consulta_evento);
        $dados_evento = mysqli_fetch_assoc($resultado_evento);

        if (!$dados_evento) {
            echo "Evento não encontrado.";
            exit();
        }

        // Consultar os ingressos do evento no banco de dados
        $consulta_ingressos = "SELECT ti.id_tipoingresso, ti.descricao AS nome_tipoingresso, i.quantidade, i.valor FROM tipo_ingresso ti LEFT JOIN ingresso i ON ti.id_tipoingresso = i.id_tipoingresso WHERE i.idevento = $id_evento";
        $resultado_ingressos = mysqli_query($conexao, $consulta_ingressos);
        $ingressos = array();

        while ($ingresso = mysqli_fetch_assoc($resultado_ingressos)) {
            $ingressos[$ingresso['id_tipoingresso']] = $ingresso;
        }
    }
    ?>

    <form method="POST" action="">
        <label for="nome_evento">Nome do Evento:</label>
        <input type="text" name="nome_evento" id="nome_evento" value="<?php echo $dados_evento['nome_evento']; ?>">

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" value="<?php echo $dados_evento['endereco']; ?>">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"><?php echo $dados_evento['descricao']; ?></textarea>

        <label for="data_evento">Data do Evento:</label>
        <input type="date" name="data_evento" id="data_evento" value="<?php echo $dados_evento['data_evento']; ?>">

        <label for="horario">Horário:</label>
        <input type="time" name="horario" id="horario" value="<?php echo $dados_evento['horario']; ?>">

        <h2>Ingressos:</h2>

        <?php
        // Consultar os tipos de ingresso no banco de dados
        $consulta_tipo_ingresso = "SELECT * FROM tipo_ingresso";
        $resultado_tipo_ingresso = mysqli_query($conexao, $consulta_tipo_ingresso);

        while ($tipo_ingresso = mysqli_fetch_assoc($resultado_tipo_ingresso)) {
            $id_tipoingresso = $tipo_ingresso['id_tipoingresso'];
            $nome_tipoingresso = $tipo_ingresso['descricao'];
            $quantidade = isset($ingressos[$id_tipoingresso]['quantidade']) ? $ingressos[$id_tipoingresso]['quantidade'] : '';
            $valor = isset($ingressos[$id_tipoingresso]['valor']) ? $ingressos[$id_tipoingresso]['valor'] : '';

            echo '<div>';
            echo '<label for="quantidade_' . $id_tipoingresso . '">Quantidade de ' . $nome_tipoingresso . ':</label>';
            echo '<input type="number" name="ingressos[' . $id_tipoingresso . '][quantidade]" id="quantidade_' . $id_tipoingresso . '" value="' . $quantidade . '">';

            echo '<label for="valor_' . $id_tipoingresso . '">Valor de ' . $nome_tipoingresso . ':</label>';
            echo '<input type="number" step="0.01" name="ingressos[' . $id_tipoingresso . '][valor]" id="valor_' . $id_tipoingresso . '" value="' . $valor . '">';

            echo '</div>';
        }
        ?>

        <input type="submit" value="Atualizar Evento">
    </form>
</body>
</html>
