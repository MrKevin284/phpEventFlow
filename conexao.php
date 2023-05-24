<?php

//LOCAL
$conexao = mysqli_connect('localhost', 'root', '', 'eventflow');
if (!$conexao) {
    die('Não foi possível conectar: ' . mysqli_connect_error());
}

?>
