<?php
// Valida a existencia do parametro id antes de processar os dados
if(isset($_GET["idprojeto"]) && !empty(trim($_GET["idprojeto"]))){
    // Inclui arquivo config
    require_once "conexao.php";
    
    // Prepara comando select
    $sql = "SELECT * FROM projeto WHERE idprojeto = ?";
    $sqlaluno = "SELECT * FROM aluno WHERE idprojeto = ?";
    $sqlcurso = "SELECT * FROM curso WHERE idcurso = ?";
    
    if($stmt = mysqli_prepare($conexao, $sql)){
        // Vincula variaveis com os parametros do comando
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Atribui parametros
        $param_id = trim($_GET["idprojeto"]);
        
        // Tentativa de execucao do comando
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){

                /* Associa o resultado em um array. Como o resultado contem apenas uma
                linha, nao eh preciso usar o comando while */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Recupera valor dos campos individualmente
                $titulo = $row["titulo"];
                $idcurso = $row["idcurso"];
                $modalida_proj = $row["modalida_proj"];
                $serieturma = $row["serieturma"];
                $nome_coordenador = $row["nome_coordenador"];
                $area_proj = $row["area_proj"];
                $ensalamento = $row["ensalamento"];
                $caminhoImagemEnsalamento = $row["caminhoImagemEnsalamento"];
            } else{
                // URL nao possui parametro id valido. Redireciona para pagina de erro
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Alguma coisa deu errado. Por favor, tente novamente mais tarde.";
        }
    }
    if ($stmt2 = mysqli_prepare($conexao, $sqlaluno)) {
                
        mysqli_stmt_bind_param($stmt2, "i", $param_id);
        if (mysqli_stmt_execute($stmt2)) {
            $result2 = mysqli_stmt_get_result($stmt2);
            if (mysqli_num_rows($result2) == 1) {
              $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
              $nome = $row2["nome"];
         
          }
        }
    }  

    if ($stmt3 = mysqli_prepare($conexao, $sqlcurso)) {
                
        mysqli_stmt_bind_param($stmt3, "i", $idcurso);
        if (mysqli_stmt_execute($stmt3)) {
            $result3 = mysqli_stmt_get_result($stmt3);
            if (mysqli_num_rows($result3) == 1) {
              $row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);
              $nomecurso = $row3["nome"];
         
          }
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
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title> Detalhes do registro </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;   
            margin: 0 auto;
        }
        label{
            color:blue;
            font-weight:bold;
        }
        h1{
            color:Green;
            Font-weight:bold;
            
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DETALHES DO REGISTRO -->
                    <h1>Detalhes do Projeto</h1>
                    <div class="form-group">
                        <label>Titulo</label>
                        <p><b><?php echo $row["titulo"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Curso</label>
                        <p><b><?php echo $nomecurso; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Alunos:</label>
                        <p><b><?php echo $nome; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Modalidade Projeto</label>
                        <p><b><?php echo $row["modalida_proj"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Serie e Turma</label>
                        <p><b><?php echo $row["serieturma"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Nome do Coordenador</label>
                        <p><b><?php echo $row["nome_coordenador"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Area do Projeto</label>
                        <p><b><?php echo $row["area_proj"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Ensalamento</label>
                        <p><b><?php echo $row["ensalamento"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Caminho</label>
                        <img src="<?php echo $row["caminhoImagemEnsalamento"]; ?>" />
                    </div>
                    <p><a href="Index.php" class="btn btn-primary">Voltar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
