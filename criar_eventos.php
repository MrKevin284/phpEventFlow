<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Evento</title>
</head>
<body>
    <div class="logo_principal">
        <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
    </div>

    <a href="eventos.php">Eventos</a>
    <a href="meus_eventos.php">Meus Eventos</a>
    <a href="perfil.php">Perfil</a>
    <a href="login.php">Logout</a>

    <h1>Criar Evento</h1>

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

    // Verificar se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obter os dados do formulário
        $nome_evento = $_POST['nome_evento'];
        $endereco = $_POST['endereco'];
        $descricao = $_POST['descricao'];
        $data_evento = $_POST['data_evento'];
        $horario = $_POST['horario'];
        $quantidade_ingressos = $_POST['quantidade_ingressos'];
        $preco_inteira = number_format($_POST['preco_inteira'], 2, '.', '');

        // Inserir o evento no banco de dados
        $inserir_evento = "INSERT INTO eventos (nome_evento, endereco, descricao, data_evento, horario, idusuario) VALUES ('$nome_evento', '$endereco', '$descricao', '$data_evento', '$horario', $idusuario)";

        if (mysqli_query($conexao, $inserir_evento)) {
            $id_evento = mysqli_insert_id($conexao);

            // Inserir os ingressos disponíveis
            $inserir_ingressos = "INSERT INTO ingresso (quantidade, valor, id_tipoingresso, idevento) VALUES ($quantidade_ingressos, $preco_inteira, 1, $id_evento)";
            mysqli_query($conexao, $inserir_ingressos);

            // Calcular e inserir o preço da entrada estudante (50% do preço da entrada inteira)
            $preco_estudante = $preco_inteira * 0.5;
            $inserir_ingresso_estudante = "INSERT INTO ingresso (quantidade, valor, id_tipoingresso, idevento) VALUES ($quantidade_ingressos, $preco_estudante, 2, $id_evento)";
            mysqli_query($conexao, $inserir_ingresso_estudante);

            echo "Evento criado com sucesso.";
            echo "<br>";
            echo '<a href="eventos.php">Voltar para a página de eventos</a>';
        } else {
            echo "Erro ao criar o evento: " . mysqli_error($conexao);
        }

        // Fechar a conexão com o banco de dados
        mysqli_close($conexao);
    }
    ?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nome_evento">Nome do Evento:</label>
        <input type="text" id="nome_evento" name="nome_evento" required><br><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea><br><br>

        <label for="data_evento">Data do Evento:</label>
        <input type="date" id="data_evento" name="data_evento" required><br><br>

        <label for="horario">Horário do Evento:</label>
        <input type="time" id="horario" name="horario" required><br><br>

        <label for="quantidade_ingressos">Quantidade de Ingressos Disponíveis:</label>
        <input type="number" id="quantidade_ingressos" name="quantidade_ingressos" required><br><br>

        <label for="preco_inteira">Preço da Entrada Inteira:</label>
        <input type="number" id="preco_inteira" name="preco_inteira" step="0.01" required><br><br>

        <input type="submit" value="Criar Evento">
    </form>
</body>
</html>
