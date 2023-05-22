<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Comum</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <form class="form_cadastro_comum" action="processa_cadastro.php" method="POST">

        <div class="logo_cadastro_comum">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <h1 id="user_comum">User Comum</h1>

        <div class="login_cadastro_comum">
            <input type="text" placeholder="Nome" name="nome" required><br>
            <input type="number" placeholder="Telefone" name="telefone" required><br>
            <input type="number" placeholder="CPF" name="cpf_cnpj" required><br>
            <input type="text" placeholder="Email" name="email" required><br>
            <input type="password" placeholder="Senha" name="senha" required><br>
            <input type="hidden" name="tipo_user" value="1">
        </div>
        <div class="concluir_user_comum">
            <button type="submit" name="enviar" value="Entrar">
                <h1>Concluir</h1>
            </button><br>
        </div>

        <div class="voltar_user_comum">
            <?php
            echo '<a href="tipo_de_usuario.php"><img src="assets/imagens/seta-voltar.png"></a>';
            ?>

        </div>

    </form>
</body>

</html>

