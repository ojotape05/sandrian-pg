<?php 
$page = $_GET['page'];
$categoria = $_GET['categoria'];
$indexInicial = ($page-1) * 5;
$sql = "SELECT f.permitir_planceinicial, f.codigo, f.img, f.nome,f.lanceInicial,f.estoquedisponivel FROM faca f JOIN tipofaca tp ON (f.tipofaca = tp.codigo)WHERE estoquedisponivel > 0 AND tp.nome LIKE '%$categoria%' ORDER BY estoquedisponivel DESC LIMIT $indexInicial,5";
$resultado = mysqli_query($connect,$sql);
$n = 1;
while ($row = mysqli_fetch_assoc($resultado)):
    $codigo_faca_atual = $row['codigo'];
    $FacasNaPagina[] = $codigo_faca_atual;
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
    
    if(isset($_SESSION['logado'])):
        if($_SESSION['logado']):
            echo "
                <div class='row container posts'>
                <div class='row'>
                    <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                        <div style='height: 470px;' class='card medium lul'>
                            <div class='card-image'>
                                <img class='img-post'style='max-height: 310px;height:60%' src='$img_faca_atual'>
                            </div>
                            <div style='text-align:center;padding: 5px 0px 0px 0px;' class='card-content'>
                                <span style='font-size:110%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                <p style='color:green'>R$$lanceInicial_faca_atual</p>
                                <p style='font-size: 85%;'>Estoque: $qntd_faca_atual</p>
                                <p style='font-size: 85%;'>Oferta sem lance inicial? $permitir_planceinicial_faca_atual </p>
                            </div>
                            <div class='card-action' style='padding: 1px'>
                                <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                ";
        else:
            echo "
                <div class='row container posts'>
                    <div class='row'>
                        <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                            <div style='height: 470px;' class='card medium lul'>
                                <div class='card-image'>
                                    <img class='img-post'style='max-height: 310px;height:60%' src='$img_faca_atual'>
                                </div>
                                <div style='text-align:center;padding: 5% 0px 0px 0px;' class='card-content'>
                                    <span style='font-size:13px;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                    
                                </div>
                                <div class='card-action' style='padding: 1px'>
                                    <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                ";
        endif;
    else:
        echo "
        <div class='row container posts'>
                <div class='row'>
                    <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                        <div style='height: 470px;' class='card medium lul'>
                            <div class='card-image'>
                                <img class='img-post'style='max-height: 310px;height:60%' src='$img_faca_atual'>
                            </div>
                            <div style='text-align:center;padding: 5% 0px 0px 0px;' class='card-content'>
                                <span style='font-size:13px;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                
                            </div>
                            <div class='card-action' style='padding: 1px'>
                                <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        ";
    endif;
endwhile;
?>
                    