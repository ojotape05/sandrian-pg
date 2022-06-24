<?php 

    include("../requires/conexao.php");

    $erros = Array();
            
    $login = $_POST['login'];
    $senha = pg_escape_string($connect, $_POST['senha']);

    if(empty($login) or empty($senha)):
        $erros[] = "<script>alert('O campo login/senha precisa ser preenchido');</script>";
    else:
        $sql = "SELECT login FROM usuario WHERE login = '$login'";
        $resultado = pg_query($connect, $sql);
        
        if(pg_num_rows($resultado) > 0):
            
            $senha = md5($senha);
            $sql = "SELECT * FROM usuario WHERE login = '$login' AND senha = '$senha'";
            $resultado = pg_query($connect,$sql);
            
            if (pg_num_rows($resultado) == 1):
                $dados = pg_fetch_assoc($resultado); //transformando o resultado sql em um array para $dados
                pg_close();
                $_SESSION['logado'] = true;
                $_SESSION['admin'] = $dados['admin'];
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['id_usuario'] = $dados['codigo'];
                header('Location: ../telas/index.php');
            else:
                $erros[] = "<script>alert('Usuário e senha não conferem');</script>";
            endif;
            
        else:
            $erros[] = "<script>alert('Usuário inexiste');</script>";
        endif;
    endif;

    if(!empty($erros)):
        foreach($erros as $erro):
            echo $erro;
        endforeach;
    endif;
?>