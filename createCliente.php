<?php
include('verifica_login.php');
require_once "conexao.php";

 
// Define variaveis e inicializa com valores vazios
$nome = $endereco = $salario = "";
$nome_err = $endereco_err = $salario_err = "";
 
// Processa os dados quando o formulario é submetido
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valida nome
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Por favor, digite um nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-ZáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\s]+$/")))){                                                                                  
        $nome_err = "Por favor, digite um nome válido.";
    } else{
        $nome = $input_nome;
    }
    
    // Valida endereco
    $input_endereco = trim($_POST["endereco"]);
    if(empty($input_endereco)){
        $endereco_err = "Por favor, digite um endereço.";     
    } else{
        $endereco = $input_endereco;
    }
    
    // Valida salario
    $input_salario = trim($_POST["salario"]);
    if(empty($input_salario)){
        $salario_err = "Por favor, digite um salário.";     
    } elseif(!is_numeric($input_salario)){
        $salario_err = "Por favor, digite um valor Decimal.";
    } else{
        $salario = $input_salario;
    }
    
    // Valida se existe erros no formulario antes de inserir dados na base
    if(empty($nome_err) && empty($endereco_err) && empty($salario_err)){
        // Prepara comando SQL
        $sql = "INSERT INTO funcionario (nome, endereco, salario) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conexao, $sql)){
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "sss", $param_nome, $param_endereco, $param_salario);
            
            // Atribui parametros
            $param_nome = $nome;
            $param_endereco = $endereco;
            $param_salario = $salario;
            
            // Tentativa de execucao do comando
            if(mysqli_stmt_execute($stmt)) {               
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
         
        // Fecha comando
        mysqli_stmt_close($stmt);
    }
    
    // Fecha conexao
    mysqli_close($conexao);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Novo registro </title>
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
                    <h2 class="mt-5"> Novo Funcionário </h2>
                    <p>Por favor, preencha o formulário e salve os dados para inserir o funcionário.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Endereço</label>
                            <textarea name="endereco" class="form-control <?php echo (!empty($endereco_err)) ? 'is-invalid' : ''; ?>"><?php echo $endereco; ?></textarea>
                            <span class="invalid-feedback"><?php echo $endereco_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salário</label>
                            <input type="text" name="salario" class="form-control <?php echo (!empty($salario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salario; ?>">
                            <span class="invalid-feedback"><?php echo $salario_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Salvar">
                        <a href="listFuncionario.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>