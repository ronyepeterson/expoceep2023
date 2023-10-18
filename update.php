<?php
// Inclui arquivo config
include("header.php");
require_once "conexao.php";


// Define variaveis e inicializa com valor vazio
$modalida_proj = $titulo = $modalida_turno = $serieturma = $nome_coordenador = $area_proj = $caminhoImagemEnsalamento = $ensalamento = "";
$modalida_proj_err = $titulo_err = $modalida_turno_err = $serieturma_err = $nome_coordenador_err = $area_proj_err = $caminhoImagemEnsalamento_err = $ensalamento_err = "";

$sqlSubGrupo = "SELECT * FROM projeto";
$resultSub = mysqli_query($conexao, $sqlprojeto);

// Processa os formulario quando os dados sao submetidos
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Pega atributo escondido
    $id = $_POST["id"];

    // Valida descricao
    $input_modalida_proj = trim($_POST["modalida_proj"]);
    if (empty($input_modalida_proj)) {
        $modalida_proj_err = "Por favor, digite uma descricao.";
    } else {
        $modalida_proj = $input_modalida_proj;
    }

    // Valida codigo
    $input_titulo = trim($_POST["titulo"]);
    if (empty($input_titulo)) {
        $titulo_err = "Por favor, digite uma descricao.";
    } else {
        $titulo = $input_titulo;
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
        $area_proj_err = "Por favor, digite uma descricao.";
    } else {
        $area_proj = $input_area_proj;
    }

    $input_caminhoImagemEnsalamento = trim($_POST["caminhoImagemEnsalamento"]);
    if (empty($input_caminhoImagemEnsalamento)) {
        $caminhoImagemEnsalamento_err = "Por favor, digite uma descricao.";
    } else {
        $caminhoImagemEnsalamento = $input_caminhoImagemEnsalamento;
    }

    $input_ensalamento = trim($_POST["ensalamento"]);
    if (empty($input_ensalamento)) {
        $ensalamento_err = "Por favor, digite uma descricao.";
    } else {
        $ensalamento = $input_ensalamento;
    }

    


    // Valida erros do formulario antes de processar os dados
    if (empty($modalida_proj_err) && empty($titulo_err) && empty($modalida_turno_err) && empty($serieturma_err) && empty($nome_coordenador_err) && empty($area_proj_err) && empty($caminhoImagemEnsalamento_err) && empty($ensalamento_err)) {
        // Prepara comando update
        $sql = "UPDATE projeto SET modalida_proj=?, titulo=?, modalida_turno=?, serieturma=?, nome_coordenador=?, area_proj=?, caminhoImagemEnsalamento=?, ensalamento=? WHERE id=?";
        

        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_modalida_proj, $param_titulo, $param_modalida_turno, $param_serieturma, $param_nome_coordenador, $param_area_proj, $param_caminhoIamgemEnsalamento, $param_ensalamento);

            // Atribui parametros
            $param_modalida_poj = $modalida_proj;
            $param_titulo = $titulo;
            $param_modalida_turno = $modalida_turno;
            $param_serieturma = $serieturma;
            $param_nome_coordenador = $nome_coordenador;
            $param_area_proj = $area_proj;
            $param_caminhoImagemEnsalamento = $caminhoImagemEnsalamento;
            $param_ensalamento = $ensalamento;


            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                // Registros atualizados com sucesso. Redireciona para a listagem 
                header("location: update.php");
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
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Pega parametro da URL
        $id =  trim($_GET["id"]);

        // Prepara comando select
        $sql = "SELECT * FROM projeto WHERE id = ?";
        if ($stmt = mysqli_prepare($conexao, $sql)) {
            // Vincula variaveis com os parametros do comando
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Atribui parametros
            $param_id = $id;

            // Tentativa de execucao do comando
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Associa o resultado em um array. Como o resultado contem apenas uma
                    linha, nao eh preciso usar o comando while */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Recupera valor dos campos individualmente
                    $modalida_proj = $row["modalida_proj"];
                    $titulo = $row["titulo"];
                    $modalida_turno = $row["modalida_turno"];
                    $serieturma = $row["serieturma"];
                    $nome_coordenador = $row["nome_coordenador"];
                    $area_proj = $row["area_proj"];
                    $caminhoImagemEnsalamento = $row["caminhoImagemEnsalamento"];
                    $ensalamento = $row["ensalamento"];

                } else {
                    // URL nao contem parametro id valido. Redireciona para pagina de erro
                    header("location: error.php");
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
                    <h2 class="mt-5"> Novo registro </h2>
                    <p>Por favor, preencha o formulário e salve os dados para inserir o o projeto na base de dados</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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