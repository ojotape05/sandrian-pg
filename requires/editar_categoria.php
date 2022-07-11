<?php 

    include("conexao.php");

        $nome =   mysqli_escape_string($connect, $_POST['nome']);
        $codigo = $_POST["codigo"];
        $sql = "UPDATE tipofaca SET nome = '$nome' WHERE codigo = $codigo;";

                             $resultado = mysqli_query($connect,$sql);
                if ($resultado){

                    echo "<script>
                    javascript:history.go(-1);
                     window.location.href = '../listar_categorias.php';</script>";
                    mysqli_close($connect);
                }
                
                else{
                    $erro = mysqli_error($connect);
                    echo "<script>alert('$erro');</script>";}
                
