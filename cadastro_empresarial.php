<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Empresarial</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <form class="form_cadastro_empresarial" action="processa_cadastro.php" method="POST">

        <div class="logo_cadastro_empresarial">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <h1 id="user_empresarial">User Empresarial</h1>

        <div class="login_cadastro_comum">
            <input type="text" placeholder="Nome" name="nome" required><br>
            <input type="number" placeholder="CNPJ" name="cpf_cnpj" required><br>
            <input type="number" placeholder="Contato" name="telefone" required><br>
            <input type="text" placeholder="Empresa" name="empresa" required><br>
            <input type="text" placeholder="Email" name="email" required><br>
            <input type="password" placeholder="Senha" name="senha" required><br>
            <input type="hidden" name="tipo_user" value="2">
        </div>
        <div class="concluir_user_empresarial">
            <button type="submit" name="enviar" value="Entrar">
                <h1>Concluir</h1>
            </button><br>
        </div>

        <div class="voltar_user_empresarial">
            <?php
            echo '<a href="login.html"><img src="assets/imagens/seta-voltar.png"></a>';
            ?>
        </div>

    </form>
</body>

</html>

