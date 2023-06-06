<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
</head>
<body>
    <div class="cabecalho">
        <div class="logo_principal">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <?php
        // Incluir o arquivo de conexão com o banco de dados
        require_once "conexao.php";

        // Verificar se o usuário está logado
        session_start();
        if (!isset($_SESSION['idusuario'])) {
            header("location: login.php");
            exit();
        }

        // Obter informações do usuário logado
        $idusuario = $_SESSION['idusuario'];
        $query_usuario = "SELECT nome, tipo_user FROM usuario WHERE idusuario = $idusuario";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome_usuario = $row_usuario['nome'];
        $tipo_usuario = $row_usuario['tipo_user'];
        ?>


        <nav class="botoes">
            <?php if ($tipo_usuario == 1): ?>
                <a href="eventos.php"><label>eventos</label></a>
                <a href="meus_eventos.php"><label>Meus Eventos</label></a>
                <a href="carrinho.php"><label>Carrinho</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="login.php"><label>Logout</label></a>
            <?php elseif ($tipo_usuario == 2): ?>
                <a href="eventos.php"><label>eventos</label></a>
                <a href="perfil.php"><label>Perfil</label></a>
                <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                <a href="criar_eventos.php"><label>Criar Evento</label></a>
                <a href="login.php"><label>Logout</label></a>
            <?php endif; ?>
        </nav>

        <div class="nome_usuario">
            <h2>Bem-vindo(a), <?php echo $nome_usuario; ?>!</h2>
        </div>
    </div>

    <div class="conteudo">
        <?php if (empty($_SESSION['carrinho'])) : ?>
            <p>O carrinho está vazio.</p>
        <?php else : ?>
            <?php foreach ($_SESSION['carrinho'] as $item) : ?>
                <p>ID do ingresso: <?php echo $item['id_ingresso']; ?>, Quantidade: <?php echo $item['quantidade']; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
