<?php
define('HOST', 'localhost');
define('USUARIO', 'u224722929_expoceep');
define('SENHA', 's*4*4r!G');
define('DB', 'u224722929_expoceep');

$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Não foi possível conectar com o banco de dados..');
?>