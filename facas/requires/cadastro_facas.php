<?php 

    include("../requires/conexao.php");

    $erros = Array();
    $formatosPermitidos = array("png", "jpeg", "jpg","jfif");
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'],PATHINFO_EXTENSION));

    if(in_array($extensao, $formatosPermitidos)):
        $imagembase64 = base64_encode(file_get_contents($_FILES['imagem']['tmp_name'])); //selecionando o diretorio do arqv;

        $imagem = 'data:imagem/'.$extensao.';base64,'.$imagembase64;
        $nome =   pg_escape_string($connect, $_POST['nome']);
        $descricao =   pg_escape_string($connect, $_POST['descricao']);
        $tipo =  pg_escape_string($connect, $_POST['tipo']);
        $link =  pg_escape_string($connect, $_POST['link']);

        $custo = intval($_POST['custo']);
        $lanceInicial = intval($_POST['lance']);
        $estoque = intval($_POST['estoque']);
        $fornecedor =   pg_escape_string($connect, $_POST['fornecedor']);

        $ofertaSemLance = pg_escape_string($connect, $_POST['ofertaSemLance']);

        if(empty($imagem) or empty($fornecedor) or empty($nome) or empty($descricao) or empty($link) or empty($custo) or empty($lanceInicial) or empty($estoque) or empty($ofertaSemLance)):
            
            echo "<script>alert('Preencha todos os campos');</script>";
            
        else:

            if($ofertaSemLance == "sim"):
                $ofertaSemLance = 1;
            else:
                $ofertaSemLance = 0;
            endif;

            $descricao = "*Lance Inicial: R$$lanceInicial*

            " . $descricao ."

            *Lance Inicial: R$$lanceInicial*";

            $sql = "SELECT * FROM tipofaca WHERE nome = '$tipo'";
            $resultado = pg_query($connect,$sql);

            if(pg_num_rows($resultado) > 0): //se houver o tipo especificado
                $consulta = pg_fetch_assoc($resultado);
                $cod_tipofaca = $consulta["codigo"];
                $sql = "INSERT INTO faca (estoquedisponivel,lanceInicial,nome,descricao,img,linkFotos,permitir_planceinicial,tipofaca,fornecedor) VALUES ('$estoque','$lanceInicial','$nome','$descricao','$imagem','$link','$ofertaSemLance','$cod_tipofaca','$fornecedor')";
                $resultado = pg_query($connect,$sql);

                if ($resultado):

                    echo "<script>alert('Cadastro realizado!');</script>";
                    pg_close($connect);
                    
                else:
                    $erro = pg_error($connect);
                    echo "<script>alert('$erro');</script>";
                endif;

            else:
                $sql = "INSERT INTO tipofaca (nome) VALUES ('$tipo')";
                $resultado = pg_query($connect,$sql);

                if($resultado):
                    $cod_tipofaca = $connect->insert_id;
                    $sql = "INSERT INTO faca (estoquedisponivel,lanceInicial,nome,descricao,img,linkFotos,permitir_planceinicial,tipofaca,fornecedor) VALUES ('$estoque','$lanceInicial','$nome','$descricao','$imagem','$link','$ofertaSemLance','$cod_tipofaca','$fornecedor')";
                    $resultado = pg_query($connect,$sql);

                    if ($resultado):
                        echo "<script>alert('Cadastro realizado!');</script>";
                        pg_close($connect);
                    endif;
                endif;
            endif;
        endif;
    else:
        echo "<script>alert('Formato não aceito');</script>";
    endif;





?>