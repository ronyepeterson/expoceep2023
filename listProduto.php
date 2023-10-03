<?php
//session_start();
include('verifica_login.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <h2>Olá, <?php echo $_SESSION['nome'];?></h2>
    <h2><a href="logout.php">Sair</a></h2>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Listagem de Produtos</h2>
                        <a href="createProduto.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "conexao.php";
                    
                    // SELECT NA TABELA PARA LISTAR 
                    $sql = "SELECT * FROM produto";

                    if ($result = mysqli_query($conexao, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            // COLUNAS DA TABELA DE LISTAGEM COM OS NOMES DOS CAMPOS
                            echo "<th>#</th>";
                            echo "<th>Nome</th>";
                            echo "<th>Código</th>";
                            echo "<th>Quantidade</th>";
                            echo "<th>Valor Unitário</th>";
                            echo "<th>Sub Grupo</th>";
                            echo "<th>Ações</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['idProduto'] . "</td>";
                                echo "<td>" . $row['nome'] . "</td>";
                                echo "<td>" . $row['cod_produto'] . "</td>";
                                echo "<td>" . $row['quantidade'] . "</td>";
                                echo "<td>" . $row['valor_unit'] . "</td>";
                                echo "<td>" . $row['idSubProduto'] . "</td>";
                                echo "<td>";                        
                                    echo '<a href="produtoRead.php?idProduto=' . $row['idProduto'] . '" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';                          
                                    echo '<a href="produtoUpdate.php?idProduto=' . $row['idProduto'] . '" class="mr-3" title="Atualizar registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    echo '<a href="produtoDelete.php?idProduto=' . $row['idProduto'] . '" title="Excluir registro" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    mysqli_close($conexao);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>