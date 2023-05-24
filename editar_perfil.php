<?php
include 'conexao.php';

session_start();
if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['idusuario'];

$query = "SELECT u.nome, u.cpf_cnpj, u.telefone, tu.id_funcao, u.empresa FROM usuario u
          INNER JOIN tipo_usuario tu ON u.tipo_user = tu.id_funcao
          WHERE u.idusuario = ?";
$stmt = $conexao->prepare($query);
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$resultado = $stmt->get_result();
$dadosUsuario = $resultado->fetch_assoc();

if (!$dadosUsuario) {
    header('Location: login.php');
    exit();
}

$nomeUsuario = $dadosUsuario['nome'];
$tipoUsuario = $dadosUsuario['id_funcao'];
$cpfCnpjUsuario = $dadosUsuario['cpf_cnpj'];
$telefoneUsuario = $dadosUsuario['telefone'];
$empresaUsuario = $dadosUsuario['empresa'];

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];

    // Verificar o tipo de usuário e obter o valor do campo CPF/CNPJ
    if ($tipoUsuario == 1) {
        $cpfCnpj = $_POST['cpf_cnpj'];
    } elseif ($tipoUsuario == 2) {
        $cpfCnpj = $_POST['cpf_cnpj'];
    }

    // Atualizar as informações no banco de dados
    $queryAtualizar = "UPDATE usuario SET nome = ?, telefone = ?, cpf_cnpj = ? WHERE idusuario = ?";
    $stmtAtualizar = $conexao->prepare($queryAtualizar);
    $stmtAtualizar->bind_param('sssi', $nome, $telefone, $cpfCnpj, $idUsuario);
    $stmtAtualizar->execute();

    // Redirecionar para a página de perfil após a atualização
    header('Location: perfil.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <div class="container">
        <div class="cabecalho">
            <div class="nome_usuario">
                <p>Bem-vindo(a), <?php echo $nomeUsuario; ?>!</p>
            </div>
            <nav class="botoes">
                <?php if ($tipoUsuario == 1) { ?>
                    <a href="eventos.php"><label>Eventos</label></a>
                    <a href="meus_eventos.php"><label>Meus Eventos</label></a>
                    <a href="carrinho.php"><label>Carrinho</label></a>
                <?php } elseif ($tipoUsuario == 2) { ?>
                    <a href="eventos.php"><label>Eventos</label></a>
                    <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                    <a href="lojas_eventos.php"><label>Lojas de Eventos</label></a>
                    <a href="criar_eventos.php"><label>Criar Evento</label></a>
                <?php } ?>
                <a href="login.php"><label>Logout</label></a>
            </nav>
        </div>

        <div class="informacoes_perfil">
            <h2>Editar Informações</h2>

            <form method="POST">
                <div>
                    <label>Nome:</label>
                    <input type="text" name="nome" value="<?php echo $nomeUsuario; ?>">
                </div>

                <div>
                    <label>Telefone:</label>
                    <input type="text" name="telefone" value="<?php echo $telefoneUsuario; ?>">
                </div>

                <?php if ($tipoUsuario == 1) { ?>
                <div>
                    <label>CPF:</label>
                    <input type="text" name="cpf_cnpj" value="<?php echo $cpfCnpjUsuario; ?>">
                </div>
                <?php } elseif ($tipoUsuario == 2) { ?>
                <div>
                    <label>CNPJ:</label>
                    <input type="text" name="cpf_cnpj" value="<?php echo $cpfCnpjUsuario; ?>">
                </div>
                <?php } ?>

                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>
    <a href="perfil.php">Voltar</a>
</body>
</html>
