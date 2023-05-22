// processa_cadastro.php

<?php

include('conexao.php');

$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cpf_cnpj = isset($_POST['cpf_cnpj']) ? $_POST['cpf_cnpj'] : '';
$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$tipo_user = isset($_POST['tipo_user']) ? $_POST['tipo_user'] : '';

$insert_usuario = "INSERT INTO usuario (nome, cpf_cnpj, tipo_user, telefone) VALUES ('$nome', '$cpf_cnpj', '$tipo_user', '$telefone')";
$query_usuario = mysqli_query($conexao, $insert_usuario);

$id_usuario = mysqli_insert_id($conexao);

$insert_login = "INSERT INTO login (email, senha, idusuario) VALUES ('$email', '$senha', '$id_usuario')";
$query_login = mysqli_query($conexao, $insert_login);

if ($query_usuario && $query_login) {
    header("location: login.php");
} else {
    echo "Erro ao cadastrar usuário. Por favor, tente novamente.";
}

?>
