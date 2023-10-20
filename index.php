<?php


require_once "conexao.php";
if (!mysqli_set_charset($conexao, 'utf8')) {
    printf('Error ao usar utf8: %s', mysqli_error($conexao));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expoceep</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Inclua os arquivos CSS do Bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <!-- Se você estiver usando os ícones do Bootstrap, inclua também o arquivo CSS dos ícones -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fonts-icones.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .wrapper {
            width: auto;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        .box-search {
            display: auto;
            justify-content: center;
            gap: .3%;
        }

        .cxpesquisa {
            border-radius: 10px 20px;
            width: 95%;
            height: 100%;
        }

        .expoceep {
            width: 20%;
            height: 20%;
            text-align: center;

        }

        h2 {
            color: Green;
            Font-weight: bold;
        }
    </style>

</head>

<body>
    <center><img src="logo.png" class="expoceep" /></center>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">

                        <h2>Lista de Projetos</h2>
                    </div>

                    <div class="box-search">
                        <input type="search" placeholder="Pesquisar" id="pesquisar" class="cxpesquisa">
                        <button onclick="searchData()" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>

                </div><!-- Search -->

            </div><!--Box Busca-->

            <?php

            // Include config file
            require_once "conexao.php";

            // SELECT NA TABELA PARA LISTAR 
            $sql = "SELECT * FROM projeto";

            if (!empty($_GET['search'])) {
                $data = $_GET['search'];
                $sql = "SELECT * FROM projeto WHERE titulo LIKE '%$data%' ORDER BY idprojeto DESC";
            } else {
                $sql = "SELECT * FROM projeto ORDER BY idprojeto DESC";
            }


            if ($result = mysqli_query($conexao, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo '<table class="table table-bordered table-striped">';
                    echo "<thead>";
                    echo "<tr>";
                    // COLUNAS DA TABELA DE LISTAGEM COM OS NOMES DOS CAMPOS
                    echo "<th class='col-lg-1'>#</th>"; // Coluna de largura 1
                    echo "<th class='col-lg-6'>Título do trabalho</th>"; // Coluna de largura 6
                    echo "<th class='col-lg-2'>Curso</th>"; // Coluna de largura 2
                    echo "<th class='col-lg-1'>Turno</th>"; // Coluna de largura 1
                    echo "<th class='col-lg-1'>Modalidade</th>"; // Coluna de largura 1
                    echo "<th class='col-lg-1'>Visualizar</th>"; // Coluna de largura 1
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td >" . $row['idprojeto'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['idcurso'] . "</td>";
                        echo "<td>" . $row['modalida_turno'] . "</td>";
                        echo "<td>" . $row['modalida_proj'] . "</td>";
                        echo "<td>";
                        echo '<a href="read.php?idprojeto=' . $row['idprojeto'] . '" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else {
                    echo '<div class="alert alert-danger"><em>Nenhum registro encontrado.</em></div>';
                }
            } else {
                echo "Oops! Foi mal, tente novamente depois.";
            }

            // Close connection
            mysqli_close($conexao);

            ?>

        </div>
    </div>
    </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    var search = document.getElementById('pesquisar');
    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });

    function searchData() {
        window.location = 'index.php?search=' + search.value;
    }
</script>

</html>