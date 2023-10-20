<?php
//x Inclui arquivo config
include('verifica_login.php');
require_once "conexao.php";

if (!mysqli_set_charset($conexao, 'utf8')) {
    printf('Error ao usar utf8: %s', mysqli_error($conexao));
    exit;
}

// Define variaveis e inicializa com valor vazio
$titulo = $modalida_proj = $modalida_turno = $serieturma = $nome_coordenador = $area_proj = $caminhoImagemEnsalamento = $ensalamento = "";
$modalida_proj_err = $modalida_turno_err = $serieturma_err = $nome_coordenador_err = $area_proj_err = $caminhoImagemEnsalamento_err = $ensalamento_err = "";


// Processa os formulario quando os dados sao submetidos
if (isset($_POST["idprojeto"]) && !empty($_POST["idprojeto"])) {
    // Pega atributo escondido
    $idprojeto = $_POST["idprojeto"];

    // Valida descricao
    $input_titulo = trim($_POST["titulo"]);
    if (empty($input_titulo)) {
        $titulo_err = "Por favor, digite o título.";
    } else {
        $titulo = $input_titulo;
    }

    // Valida descricao
    $input_modalida_proj = trim($_POST["modalida_proj"]);
    if (empty($input_modalida_proj)) {
        $modalida_proj_err = "Por favor, digite uma descricao.";
    } else {
        $modalida_proj = $input_modalida_proj;
    }


    // Valida qtd
    $input_modalida_turno = trim($_POST["modalida_turno"]);
    if (empty($input_modalida_turno)) {
        $modalida_turno_err = "Por favor, digite uma descricao.";
    } else {
        $modalida_turno = $input_modalida_turno;
    }

    // Valida valorUnitario
    $input_serieturma = trim($_POST["serieturma"]);
    if (empty($input_serieturma)) {
        $serieturma_err = "Por favor, digite uma descricao.";
    } else {
        $serieturma = $input_serieturma;
    }


    $input_nome_coordenador = trim($_POST["nome_coordenador"]);
    if (empty($input_nome_coordenador)) {
        $nome_coordenador_err = "Por favor, digite uma descricao.";
    } else {
        $nome_coordenador = $input_nome_coordenador;
    }

    $input_area_proj = trim($_POST["area_proj"]);
    if (empty($input_area_proj)) {
        $area_proj_err = "Por favor, digite a área do projeto.";
    } else {
        $area_proj = $input_area_proj;
    }

    $input_caminhoImagemEnsalamento = trim($_POST["caminhoImagemEnsalamento"]);
    if (empty($input_caminhoImagemEnsalamento)) {
        $caminhoImagemEnsalamento_err = "Por favor, digite o caminho da imagem .";
    } else {
        $caminhoImagemEnsalamento = $input_caminhoImagemEnsalamento;
    }

    $input_ensalamento = trim($_POST["ensalamento"]);
    if (empty($input_ensalamento)) {
        $ensalamento_err = "Por favor, digite o ensalamento.";
    } else {
        $ensalamento = $input_ensalamento;
    }


echo  'antes do erro <br>';

    // Valida erros do formulario antes de processar os dados
    if (empty($modalida_proj_err) && empty($modalida_turno_err) && empty($serieturma_err) && empty($nome_coordenador_err) && empty($area_proj_err) && empty($caminhoImagemEnsalamento_err) && empty($ensalamento_err)) {
        // Prepara comando update
        $sql = "UPDATE projeto SET titulo = ?, modalida_proj=?, modalida_turno=?, serieturma=?, nome_coordenador=?, area_proj=?, caminhoImagemEnsalamento=?, ensalamento=? WHERE idprojeto=?";

        echo $sql;
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "ssssssssi", $param_titulo, $param_modalida_proj, $param_modalida_turno, $param_serieturma, $param_nome_coordenador, $param_area_proj, $param_caminhoImagemEnsalamento, $param_ensalamento, $idprojeto);

            // Atribui parametros
            $param_titulo = $titulo;
            $param_modalida_proj = $modalida_proj;
            $param_modalida_turno = $modalida_turno;
            $param_serieturma = $serieturma;
            $param_nome_coordenador = $nome_coordenador;
            $param_area_proj = $area_proj;
            $param_caminhoImagemEnsalamento = $caminhoImagemEnsalamento;
            $param_ensalamento = $ensalamento;
            $param_id = $idprojeto;


            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                // Registros atualizados com sucesso. Redireciona para a listagem 
                header("location: listaupdate.php");
                exit();
            } else {
                echo "Oops! Alguma coisa deu errado. Por favor, tente novamente mais tarde.";
            }
        }

        // Fecha comando
        mysqli_stmt_close($stmt);
    }

    // Fecha conexao
    mysqli_close($conexao);
} else {
    // Valida a existencia do parametro id antes de processar os dados
    if (isset($_GET["idprojeto"]) && !empty(trim($_GET["idprojeto"]))) {
        // Pega parametro da URL
        $idprojeto =  trim($_GET["idprojeto"]);

        // Prepara comando select
        $sql = "SELECT * FROM projeto WHERE idprojeto = ?";
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Atribui parametros
            $param_id = $idprojeto;

            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Associa o resultado em um array. Como o resultado contem apenas uma
                    linha, nao eh preciso usar o comando while */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Recupera valor dos campos individualmente
                    $titulo = $row["titulo"];
                    $modalida_proj = $row["modalida_proj"];
                    $modalida_turno = $row["modalida_turno"];
                    $serieturma = $row["serieturma"];
                    $nome_coordenador = $row["nome_coordenador"];
                    $area_proj = $row["area_proj"];
                    $caminhoImagemEnsalamento = $row["caminhoImagemEnsalamento"];
                    $ensalamento = $row["ensalamento"];
                } else {
                    // URL nao contem parametro id valido. Redireciona para pagina de erro
                    header("location: error.php");
                    echo $sql;
                    exit();
                }
            } else {
                echo "Oops! Alguma coisa deu errado. Por favor, tente novamente mais tarde.";
            }
        }

        // Fecha comando
        mysqli_stmt_close($stmt);

        // Fecha conexao
        mysqli_close($conexao);
    } else {
        // URL nao contem parametro id. Redireciona para pagina de erro
        //echo $sql;
        header("location: error.php");
        exit();
    }
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
                    <h2 class="mt-5"> Atualização de Registro </h2>
                    <p>Por favor, preencha o formulário e salve os dados para inserir o o projeto na base de dados</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER["REQUEST_URI"])); ?>" method="post">
                        <div class="form-group">
                            <label>Título do Trabalho</label>
                            <input type="text" name="titulo" class="form-control <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>">
                            <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Modalidade Projeto</label>
                            <input type="text" name="modalida_proj" class="form-control <?php echo (!empty($modalida_proj_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $modalida_proj; ?>">

                            
                            <span class="invalid-feedback"><?php echo $modalida_proj_err; ?></span>
                        </div>


                        <div class="form-group">
                            <label>Modalidade Turno</label>
                            <input type="text" name="modalida_turno" class="form-control <?php echo (!empty($modalida_turno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $modalida_turno; ?>">
                            <span class="invalid-feedback"><?php echo $modalida_turno_err; ?></span>
                            
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
                            <label>Área do Projeto</label>
                            <input type="text" name="area_proj" class="form-control <?php echo (!empty($area_proj_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $area_proj; ?>">
                            <span class="invalid-feedback"><?php echo $area_proj_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Ensalamento</label>
                            <input type="text" name="ensalamento" class="form-control <?php echo (!empty($ensalamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ensalamento; ?>">
                            <span class="invalid-feedback"><?php echo $ensalamento_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="caminhoImagemEnsalamento">Imagem Ensalamento</label>
                            <input type="text" id="caminhoImagemEnsalamento" name="caminhoImagemEnsalamento" class="form-control <?php echo (!empty($caminhoImagemEnsalamento_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $caminhoImagemEnsalamento; ?>">
                            <span class="invalid-feedback"><?php echo $caminhoImagemEnsalamento_err; ?></span>
                        </div>

                        <input type="hidden" name="idprojeto" value="<?php echo $idprojeto; ?>" />
                        <input type="submit" class="btn btn-primary" value="Salvar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>