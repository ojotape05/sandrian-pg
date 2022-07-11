<?php
    require("conexao.php");
    $indexInicial = ($_GET['page']-1) * 5;
    $sql = "SELECT * FROM faca WHERE estoquedisponivel > 0 ORDER BY estoquedisponivel DESC LIMIT $indexInicial,5";
    $result = mysqli_query($connect,$sql);
    while ($row = mysqli_fetch_assoc($result)){
        $codigo_faca_atual = $row['codigo'];
        $qntd_faca_atual = $row['estoquedisponivel'];
        $nome_faca_atual = $row['nome'];
        $image = imagecreatefromjpeg($row['img']);
        imagejpeg($image, "uploads/compress_foto_faca_$codigo_faca_atual.jpg", 10);
        $img_faca_atual = "uploads/compress_foto_faca_$codigo_faca_atual.jpg";
        $lanceInicial_faca_atual = $row['lanceInicial'];
        $permitir_planceinicial_faca_atual = $row['permitir_planceinicial'];
        if($permitir_planceinicial_faca_atual == 1):
            $permitir_planceinicial_faca_atual = 'SIM';
        else:
            $permitir_planceinicial_faca_atual = "NÃO";
        endif;

        echo "<div class='row container posts'>
                <div class='row'>
                    <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                        <div style='height: 470px;' class='card medium lul'>
                            <div class='card-image'>
                                <img class='img-post'style='max-height: 310px;height:60%' src='$img_faca_atual'>
                            </div>
                            <div style='text-align:center;padding: 5px 0px 0px 0px;' class='card-content'>
                                <span style='font-weight: bold;font-size:100%;;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                <p>Lance Inicial: <span style='color:green'> R$$lanceInicial_faca_atual</span></p>
                                <p style='font-size: 85%;'>Estoque: $qntd_faca_atual</p>
                                <p style='font-size: 85%;'>Oferta sem lance inicial? $permitir_planceinicial_faca_atual </p>
                            </div>
                            <div class='card-action' style='padding: 1px'>
                                <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
?>