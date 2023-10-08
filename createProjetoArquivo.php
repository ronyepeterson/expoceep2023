<?php
include('verifica_login.php');
require_once "conexao.php";

 
// Define variaveis e inicializa com valores vazios
$email = $modalida_proj = $titulo = $caminhoImagemEnsalamento = "";
$email_err = $modalida_proj_err = $titulo_err = $caminhoImagemEnsalamento_err = "";


// Processa os dados quando o formulario é submetido
if($_SERVER["REQUEST_METHOD"] == "POST"){

 
 // Valida caminhoImagemEnsalamento
 $input_caminhoImagemEnsalamento = $_POST["caminhoImagemEnsalamento"];
 if(empty($input_caminhoImagemEnsalamento)){
     $caminhoImagemEnsalamento_err = "Por favor, Informe a imagem do ensalamento.";     
 } else{
     $caminhoImagemEnsalamento = $input_caminhoImagemEnsalamento;
 }   
    
    // Valida se existe erros no formulario antes de inserir dados na base
    if(empty($caminhoImagemEnsalamento_err)){
        // Prepara comando SQL
      
        $sql = "INSERT INTO projeto(email, modalida_proj, titulo, modalida_turno, serieturma, "
        ."nome_coordenador, area_proj, idusuario, idcurso, caminhoImagemEnsalamento, ensalamento) "
        ."VALUES (?,?,?,?,?,?,?,?,?,?,?)";
         echo $sql;
        if($stmt = mysqli_prepare($conexao, $sql)){
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "sssssssssss", $param_email, $param_modalida_proj, $param_titulo, $param_modalida_turno,
        $param_serieturma, $param_nome_coordenador,$param_area_proj,$param_idusuario, $param_idcurso, 
        $param_caminhoImagemEnsalamento, $param_ensalamento);
            
            // Atribui parametros
            $param_email = "ceep@gmail.com";
            $param_modalida_proj = "Pesquisa Escolar";
            $param_titulo = "Projeto Piloto Expoceep";
            $param_modalida_turno = "Noturno";
            $param_serieturma = "3o Semestre";
            $param_nome_coordenador = "Flavio Meotti";
            $param_area_proj = "Ciências Exatas";
            $param_idusuario = "1";
            $param_idcurso = "1";
            $param_caminhoImagemEnsalamento = "img/".$caminhoImagemEnsalamento;
            $param_ensalamento = "Sala 11";


            
            // Tentativa de execucao do comando
            if(mysqli_stmt_execute($stmt)) {               
                header("location: painel.php");
                exit();
            } else{
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        } else {
            echo "Desculpa, deu ruim!!!";
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
                    <h2 class="mt-5"> Novo Projeto </h2>
                    <p>Por favor, preencha o formulário e salve os dados para inserir o funcionário.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="caminhoImagemEnsalamento">Imagem Ensalamento</label>
                            <input type="file" id ="caminhoImagemEnsalamento" name="caminhoImagemEnsalamento" class="form-control <?php echo (!empty($caminhoImagemEnsalamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $caminhoImagemEnsalamento; ?>">
                            <span class="invalid-feedback"><?php echo $caminhoImagemEnsalamento_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Salvar">
                        <a href="painel.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>