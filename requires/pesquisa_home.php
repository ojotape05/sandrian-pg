<?php
    include("conexao.php");
    $pesquisa = $_GET['pesquisa'];
    if($pesquisa != ""){
        $sql = "SELECT * FROM faca WHERE nome LIKE '%$pesquisa%'";
        $result = mysqli_query($connect,$sql);
        $FacasNaPagina = [];
        if(mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
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
                                                <span style='font-weight: bold;font-size:100%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                                
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
                                                <span style='font-weight: bold;font-size:100%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                                
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
        endif;
    
        $sql = "SELECT codigo FROM tipofaca WHERE nome LIKE '%$pesquisa%'";
        $result = mysqli_query($connect,$sql);
        if(mysqli_num_rows($result) > 0):
            while ($tipos = mysqli_fetch_assoc($result)):
                $tipo = $tipos['codigo'];
                $sql = "SELECT * FROM faca WHERE tipofaca = '$tipo'";
                $result = mysqli_query($connect,$sql);
                while ($row = mysqli_fetch_assoc($result)):
                    $codigo_faca_atual = $row['codigo'];
                    if(!in_array($codigo_faca_atual,$FacasNaPagina)):
                        $nome_faca_atual = $row['nome'];
                        $img_faca_atual = $row['img'];
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
                                    <div class='row container'>
                                        <div class='row'>
                                            <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                                                <div style='height: 470px;' class='card medium lul'>
                                                    <div class='card-image' style='max-height: 50%;'>
                                                        <img style='max-height: 500px;'src='$img_faca_atual'>
                                                    </div>
                                                    <div style='text-align:center;padding: 5px 0px 0px 0px;' class='card-content'>
                                                        <span style='font-weight: bold;font-size:100%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                                        <p style='color:green'>R$$lanceInicial_faca_atual</p>
                                                        <p style='font-size: 85%;'>Oferta sem lance inicial? $permitir_planceinicial_faca_atual </p>
                                                    </div>
                                                    <div class='card-action'>
                                                        <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ";
                            else:
                                echo "
                                    <div class='row container'>
                                        <div class='row'>
                                            <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                                                <div style='height: 470px;' class='card medium lul'>
                                                    <div class='card-image' style='max-height: 50%;'>
                                                        <img style='max-height: 50%;'src='$img_faca_atual'>
                                                    </div>
                                                    <div style='text-align:center;padding: 5% 0px 0px 0px;' class='card-content'>
                                                        <span style='font-weight: bold;font-size:100%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                                        
                                                    </div>
                                                    <div class='card-action'>
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
                            <div class='row container'>
                                <div class='row'>
                                    <div style='width: 50%;margin-left: 25%;' class='col s12 m7'>
                                        <div style='height: 470px;' class='card medium lul'>
                                            <div class='card-image' style='max-height: 50%;'>
                                                <img style='max-height: 50%;'src='$img_faca_atual'>
                                            </div>
                                            <div style='text-align:center;padding: 5% 0px 0px 0px;' class='card-content'>
                                                <span style='font-weight: bold;font-size:100%;color:black;width: 100%;text-align:center;''>$nome_faca_atual</span>
                                    
                                            </div>
                                            <div class='card-action'>
                                                <a class='right' style='color:gray' href='faca.php?faca=$codigo_faca_atual'> Acesse ➤ </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        endif;
                    endif;
                endwhile;
            endwhile;
        else:
            if(count($FacasNaPagina) == 0):
                echo "<div style='display:flex;justify-content:center'> 
                        <p style='color:red'> Nenhum resultado encontrado! </p>
                    </div>";
            endif;
        endif;
    }
    

?>