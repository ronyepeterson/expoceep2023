<?php

if(isset($_POST["idFuncionario"]) && !empty($_POST["idFuncionario"])){
    // Inclui arquivo config
    require_once "conexao.php";
    
    // SQL de exclusao de registro
    $sql2 = "DELETE FROM funcionario WHERE idFuncionario = ?";
    
    if($stmt2 = mysqli_prepare($conexao, $sql2)){
        // // Vincula as variaveis com os parametros
         mysqli_stmt_bind_param($stmt2, "i", $param_id2);
        
        // Atribui parametros 
        $param_id2 = trim($_POST["idFuncionario"]);
        
        // Executa SQL
        if(mysqli_stmt_execute($stmt2)){
            // Registros excluidos com sucesso. Redireciona para index.php
            header("location: listFuncionario.php");
            exit();
        } else{
            echo "Oops! Algo deu errado. Tente novamente mais tarde.";
        }
    }
     
    mysqli_stmt_close($stmt2);
    
    // Fecha conexao
    mysqli_close($conexao);
} else{
    // Procura a existencia do parametro id
    if(empty(trim($_GET["idFuncionario"]))){
        // URL nao possui o parametro id. Redireciona para pagina error.php
        header("location: error.php");
        exit();
    }
}


// Valida a existencia do parametro idFuncionario antes de processar os dados
if(isset($_GET["idFuncionario"]) && !empty(trim($_GET["idFuncionario"]))){
    // Inclui arquivo config
    require_once "conexao.php";
    
    // Prepara comando select
    $sql = "SELECT * FROM funcionario WHERE idFuncionario = ?";

    if($stmt = mysqli_prepare($conexao, $sql)){
        // Vincula variaveis com os parametros do comando
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Atribui parametros
        $param_id = trim($_GET["idFuncionario"]);
        
        // Tentativa de execucao do comando
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){

                /* Associa o resultado em um array. Como o resultado contem apenas uma
                linha, nao eh preciso usar o comando while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recupera valor dos campos individualmente
                $nome = $row["nome"];
                $endereco = $row["endereco"];
                $salario = $row["salario"];
            } else{
                // URL nao possui parametro id valido. Redireciona para pagina de erro
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Alguma coisa deu errado. Por favor, tente novamente mais tarde.";
        }
    }
     
    
    // Fecha comando
    mysqli_stmt_close($stmt);
    
    // Fecha conexao
    mysqli_close($conexao);
} else{
    
    // URL nao contem parametro id. Redireciona para pagina de erro
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Detalhes do registro </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DETALHES DO REGISTRO -->
                    <h1 class="mt-5 mb-3">Detalhes do registro</h1>
                    <div class="form-group">
                        <label>Nome</label>
                        <p><b><?php echo $row["nome"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Endereço</label>
                        <p><b><?php echo $row["endereco"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salário</label>
                        <p><b><?php echo $row["salario"]; ?></b></p>
                    </div>
                    
                    
                    <h2 class="mt-5 mb-3">Excluir registro</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="idFuncionario" value="<?php echo trim($_GET["idFuncionario"]); ?>"/>
                            <p>Tem certeza que deseja deletar esse registro?</p>
                            <p>
                                <input type="submit" value="Sim" class="btn btn-danger">
                                <a href="listFuncionario.php" class="btn btn-secondary">Não</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
