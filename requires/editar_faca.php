<?php 

    include("conexao.php");

    $erros = Array();
    $formatosPermitidos = array("png", "jpeg", "jpg","jfif");
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'],PATHINFO_EXTENSION));
    $imagembase64 = base64_encode(file_get_contents($_FILES['imagem']['tmp_name']));
    $imagem = 'data:imagem/'.$extensao.';base64,'.$imagembase64;

    if(in_array($extensao, $formatosPermitidos)  or empty($extensao)):
        if(empty($imagembase64)){
        
            $imagem = mysqli_escape_string($connect, $_POST['oldimagem']);
        }
            
        $nome =   mysqli_escape_string($connect, $_POST['nome']);
        $descricao =   mysqli_escape_string($connect, $_POST['descricao']);
        $tipo =  mysqli_escape_string($connect, $_POST['tipo']);
        $link =  mysqli_escape_string($connect, $_POST['link']);
        $codigo_faca = intval($_POST['codigo_faca']);
        $custo = intval($_POST['custo']);
        $lanceInicial = intval($_POST['lance']);
        $estoque =   intval($_POST['estoque']);
        $fornecedor =   mysqli_escape_string($connect, $_POST['fornecedor']);

        $ofertaSemLance = mysqli_escape_string($connect, $_POST['ofertaSemLance']);

       

            if($ofertaSemLance == "sim"):
                $ofertaSemLance = 1;
            else:
                $ofertaSemLance = 0;
            endif;

            $descricao = "*Lance Inicial: R$$lanceInicial*

            " . $descricao ."

            *Lance Inicial: R$$lanceInicial*";

            $sql = "SELECT * FROM tipofaca WHERE nome = '$tipo'";
            $resultado = mysqli_query($connect,$sql);

            if(mysqli_num_rows($resultado) > 0): //se houver o tipo especificado
                $consulta = mysqli_fetch_assoc($resultado);
                $cod_tipofaca = $consulta["codigo"];
                              $sql = "UPDATE faca SET lanceinicial = $lanceInicial, custo = $custo, nome = '$nome', descricao = '$descricao', img = '$imagem', linkFotos = '$link',  permitir_planceinicial = '$ofertaSemLance', tipofaca = $cod_tipofaca, fornecedor = '$fornecedor', estoquedisponivel = '$estoque' WHERE codigo = $codigo_faca;";

                             $resultado = mysqli_query($connect,$sql);
                if ($resultado):

                    echo "<script>alert('Edição realizada');
                      javascript:history.go(-1);
                     window.location.href = '../faca.php?faca=$codigo_faca';</script>";
                    mysqli_close($connect);
                    
                else:
                    $erro = mysqli_error($connect);
                    echo "<script>alert('$erro');</script>";
                endif;

            else:
                $sql = "INSERT INTO tipofaca (nome) VALUES ('$tipo')";
                $resultado = mysqli_query($connect,$sql);

                if($resultado):
                    $cod_tipofaca = $connect->insert_id;
                    $sql = "UPDATE faca SET lanceinicial = $lanceInicial, nome = '$nome', custo = $custo, descricao = '$descricao', img = '$imagem', linkFotos = '$link',  permitir_planceinicial = '$ofertaSemLance', tipofaca = $cod_tipofaca, fornecedor = '$fornecedor', estoquedisponivel = '$estoque' WHERE codigo = $codigo_faca;";
                    $resultado = mysqli_query($connect,$sql);

                    if ($resultado):
                        echo "<script>alert('Edição realizada!');
                          javascript:history.go(-1);
                         window.location.href = '../faca.php?faca=$codigo_faca';</script>";
                        mysqli_close($connect);
                        
                    endif;
                endif;
            endif;
    else:
        echo "<script>alert('Formato não aceito');</script>";
    endif;

