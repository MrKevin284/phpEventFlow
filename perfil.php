<?php
include 'conexao.php';

session_start();
if (!isset($_SESSION['idusuario'])) {
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['idusuario'];

$query = "SELECT u.nome, u.cpf_cnpj, u.telefone, l.email, tu.id_funcao, u.empresa FROM usuario u
          INNER JOIN tipo_usuario tu ON u.tipo_user = tu.id_funcao
          INNER JOIN login l ON u.idusuario = l.idusuario
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
$emailUsuario = $dadosUsuario['email'];
$empresaUsuario = $dadosUsuario['empresa'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil</title>
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
                    <a href="EventFlow.php"><label>Logout</label></a>
                <?php } elseif ($tipoUsuario == 2) { ?>
                    <a href="eventos.php"><label>Eventos</label></a>
                    <a href="eventos_criados.php"><label>Eventos Criados</label></a>
                    <a href="carrinho.php"><label>Carrinho</label></a>
                    <a href="criar_eventos.php"><label>Criar Evento</label></a>
                    <a href="EventFlow.php"><label>Logout</label></a>
                <?php } ?>
            </nav>
        </div>

        <div class="informacoes_perfil">
            <h2>Informações do Perfil</h2>

            <div>
                <label>Nome:</label>
                <span><?php echo $nomeUsuario; ?></span>
            </div>

            <div>
                <label>
                    <?php
                    if ($tipoUsuario == 1) {
                        echo "CPF:";
                    } elseif ($tipoUsuario == 2) {
                        echo "CNPJ:";
                    }
                    ?>
                </label>
                <span><?php echo $cpfCnpjUsuario; ?></span>
            </div>

            <div>
                <label>Telefone:</label>
                <span><?php echo $telefoneUsuario; ?></span>
            </div>

            <div>
                <label>Email:</label>
                <span><?php echo $emailUsuario; ?></span>
            </div>
            
            <?php if ($tipoUsuario == 2) { ?>
            <div>
                <label>Empresa:</label>
                <span><?php echo $empresaUsuario; ?></span>
            </div>
            <?php } ?>

            <a href="editar_perfil.php">Editar Informações</a>
        </div>
    </div>
</body>
</html>
