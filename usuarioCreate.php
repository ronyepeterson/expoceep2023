<?php

  session_start();  

// Se o botao submit foi acionado, roda a funcao de login
if (isset($_GET['action']) == 'submitfunc') {
    submitusuario();
}

function submitusuario() {
    
    include("conexao.php");
    
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $login = mysqli_real_escape_string($conexao, trim($_POST['login']));
    $senha = mysqli_real_escape_string($conexao, trim(md5($_POST['senha'])));

    $sql = "select count(*) as total from usuario where login = '$login'";
    $result = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['usuario_existe'] = false;
    if($row['total'] >= 1) {
        $_SESSION['usuario_existe'] = true;
        $_SESSION['status_cadastro'] = false;
        return;
    } else {
        $sql = "INSERT INTO usuario (login, senha, nome) VALUES ('$login', '$senha', '$nome')";
        echo $sql;
        if($conexao->query($sql) === TRUE) {
            $_SESSION['usuario_existe'] = false;
            $_SESSION['status_cadastro'] = true;
        }
    }    
    $conexao->close();
}

?>

<main class="container">
    <div class="login-container">
        <form class="form-signin" action="?action=submitusuario" method="POST">
            <h1 class="h3 mb-3 font-weight-normal text-center">Cadastro de usuário</h1>

            <label for="inputNome">Usuário</label>
            <input type="text" name="nome" class="form-control" placeholder="Digite um o nome do usuário" required>
            <label for="inputLogin">Usuário</label>
            <input type="text" name="login" class="form-control" placeholder="Digite um login usuário" required>
            <label for="inputPassword">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Digite uma senha" required>

            <!-- Mensagem que não encontrou usuário -->
            <?php
            if (isset($_GET['action']) == 'submitfunc') {
                if ($_SESSION['usuario_existe']) {
                    echo "<div class='alert alert-warning' role='alert'>
                        Usuário já existente! 
                    </div>";
                } else {
                    echo "<div class='alert alert-success' role='alert'>
                        Usuário cadastrado com sucesso! 
                    </div>";
                }       
            }
            ?>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>
        </form>
    </div>
</main>

