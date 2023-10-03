<?php
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
                    <p><a href="listFuncionario.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
