<?php
       include('verifica_login.php');
       require_once "conexao.php";

?>       
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Expoceep</title>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>Expoceep</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fonts-icones.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    .wrapper{
        width: 600px;
        margin: 0 auto;
    }
    table tr td:last-child{
        width: 120px;
    }
    .box-search{
        display: auto;
        justify-content: center;
        gap: .3%;  
    }
    .cxpesquisa{
        border-radius: 10px 20px;
        width: 91%;
        height:100%;
    }
    .expoceep{
        width:20%;
        height:20%;
        text-align:center;

    }
    label{
        color:Green;
        Font-weight:bold;
    }
    input{
        width:11%;
        height:11%;
    }

</style>
<body>
    <center>
<label>Caro Administrador Selecione abaixo a opção desejada:</label>
<div>
<p><a href="createProjeto.php" class="btn btn-primary">Cadastrar</a></p>

<p><a href="listaupdate.php" class="btn btn-primary">Atualizar</a></p>
                        
</div></center>

</body>