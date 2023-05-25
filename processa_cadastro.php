<?php
include('conexao.php');

$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cpf_cnpj = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$tipo_user = isset($_POST['tipo_user']) ? $_POST['tipo_user'] : '';
$empresa = isset($_POST['empresa']) ? $_POST['empresa'] : '';

// Prepara a consulta para inserir o usuário
$insert_usuario = "INSERT INTO usuario (nome, cpf_cnpj, tipo_user, telefone, empresa) VALUES (?, ?, ?, ?, ?)";
$stmt_usuario = mysqli_prepare($conexao, $insert_usuario);
mysqli_stmt_bind_param($stmt_usuario, "ssiss", $nome, $cpf_cnpj, $tipo_user, $telefone, $empresa);
$query_usuario = mysqli_stmt_execute($stmt_usuario);

// Obtém o ID do usuário inserido
$id_usuario = mysqli_insert_id($conexao);

// Prepara a consulta para inserir o login
$insert_login = "INSERT INTO login (email, senha, idusuario) VALUES (?, ?, ?)";
$stmt_login = mysqli_prepare($conexao, $insert_login);
mysqli_stmt_bind_param($stmt_login, "ssi", $email, $senha, $id_usuario);
$query_login = mysqli_stmt_execute($stmt_login);

if ($query_usuario && $query_login) {
    header("location: login.php");
    exit();
} else {
    echo "Erro ao cadastrar usuário. Por favor, tente novamente.";
}
?>

