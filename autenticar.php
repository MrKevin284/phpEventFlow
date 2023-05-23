<?php
session_start();

include('conexao.php');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

$query = "SELECT usuario.idusuario, usuario.tipo_user FROM login INNER JOIN usuario ON login.idusuario = usuario.idusuario WHERE login.email = '$email' AND login.senha = '$senha'";
$resultado = mysqli_query($conexao, $query);

if (mysqli_num_rows($resultado) == 1) {
    $row = mysqli_fetch_assoc($resultado);
    $idusuario = $row['idusuario'];
    $tipo_user = $row['tipo_user'];

    // Armazenar o ID do usuário e o tipo de usuário na sessão
    $_SESSION['idusuario'] = $idusuario;
    $_SESSION['tipo_user'] = $tipo_user;

    // Redirecionar para a página correta de acordo com o tipo de usuário
    if ($tipo_user == 1) {
        header("Location: eventos.php");
        exit();
    } elseif ($tipo_user == 2) {
        header("Location: eventos.php");
        exit();
    }
} else {
    // Caso o login seja inválido, redirecionar para a página de login novamente com uma mensagem de erro
    $_SESSION['login_erro'] = "Email ou senha inválidos";
    header("Location: login.php");
    exit();
}
?>
