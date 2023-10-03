<?php
session_start();
include('conexao.php');

if(empty($_POST['login']) || empty($_POST['senha'])) {
	header('Location: index.php');
	exit();
}

$login = mysqli_real_escape_string($conexao, $_POST['login']);

$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

$query = "select login from usuario where login = '{$login}' and senha = md5('{$senha}')";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
echo $row;
if($row == 1) {
	$usuario_bd = mysqli_fetch_assoc($result);
	$_SESSION['login'] = $usuario_bd['login'];
	header('Location: painel.php');
	exit();
} else {
	$_SESSION['nao_autenticado'] = true;
	echo $query;
	header('Location: index.php');
	exit();
}