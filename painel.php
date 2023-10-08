<?php
//session_start();
include('verifica_login.php');
?>

<h2>Olá, <?php echo $_SESSION['login'];?></h2>
<h2><a href="logout.php">Sair</a></h2>

<h2><a href="createProjetoArquivo.php">Cadastrar Projeto</a></h2>
<h2><a href="createCliente.php">Cadastrar Cliente</a></h2>
<h2><a href="createSubGrupo.php">Cadastrar Sub Grupo</a></h2>
<h2><a href="createProduto.php">Cadastrar Produto</a></h2>
<h2><a href="listFuncionario.php">Listar Funcionários</a></h2>
<h2><a href="listarProdutos.php">Listar Produtos</a></h2>
