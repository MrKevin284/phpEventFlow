<?php
require_once "conexao.php";

session_start();

// Verifica se o usuário está logado e tem permissão de cadastro empresarial
if (!isUsuarioLogado() || !isCadastroEmpresarial()) {
    redirecionarParaLogin();
}

$errors = [];
$successMessage = '';

// Verifica se foi enviado o ID do produto a ser excluído
if (isset($_GET["delete"])) {
    $iditem_loja = intval($_GET["delete"]);
    excluirProduto($iditem_loja, $conexao, $successMessage, $errors);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $iditem_loja = intval($_POST["iditem_loja"]);
    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $quantidade = intval($_POST["quantidade"]);
    $valor = floatval($_POST["valor"]);

    validarCamposFormulario($nome, $descricao, $quantidade, $valor, $errors);

    if (empty($errors)) {
        atualizarProduto($iditem_loja, $nome, $descricao, $quantidade, $valor, $conexao, $successMessage, $errors);
    }
}

$produtos = obterListaProdutos($conexao);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Informações do Produto</title>
</head>
<body>
    <div class="cabecalho_info_produto">

            <div class="logo_info_produto">
                <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
            </div>

            <?php
        // Incluir o arquivo de conexão com o banco de dados
        require_once "conexao.php";

        // Obter informações do usuário logado
        $idusuario = $_SESSION['idusuario'];
        $query_usuario = "SELECT nome, tipo_user FROM usuario WHERE idusuario = $idusuario";
        $resultado_usuario = mysqli_query($conexao, $query_usuario);
        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
        $nome_usuario = $row_usuario['nome'];
        $tipo_usuario = $row_usuario['tipo_user'];
        ?>
            
            <nav class="botoes_eventos">
                <?php if ($tipo_usuario == 1) { ?>
                    <a href="perfil.php"><label>Perfil</label></a>
                    <a href="eventos_criados.php"><label>Meus Eventos</label></a>
                    <a href="carrinho.php"><label>Carrinho</label></a>
                    <a href="EventFlow.php"><label>Logout</label></a>
                <?php } elseif ($tipo_usuario == 2) { ?>
                    <a href="perfil.php"><label>Perfil</label></a>
                    <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                    <a href="criar_eventos.php"><label>Criar Evento</label></a>
                    <a href="carrinho.php">Carrinho</a>
                    <a href="EventFlow.php"><label>Logout</label></a>
                <?php } ?>
            </nav>

            <center>   
                <div class="nome_informações_do_produto">
                <h1>Informações do Produto</h1>
                </div>
            </center>

        <div class="container_info_produto">
            <div class="caixa_info_produto">
        
                <?php if (!empty($errors)) : ?>
                    <div style="color: red;">
                        <ul>
                            <?php foreach ($errors as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($successMessage !== '') : ?>
                    <div style="color: rgb(0, 255, 0);"><?php echo $successMessage; ?></div>
                <?php endif; ?>

                <?php foreach ($produtos as $produto) : ?>
                    <form class="form_info_produto" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <input type="hidden" name="iditem_loja" value="<?php echo $produto["iditem_loja"]; ?>">

                        <label for="nome">Nome do Produto:</label><br>
                        <input type="text" id="nome" name="nome" value="<?php echo $produto["nome"]; ?>" required><br>

                        <label for="descricao">Descrição:</label><br>
                        <textarea id="descricao" name="descricao" required><?php echo $produto["descricao"]; ?></textarea><br>

                        <label for="quantidade">Quantidade:</label><br>
                        <input type="number" id="quantidade" name="quantidade" value="<?php echo $produto["quantidade"]; ?>" required><br>

                        <label for="valor">Valor:</label><br>
                        <input type="text" id="valor" name="valor" value="<?php echo $produto["valor"]; ?>" required><br><br>

                        <a type="submit" value="Salvar">Salvar</a>
                        <a href="?delete=<?php echo $produto["iditem_loja"]; ?>" onclick="return confirm('Tem certeza que deseja excluir o produto?')">Excluir</a>

                    </form>

                    <hr>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php

function isUsuarioLogado() {
    return isset($_SESSION["idusuario"]);
}

function isCadastroEmpresarial() {
    return $_SESSION["tipo_user"] == 2;
}

function redirecionarParaLogin() {
    header("Location: login.php");
    exit;
}

function obterListaProdutos($conexao) {
    $idusuario = $_SESSION['idusuario'];
    $sql = "SELECT * FROM iten_loja WHERE idevento IN (SELECT idevento FROM eventos WHERE idusuario = ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idusuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $produtos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    mysqli_free_result($result);
    return $produtos;
}

function atualizarProduto($iditem_loja, $nome, $descricao, $quantidade, $valor, $conexao, &$successMessage, &$errors) {
    $sql = "UPDATE iten_loja SET nome = ?, descricao = ?, quantidade = ?, valor = ? WHERE iditem_loja = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ssidi", $nome, $descricao, $quantidade, $valor, $iditem_loja);

    if (mysqli_stmt_execute($stmt)) {
        $successMessage = "Produto atualizado com sucesso.";
    } else {
        $errors[] = "Erro ao atualizar o produto.";
    }

    mysqli_stmt_close($stmt);
}

function excluirProduto($iditem_loja, $conexao, &$successMessage, &$errors) {
    $sql = "DELETE FROM iten_loja WHERE iditem_loja = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $iditem_loja);

    if (mysqli_stmt_execute($stmt)) {
        $successMessage = "Produto excluído com sucesso.";
    } else {
        $errors[] = "Erro ao excluir o produto.";
    }

    mysqli_stmt_close($stmt);
}

function validarCamposFormulario($nome, $descricao, $quantidade, $valor, &$errors) {
    if (empty($nome)) {
        $errors[] = "O nome do produto é obrigatório.";
    }

    if (empty($descricao)) {
        $errors[] = "A descrição do produto é obrigatória.";
    }

    if ($quantidade <= 0) {
        $errors[] = "A quantidade do produto deve ser maior que zero.";
    }

    if ($valor <= 0) {
        $errors[] = "O valor do produto deve ser maior que zero.";
    }
}
?>