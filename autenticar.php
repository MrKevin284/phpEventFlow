<?php

include('conexao.php');
include('valida_usuario.php');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

$select = "SELECT idusuario, tipo_user FROM usuario JOIN login ON usuario.idusuario = login.idusuario WHERE email = '$email' AND senha = '$senha'";
$query = mysqli_query($conexao, $select);
$dado = mysqli_fetch_assoc($query);

if ($dado) {
    session_start();
    $_SESSION['idusuario'] = $dado['idusuario'];
    $_SESSION['tipo_user'] = $dado['tipo_user'];
    
    if ($dado['tipo_user'] == 1) {
        header("location: principal_comum.php");
    } elseif ($dado['tipo_user'] == 2) {
        header("location: principal_empresarial.php");
    }
} else {
    header("location: login.php");
}

?>

