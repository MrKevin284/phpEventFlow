<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pessoal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <form class="form_cadastro_pessoal" action="processa_cadastro.php" method="POST">
        <div class="logo_cadastro_pessoal">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>
        <h1 id="cadastro_pessoal">Cadastro Pessoal</h1>
        <div class="login_cadastro_pessoal">
            <input type="text" placeholder="Nome" name="nome" required><br>
            <input type="text" placeholder="Telefone" name="telefone" required><br>
            <input type="text" placeholder="CPF" name="cpf_cnpj" required><br>
            <input type="text" placeholder="Email" name="email" required><br>
            <input type="password" placeholder="Senha" name="senha" required><br>
            <input type="hidden" name="tipo_user" value="1">
        </div>
        <div class="concluir_cadastro_pessoal">
            <button type="submit" name="enviar" value="Entrar">
                <h1>Concluir</h1>
            </button><br>
        </div>
        <div class="voltar_cadastro_pessoal">
            <?php
            echo '<a href="tipo_de_usuario.php"><img src="assets/imagens/seta-voltar.png"></a>';
            ?>
        </div>
    </form>
</body>
</html>
