<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a senha</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <form class="form_login_senha" action="resetar_senha.php" method="POST">

        <div class="logo_senha">
            <img src="assets/imagens/logo_fundo_removido.png" alt="Logo EventFlow">
        </div>

        <h1 id="redefinir_senha">Redefinir Senha</h1>

        <div class="login_senha">
            <input type="text" placeholder="Email" name="email" required><br>
            <input type="password" placeholder="Nova Senha" name="nova_senha" required><br>
        </div>

        <div class="concluir">
            <button type="submit" name="concluir" value="Concluir"><h1>Concluir</h1></button><br>
         </div>

         <div class="voltar_senha">
            <?php
                echo '<a href="login.php"><img src="assets/imagens/seta-voltar.png"></a>';
            ?>
         </div>

    </form>
</body>
</html>

