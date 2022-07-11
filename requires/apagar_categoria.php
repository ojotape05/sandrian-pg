<?php
    require('conexao.php');
    if(isset($_POST['excluir'])):
        $codigo= $_POST['codigo'];
        $sql = "UPDATE faca SET tipofaca = 1 WHERE tipofaca = '$codigo';";
        $resultado = mysqli_query($connect,$sql);
        $sql = " DELETE FROM tipofaca WHERE codigo = '$codigo';";
        mysqli_next_result($connect);
        $resultado = mysqli_query($connect,$sql);
        if($resultado):
            echo "<script>
                        javascript:history.go(-1);
                     window.location.href = '../listar_categorias.php';</script>';
                        </script>;";
          
        else:
            echo mysqli_error($connect);
        endif;
    endif;
    
    


?>