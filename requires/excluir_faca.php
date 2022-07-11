<?php
    require('conexao.php');
    if(isset($_POST['excluir'])):
        $codigo_faca = $_POST['codigo_faca'];
        $sql = "CALL ExcluirFaca($codigo_faca);";
        $resultado = mysqli_query($connect,$sql);
        if($resultado):
            echo "<script>alert('Faca apagada com sucesso!');
                        window.location.href = '../index.php';
                        </script>;";
          
        else:
            echo mysqli_error($connect);
        endif;
    endif;
    
    


?>