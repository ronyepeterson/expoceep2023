<?php
// Inclui arquivo config
require_once "config.php";
 
// Define variaveis e inicializa com valores vazios
$email = $modalida_proj = $titulo = $modalida_turno = $serieturma = $nome_coordenador = $area_proj = $idusuario = $idcurso = $caminhoImagemEnsalamento = $ensalamento"";
$email_err = $modalida_proj_err = $titulo_err = $modalida_turno_err = $serieturma_err = $nome_coordenador_err = $area_proj_err = $idusuario_err = $idcurso_err = $caminhoImagemEnsalamento_err = $ensalamento_err   "";
$sqlcurso = "SELECT * FROM curso";
$result = mysqli_query($conexao, $sqlcurso);
 
// Processa os dados quando o formulario é submetido
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Valida Email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor, digite um email.";
    } elseif(!filter_var($input_email, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-z0-9.]+@[a-z0-9]+\.[a-z]+\.([a-z]+)?$/i")))){
        $email_err = "Por favor, digite um email válido.";
    } else{
        $email = $input_email;
    }

    // Valida Titulo
    $input_titulo = trim($_POST["titulo"]);
    if(empty($input_titulo)){
        $titulo_err = "Por favor, digite um titulo.";     
    } else{
        $titulo = $input_titulo;
    }
    
    //Valida Serie Turma
    $input_serieturma = trim($_POST["turma"]);
    if(empty($input_serieturma)){
        $serieturma_err = "Por favor, digite uma turma.";     
    } else{
        $serieturma = $input_serieturma;
    }

    // Valida Nome Coordenador 
    $input_nome_coordenador = trim($_POST["coordenador"]);
    if(empty($input_nome_coordenador)){
        $nome_coordenador_err = "Por favor, digite o nome do coordenador.";     
    } else{
        $nome_coordenador = $input_nome_coordenador;
    }

    // Valida Area Projeto
    $input_area_projeto = trim($_POST["area projeto"]);
    if(empty($input_area_projeto)){
        $area_projeto_err = "Qual a area do projeto?";     
    } else{
        $area_projeto = $input_area_projeto;
    }

    // Valida Id Usuario
    $input_idusuario = trim($_POST["id usuario"]);
    if(empty($input_idusuario)){
        $idusuario_err = "Qual o id do usuario?";     
    } else{
        $idusuario = $input_idusuario;
    }

     // Valida Ensalamento
     $input_ensalamento = trim($_POST["ensalamento"]);
     if(empty($input_ensalamento)){
         $ensalamento_err = "?";     
     } else{
         $ensalamento = $input_ensalamento;
     }

    // Valida se existe erros no formulario antes de inserir dados na base
    if(empty($email_err) && empty($titulo_err) && empty($serieturma_err) && empty($nome_coordenador_err) && empty($areaprojeto_err) && empty($ensalamento_err) ){
        // Prepara comando SQL
        $sql = "INSERT INTO projeto (email, modalida_proj, titulo, modalida_turno, serieturma, nome_coordenador, area_proj, idusuario, idcurso, caminhoImagemEnsalamento, ensalamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "sssssssssss", $email, $modalida_proj, $titulo, $modalida_turno, $serieturma, $nome_coordenador, $area_proj, $idusuario, $idcurso, $caminhoImagemEnsalamento, $ensalamento);
            
           
             // Atribui parametros
             $param_email = $email;
             $param_modalida_proj = $modalida_proj;
             $param_titulo = $titulo;
             $param_modalida_turno = $modalida_turno;
             $param_serieturma = $serieturma;
             $param_nome_coordenador = $nome_coordenador;
             $param_area_proj = $area_proj;
             $param_idusuario = $idusuario;
             $param_idcurso = $idcurso;
             $param_caminhoImagemEnsalamento = "img/" . $caminhoImagemEnsalamento;
             $param_ensalamento = $ensalamento;
            
            // Tentativa de execucao do comando
            if(mysqli_stmt_execute($stmt)) {
                // Registros criados com sucesso. Redireciona para index.php
                echo("Registro incluido com sucesso!");
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
    mysqli_close($link);
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
                    <h2 class="mt-5"> Novo registro </h2>
                    <p>Por favor, preencha o formulário e salve os dados para inserir o o projeto na base de dados</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Modalidade Projeto</label>
                            <br>

                            <select name="modalida_proj">
                                
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Titulo</label>
                            <textarea name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>"><?php echo $titulo; ?></textarea>
                            <span class="invalid-feedback"><?php echo $titulo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Modalidade Turno</label>
                            <br>

                            <select name="modalida_turno">
                              
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Serie/Turma</label>
                            <input type="text" name="serieturma" class="form-control <?php echo (!empty($serieturma_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $serieturma; ?>">
                            <span class="invalid-feedback"><?php echo $serieturma_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nome do Coordenador</label>
                            <input type="text" name="nome_coordenador" class="form-control <?php echo (!empty($nome_coordenador_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome_coordenador; ?>">
                            <span class="invalid-feedback"><?php echo $nome_coordenador_err;?></span>
                        </div>          
                        <div class="form-group">
                            <label>Area do Projeto</label>
                            <input type="text" name="area_proj" class="form-control <?php echo (!empty($area_proj_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $area_proj; ?>">
                            <span class="invalid-feedback"><?php echo $area_proj_err;?></span>
                        </div>    
                        <div class="form-group">
                            <label>ID Usuario</label>
                            <input type="text" name="idusuario" class="form-control <?php echo (!empty($idusuario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idusuario; ?>">
                            <span class="invalid-feedback"><?php echo $idusuario_err;?></span>
                        </div>                
                        <div class="form-group">
                            <label>Id Curso</label>
                            <br>

                            <select name="idcurso">
                                <?php
                                header('Content-Type: text/html; charset=utf-8');

                                $i = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['idcurso']; ?>"><?= $row['nome']; ?></option>

                                <?php
                                    $i++;
                                }
                                ?>
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="caminhoImagemEnsalamento">Imagem Ensalamento</label>
                            <input type="file" id="caminhoImagemEnsalamento" name="caminhoImagemEnsalamento" class="form-control <?php echo (!empty($caminhoImagemEnsalamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $caminhoImagemEnsalamento; ?>">
                            <span class="invalid-feedback"><?php echo $caminhoImagemEnsalamento_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Salvar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>