<?php
include('verifica_login.php');
require_once "conexao.php";

if (!mysqli_set_charset($conexao, 'utf8')) {
    printf('Error ao usar utf8: %s', mysqli_error($conexao));
    exit;
}

// Define variaveis e inicializa com valores vazios
$email = $modalida_proj = $titulo = $modalida_turno = $serieturma = $nome_coordenador = $area_proj = $idcurso = $caminhoImagemEnsalamento = $ensalamento = "";
$idusuario = $_SESSION['idusuario'];
$loginUsuario = $_SESSION['login'];
$email_err = $modalida_proj_err = $titulo_err = $modalida_turno_err = $serieturma_err = $nome_coordenador_err = $area_proj_err = $idusuario_err = $idcurso_err = $caminhoImagemEnsalamento_err = $ensalamento_err =  "";
$sqlcurso = "SELECT * FROM curso";
$result = mysqli_query($conexao, $sqlcurso);

// Processa os dados quando o formulario é submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Valida Email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email_err = "Por favor, digite um email.";
    } else {
        $email = $input_email;
    }

    // Valida Titulo
    $input_titulo = trim($_POST["titulo"]);
    if (empty($input_titulo)) {
        $titulo_err = "Por favor, digite um titulo.";
    } else {
        $titulo = $input_titulo;
    }

    $input_modalida_proj = trim($_POST["modalida_proj"]);
    if (empty($input_modalida_proj)) {
        $modalida_proj_err = "Por favor, informe uma modalidade.";
    } else {
        $modalida_proj = $input_modalida_proj;
    }

      $input_modalida_turno = trim($_POST["modalida_turno"]);
      if (empty($input_modalida_turno)) {
          $modalida_turno_err = "Por favor, informe uma modalidade.";
      } else {
          $modalida_turno = $input_modalida_turno;
      }

    //Valida Serie Turma
    $input_serieturma = trim($_POST["serieturma"]);
    if (empty($input_serieturma)) {
        $serieturma_err = "Por favor, digite uma turma.";
    } else {
        $serieturma = $input_serieturma;
    }

    // Valida Nome Coordenador 
    $input_nome_coordenador = trim($_POST["nome_coordenador"]);
    if (empty($input_nome_coordenador)) {
        $nome_coordenador_err = "Por favor, digite o nome do coordenador.";
    } else {
        $nome_coordenador = $input_nome_coordenador;
    }

    $idcurso = trim($_POST["idcurso"]);
    $caminhoImagemEnsalamento = trim($_POST["caminhoImagemEnsalamento"]); 
    $area_proj = trim($_POST["area_proj"]);


    // Valida Ensalamento
    $input_ensalamento = trim($_POST["ensalamento"]);
    if (empty($input_ensalamento)) {
        $ensalamento_err = "Digite a sala por favor";
    } else {
        $ensalamento = $input_ensalamento;
    }

    // Valida se existe erros no formulario antes de inserir dados na base
    if (empty($email_err) && empty($titulo_err) && empty($serieturma_err) && empty($nome_coordenador_err) && empty($areaprojeto_err) && empty($ensalamento_err)) {
        // Prepara comando SQL
        $sql = "INSERT INTO projeto (email, modalida_proj, titulo, modalida_turno, serieturma, nome_coordenador, area_proj, idusuario, idcurso, caminhoImagemEnsalamento, ensalamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
echo $sql;
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "sssssssssss", $param_email, $param_modalida_proj, $param_titulo, $param_titulo, 
            $param_serieturma, $param_nome_coordenador, $param_area_proj, $param_idusuario, 
            $param_idcurso, $param_caminhoImagemEnsalamento, $param_ensalamento);


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

            echo $param_email."\n";
            echo $param_modalida_proj."\n";
            echo $param_titulo."\n";
            echo $param_modalida_turno."\n";
            echo $param_serieturma."\n";
            echo $param_nome_coordenador."\n";
            echo $param_area_proj."\n";
            echo " id usuario: ".$param_idusuario;
            echo " id curso: ".$param_idcurso."\n";
            echo $param_caminhoImagemEnsalamento."\n";
            echo $param_ensalamento."\n";

            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                // Registros criados com sucesso. Redireciona para index.php
                echo ("Registro incluido com sucesso!");
                header("location: index.php");
                exit();
            } else {
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
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title> Novo registro </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
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
                            <label>Titulo do Trabalho</label>
                            <input type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>">
                            <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Modalidade Projeto</label>
                            <br>

                            <select name="modalida_proj">
                                <option value="Trabalho de Pesquisa Escolar">Trabalho de Pesquisa Escolar</option>
                                <option value="Trabalho de Iniciação Científica">Trabalho de Iniciação Científica</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Modalidade Turno</label>
                            <br>

                            <select name="modalida_turno">
                                <option value="Integrado - Manhã">Integrado - Manhã</option>
                                <option value="Integrado - Tarde">Integrado - Tarde</option>
                                <option value="Subsequente - Noite">Subsequente - Manhã</option>
                                <option value="Subsequente - Noite">Subsequente - Tarde</option>
                                <option value="Subsequente - Noite">Subsequente - Noite</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Serie/Turma</label>
                            <input type="text" name="serieturma" class="form-control <?php echo (!empty($serieturma_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $serieturma; ?>">
                            <span class="invalid-feedback"><?php echo $serieturma_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Nome do Coordenador</label>
                            <input type="text" name="nome_coordenador" class="form-control <?php echo (!empty($nome_coordenador_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome_coordenador; ?>">
                            <span class="invalid-feedback"><?php echo $nome_coordenador_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Area do Projeto</label><br>
                            <select name="area_proj">
                                <option value="Engenharias e suas Aplicações">Engenharias e suas Aplicações</option>
                                <option value="Ciências Sociais">Ciências Sociais</option>
                                <option value="Ciências Humanas">Ciências Humanas</option>
                                <option value="Ciências Exatas e da Terra">Ciências Exatas e da Terra</option>
                                <option value="Ciências da Saúde">Ciências da Saúde</option>
                                <option value="Ciências Biológicas">Ciências Biológicas</option>
                                <option value="Ciências Agrárias">Ciências Agrárias</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Usuário</label>
                            <?php echo $loginUsuario; ?>
                        </div>
                        <div class="form-group">
                            <label>Curso</label>
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
                            <label>Ensalamento</label>
                            <input type="text" name="ensalamento" class="form-control <?php echo (!empty($ensalamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ensalamento; ?>">
                            <span class="invalid-feedback"><?php echo $ensalamento_err; ?></span>
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