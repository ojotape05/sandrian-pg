<?php

///O erro se trata de usar duas querys na mesma conexão, mysqli_next_result($connect) aceita uma nova query, mas caso dê errado tente
//fechar a conexão e abrir uma nova para cada query
    include("conexao.php");
    if($_POST):
        $result = mysqli_query($connect,"SELECT * FROM operacao WHERE concluida = 0");
        $n = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $codigo = $row['codigo'];
            if(isset($_POST["baixa".$codigo])):
                $baixa = $_POST["baixa".$codigo];
                if($baixa == 'confirma'):
                    if(isset($_POST["comprador".$codigo]) and isset($_POST["valor_venda".$codigo])):
                        $baixa = $_POST["baixa".$codigo];
                        $codigo_processamento = $_POST["codigo".$n];
                        $comprador_processamento = $_POST["comprador".$codigo];
                        $valor_venda = $_POST["valor_venda".$codigo];
                        $metodo_pag = $_POST["metodopag".$codigo];
                        if (isset($_POST["obs".$codigo])):
                            $obs = $_POST["obs".$codigo];
                        else:
                            $obs = "";
                        endif;
                        mysqli_next_result($connect);
                        $resultado = mysqli_query($connect,"CALL ConfirmarCompra('$codigo_processamento','$comprador_processamento','$valor_venda','$obs', '$metodo_pag')");
                    endif;
                elseif($baixa == 'cancela'):
                    mysqli_next_result($connect);
                    $codigo_processamento = $_POST["codigo".$n];
                    $resultado = mysqli_fetch_assoc(mysqli_query($connect,"SELECT codigoFaca FROM operacao WHERE codigo = $codigo_processamento"));
                    $codigo_faca = $resultado['codigoFaca'];
                    $resultado = mysqli_query($connect,"CALL cancelarBaixa('$codigo_processamento','$codigo_faca')");
                endif;
            endif;
            $n = $n + 1; 
        endwhile;
    endif;
    header("Location: ../processamentos.php");
?>