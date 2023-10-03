<?php
include('verifica_login.php');
require_once "conexao.php";

// Define variaveis e inicializa com valores vazios
$nome = $quantidade = $valor_unit = $cod_produto = $idSubProduto = "";
$nome_err = $quantidade_err = $valor_unit_err = $cod_produto_err = $idSubProduto_err = "";

$sqlSubGrupo = "SELECT * FROM subgrupo";
$result = mysqli_query($conexao, $sqlSubGrupo);

// Processa os dados quando o formulario é submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida nome
    $input_nome = trim($_POST["nome"]);
    if (empty($input_nome)) {
        $nome_err = "Por favor, digite um nome.";
    } else {
        $nome = $input_nome;
    }

    // Valida cod_produto
    $input_cod_produto = trim($_POST["cod_produto"]);
    if (empty($input_cod_produto)) {
        $cod_produto_err = "Por favor, digite um código numérico.";
    // } elseif (!is_numeric($input_cod_produto)) {
    //     $cod_produto_err = "Por favor, digite um valor inteiro para o código.";
    } else {
        $cod_produto = $input_cod_produto;
    }

    // Valida quantidade
    $input_quantidade = trim($_POST["quantidade"]);
    if (empty($input_quantidade)) {
        $quantidade_err = "Por favor, digite um código numérico.";
    // } elseif (!is_numeric($input_quantidade)) {
    //     $quantidade_err = "Por favor, digite um valor inteiro para o código.";
    } else {
        $quantidade = $input_quantidade;
    }

    // Valida valor_unit
    $input_valor_unit = trim($_POST["valor_unit"]);
    if (empty($input_valor_unit)) {
        $valor_unit_err = "Por favor, digite o valor unitário.";
    // } elseif (!is_numeric($input_valor_unit)) {
    //     $valor_unit_err = "Por favor, digite um valor Decimal.";
    } else {
        $valor_unit = $input_valor_unit;
    }

  
    $input_idSubProduto = trim($_POST["idSubProduto"]);
    $idSubProduto = $input_idSubProduto;

  

    // Valida se existe erros no formulario antes de inserir dados na base
    if (empty($nome_err) && empty($quantidade_err) && empty($valor_unit_err) && empty($cod_produto_err) && empty($idSubProduto_err)) {
        
        // Prepara comando SQL
        $sql = "INSERT INTO produto (cod_produto, nome, quantidade, valor_unit, idSubProduto) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "sssss",$param_cod_produto, $param_nome, $param_quantidade, $param_valor_unit, $param_idSubProduto);
            
            // Atribui parametros
            $param_cod_produto = $cod_produto;
            $param_nome = $nome;
            $param_quantidade = $quantidade;
            $param_valor_unit = $valor_unit;
            $param_idSubProduto = $idSubProduto;
     
            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                header("location: produtoList.php");
                exit();
            } else {
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }

        // Fecha comando
        mysqli_stmt_close($stmt);
    }else{
        echo "deu ruim!";
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
                <h2 class="mt-5"> Novo Produto </h2>
                <p>Por favor, preencha o formulário e salve os dados para inserir o produto.</p>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Código do Produto</label>
                        <input type="text" name="cod_produto" class="form-control <?php echo (!empty($cod_produto_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cod_produto; ?>">
                        <span class="invalid-feedback"><?php echo $cod_produto_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                        <span class="invalid-feedback"><?php echo $nome_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Valor Unitário</label>
                        <input type="text" name="valor_unit" class="form-control <?php echo (!empty($valor_unit_err)) ? 'is-invalid' : ''; ?>"><?php echo $valor_unit; ?>
                        <span class="invalid-feedback"><?php echo $valor_unit_err; ?></span>
                    </div>

                    <div class="form-group">
                    <label>Quantidade em estoque</label>
                        <input type="text" name="quantidade" class="form-control <?php echo (!empty($quantidade_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantidade; ?>">
                        <span class="invalid-feedback"><?php echo $quantidade_err; ?></span>
                    </div>


                    <!-- <div class="form-group">
                    <label>Sub Produto</label>
                        <input type="text" name="idSubProduto" class="form-control <?php echo (!empty($idSubProduto_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idSubProduto; ?>">
                        <span class="invalid-feedback"><?php echo $idSubProduto_err; ?></span>
                    </div> -->

                  
                    <div class="form-group">
                    <label>Sub Produto</label>
                    <br>

                    <select name="idSubProduto">
                    <?php
                        $i=0;
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                        <option value="<?=$row['idSubGrupo'];?>"><?=$row['codSub'] . ' - ' . $row['nome'];?></option>
 
                    <?php
                        $i++;
                        }
                    ?>
                    </select>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Salvar">
                    <a href="produtoList.php" class="btn btn-secondary ml-2">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
    </body>
</html>

