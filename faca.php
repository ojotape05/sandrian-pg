<?php
    require("requires/conexao.php");
    
    session_start();

    if(isset($_SESSION['logado'])):
        if($_SESSION['logado']):
            $codigo_usuario = $_SESSION['id_usuario'];
            $nome_usuario = $_SESSION['nome'];
            $admin = $_SESSION['admin'];
        endif;
    endif;

    if(!empty($_GET['faca'])){
        $codigo_faca = $_GET['faca'];
        $sql = "SELECT f.codigo, f.estoquedisponivel, f.lanceInicial, f.nome, f.img, f.fornecedor, f.descricao, f.custo, f.linkFotos, f.permitir_planceinicial, tp.nome as 'nometipo'  FROM faca f join tipofaca tp on (tp.codigo = f.tipofaca) WHERE f.codigo = $codigo_faca;";

        $resultado = mysqli_query($connect,$sql);
        if($resultado){
            $dados_faca = mysqli_fetch_assoc($resultado);
        }
        else{
            mysqli_error($connect);
        }
    }
    else{
        header('Location: index.php');
    }

?>

<html>

    <head>
        <title> Sadrian </title>
        <link rel="icon" type="imagem/jpg" href="requires/faca-icon.jpg" />
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
        <style>
            #box-img {
                height: 200px;
                width: 200px;
            }
            
        </style>
    
    </head>

    <body>

        <div id="transp" style="visibility:hidden;margin-top: -100px;opacity : 0.5;position: fixed;z-index:9998;height:100%;width:100%;background-color: rgb(0, 0, 0);"> </div>

        <?php include("requires/header.php")?>
        
        <main style="margin-top: 40px;margin-top: 100px;">
            <?php
                if(isset($_SESSION['logado'])){
                    if($_SESSION['logado']){
                        echo "<div class='container'>
                            <a style='padding:0 5px;color:black;cursor:pointer'
                            onclick='voltar()'>
                                <i style='font-size:20px'class= 'material-icons'> keyboard_return </i>
                            </a>
                        </div>";
                    }
                }
            ?>

            <!-- POPUP -->
            <?php
            $imagedata = $dados_faca['img'];
            $image = imagecreatefromjpeg($dados_faca['img']);
            imagejpeg($image, "uploads/compress_foto_faca_$codigo_faca.jpg", 20);
            $img = "uploads/compress_foto_faca_$codigo_faca.jpg";
            $nome_faca = $dados_faca['nome'];
            $lanceInicial_faca = $dados_faca['lanceInicial'];
            $custo = $dados_faca['custo'];
            $categoria = $dados_faca['nometipo'];
            $fornecedor = $dados_faca['fornecedor'];
            $estoquedisponivel_faca = $dados_faca['estoquedisponivel'];
            $descricao_faca = $dados_faca['descricao'];
           $desce = str_replace("*Lance Inicial: R$$lanceInicial_faca*","",$descricao_faca);

           $desce = str_replace("            ","",$desce);
          
            $linkFotos_faca = $dados_faca['linkFotos'];
            $permitir_planceinicial_faca = $dados_faca['permitir_planceinicial'];
            
            
                if(isset($_SESSION['logado'])):
                    if($_SESSION['logado']):
                       echo "<div id='popup1' style='visibility:hidden;margin-top: -60px;left:2%;position: fixed;z-index:9999;height:400px;width:95%;background-color: rgb(255, 255, 255);'>
                       <button style='cursor:pointer;border:none;margin: 4px;color: black;padding-top: 0;' onclick='fechar1()'class='right btn-tiny white'> <i class= 'material-icons' > close </i> </button>
                       <div style='display:flex;justify-content:center'>
                           <form action='requires/separar_estoque.php' method='GET' id='form1'style=';width:100%;display: flex;max-width: 409px;flex-direction: row;justify-content: center;height: 100%'>
                               <div id='content' style='margin-top: 20px;width:100%; max-width:400px;text-align:center'>
       
                                   <div style=' border:solid;border-width: 1px;height: 120px;width: 100px;' class='left'> <img style='width: 100%;height: 100%;' src='$img'> </div>
               
                                   <div style='padding-left: 35%; padding-top: 5%;'>
                                       <span style='font-size: 90%'>Em estoque: $estoquedisponivel_faca</span><br>
                                       <input name='quantidade_separar' type='number' min='0' max='$estoquedisponivel_faca' style='height: 7%;font-size: 10px;width: 57%;text-align: center;' placeholder='Quantidade para leiloar' required><br>
                                       <input name='codigo_faca' value='$codigo_faca' style='display:none'>
                                       <input name='codigo_usuario' value='$codigo_usuario' style='display:none'>
                                       <input name='permitir_planceinicial' value='$permitir_planceinicial_faca' style='display:none'>
                                       ";
                                           if($permitir_planceinicial_faca == 1){
                                               echo "<span style='font-size: 80%'>Ofertar sem lance inicial: R$$lanceInicial_faca</span><br>
                                               <input id='radio1' style='height:11px;position: relative;opacity: 1;pointer-events: all;'type='radio' name='resposta' value='sim'> Sim 
                                               <input id='radio2' style='height:11px;position: relative;opacity: 1;pointer-events: all;'type='radio' name='resposta' value='nao'> Não";
                                           }
                                            endif;
                                       
                                    echo"   
                                   </div>
                                   <br>
                                   <div>
                                       <textarea id='desc' style='resize: none;font-size:10px; max-width: 400px;height: 190px; word-wrap: break-word; overflow-x:auto;'>";
                                           echo str_replace("            ","",$descricao_faca);
                                       echo "</textarea>
                                       <br>
                                       <div style='padding-top: 10px'>
                                           <button onclick='copiarDesc()' type='submit' class='right btn' style='border-radius: 5%;color: white;background-color:black'> Confirmar </button>    
                                       </div>
                                       
                                   </div>
               
                               </div>
                           </form> 
                       </div>   
                   </div>
       
                   <!-- POPUP 2 -->
       
                   <div id='popup2' style='visibility:hidden;margin-top: -60px;left:2%;position: fixed;z-index:9999;height:400px;width:95%;background-color: rgb(255, 255, 255);'>
                       <button style='cursor:pointer;border:none;margin: 20px;color: black;padding-top: 0;' onclick='fechar2()'class='right btn-tiny white'> <i class= 'material-icons' > close </i> </button>
                       <div id='content' style='margin-top: 20px;'>
                           <div style='font-size: 105%;margin-left:70px' class='center'> Facas em leilão </div>
       
                           <div style='width: 100%;max-height: 65%;overflow-x:hidden'>
                           <form action='requires/darbaixa.php' method='POST'>";
                           $result = mysqli_query($connect,"SELECT * FROM `operacao` WHERE codigoUsuario = '$codigo_usuario' AND `concluida` = 0");
                           if(mysqli_num_rows($result) > 0):
                            $resultado  = mysqli_query($connect,"CALL getFacasEmProcessamentoUsuario('$codigo_faca','$codigo_usuario')");
                            while ($row = mysqli_fetch_assoc($resultado)):
                                $codigo = $row['codigo'];
                                $data = $row['data_inicioBaixa'];
                                echo "
                                <div style='width:100%'>
                                    <div style='border:solid;border-width:1px;width:80%;margin-left:10%;height: 25%;'> 
                                        <div class='left'style='border:solid;border-width:1px;height: 60px;width: 60px;margin: 1.7% 2% 0% 2%;'> <img style='width: 100%;height: 100%;' src='$img'> </div>
                                            
                                            <div>
                                                <p style='font-size: 80%;margin: 5px 0px 0px 17%;'> Processamento #$codigo ($data) </p>
                                                <input name='codigo_usuario' value='$codigo_usuario' style='display:none'>
                                                <input name='codigo_faca' value='$codigo_faca' style='display:none'>
                                                <input name='codigo$codigo' value='$codigo' style='display:none'>
                                                <input name='comprador$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px' placeholder='Nome do comprador'>
                                                <input name='valor_venda$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px' placeholder='Valor da venda'>
                                                    <select name='metodopag$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px; display: inline-block'>
                                                        <option value='' disabled selected>Método de Pagamento</option>
                                                        <option value='Em aberto'> Em aberto </option>
                                                        <option value='Cartão de Crédito'>Cartão de Crédito</option>
                                                        <option value='Cartão de Débito'>Cartão de Débito</option>
                                                        <option value='Pix'>Pix</option>
                                                        <option value='Dinheiro'>Dinheiro</option>
                                                    
                                        
                                                    </select>
                                
                                                <input name='obs$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px' placeholder='Obs (opcional)'>

                                                <ul style='margin: 0% 5% 0px 0px;' class='right'>
                                                    <li> <input style='position: relative;opacity: 1;pointer-events: all;' type='radio' name='baixa$codigo' value='confirma'>  <i class= 'tiny material-icons'> check </i> </li>
                                                    <li> <input style='position: relative;opacity: 1;pointer-events: all;' type='radio' name='baixa$codigo' value='cancela'>  <i class= 'tiny material-icons'> close </i> </li>
                                                </ul>
                                            </div>
                                        
                                    </div>
                                </div> ";
                            endwhile;
                           endif;
                           echo "
                           <div style='display:flex;justify-content:center;' > 
                            <button type='submit' class='btn' style='border-radius: 5%;color: white;background-color:black'> Confirmar </button>
                            </div>
                        </div>
                            
                        </div>
                       
                       </form>
                    </div>
                    
                    <div id='popupexcluir' style='visibility:hidden;z-index:9999;position: absolute;
top: 30%;
right: 30%;
left: 30%;
bottom: 40%; background-color: rgb(255, 255, 255);'>
                    
                            <p>Clique em confirmar para apagar a faca.</p>
                            
                       <div style='display:flex;justify-content:center;' >
                       <form action='requires/excluir_faca.php' method='POST' >
                            <input name='codigo_faca' value='$codigo_faca' style='display:none'>
                            <button type = 'submit' name = 'excluir' class='btn red' style='border-radius: 5%;color: white;background-color:black;margin:10px;'> Confirmar </button>
                            </form>
                            <button onclick='fechar3()'class='btn' style='border-radius: 5%;color: white;background-color:black;margin:10px;'> Cancelar </button>
                            
                            </div>
                            
                    </div>
                <div class='container' style='display: flex;justify-content: center;'> 
                     <div id = 'popupeditar' style='visibility:hidden;z-index:9999;position: absolute;>

                        <div class='row container' style = 'background-color: rgb(255, 255, 255);z-index:10000'>
                             <form name='formulario' action='requires/editar_faca.php' method='POST' enctype='multipart/form-data' style = 'background-color: rgb(255, 255, 255);'>
                            <div id='altura' class='row' style='height: 100%;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);'>
                                
                                <div class='col s12' style='margin-top: 25px;display: flex;flex-wrap: wrap;justify-content: center;'>
                                    <br>
                                    <div id='box-img' class='left'>
                                        <img id='fotopreview' style='z-index:0;height:100%;width:100%' height='200px' width='200px' src='$img'>
                                        <label for='uploadfoto'>
                                            <i style='z-index: 9999; margin: -75% 0 0 23%;;padding: 45px;' class= 'material-icons'> collections </i>
                                        </label>
                                        <input id='uploadfoto' style='visibility:hidden' type='file' name='imagem'>
                                      
        
                                    </div>
                                
                                  
                                    <div id='infos-foto' class='right'> 
                                        <div id='infos-foto-ajuste'class='right'>
                                        <input name='nome' value = '$nome_faca' style='font-size: 70%;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding-left: 5%;width: 70%;margin-left: 12%;margin-right: 12%;' placeholder='Nome da Faca'>
                                        <textarea name='descricao'   style='border:none;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);resize: none; font-size:10px; padding-left: 1%; max-width: 98%; height: 120px; word-wrap: break-word; overflow-x:auto;'>$desce</textarea>
                                        <input name='tipo' value = '$categoria' style='font-size: 70%;margin-top: 8px;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding: 1% 0% 1% 6%;;width: 92%;height: 12%;' placeholder='Categoria'>
                                        <input name='codigo_faca' value='$codigo_faca' style='display:none'>
                                        <input name='link' value = '$linkFotos_faca' style='font-size: 70%;margin-top: 8px;box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding: 1% 0% 1% 6%;;width: 92%;height: 12%;' placeholder='Link Google Fotos'>
                                         <input id='oldfoto' style='visibility:hidden; display:none;' name='oldimagem' value ='$imagedata'>
                                         </div>
                                    </div>
                                </div>
                                <div style='border-radius: 2%;height: 30%;margin-top:10%;' class='col s12'>
                                    <div id='valores' style='width: 40%; margin:auto;'>
                                        <div style='border-radius: 10px;box-shadow: 2px 3px 3px 0px rgb(203 203 203); width: 100%;font-size: 17px;text-align: center;' > 
                                            <span style='font-size:75%'> Valores: </span><br>
                                            <input name='custo' min='0' value='$custo' style='font-size:62%;margin-top: 5px; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding-left: 5%;width: 72%;height: 30px;' placeholder='Custo'>
                                            <input name='lance' min='0' value='$lanceInicial_faca' style='font-size: 62%;margin-top: 5px; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding-left: 5%;width: 72%;height: 30px;'  placeholder='Lance inicial'><br>
                                            <input name='estoque' min='0' value='$estoquedisponivel_faca' style='font-size: 62%;margin-top: 5px; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding-left: 5%;width: 72%;height: 30px;'  placeholder='Estoque'><br>
                                            <input name='fornecedor' value = '$fornecedor' style='font-size: 62%;margin-top: 5px; box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%);padding-left: 5%;width: 72%;height: 30px;'  placeholder='Fornecedor'><br>
                                        </div>
                                        <div style='border-radius: 10px;margin-top:16px;box-shadow: 2px 3px 3px 0px rgb(203 203 203); width: 100%;font-size: 17px;text-align: center;'>
                                            <span style='font-size:75%'> Pode ser ofertada sem lance inicial? </span> <br>";
                                            if($permitir_planceinicial_faca == 1){ echo "
                                            <div>
                                                <input name='ofertaSemLance' type='radio' style='height:11px;position: relative;opacity: 1;pointer-events: all;' value='sim' checked> Sim 
                                                <input name='ofertaSemLance' type='radio' style='height:11px;position: relative;opacity: 1;pointer-events: all;'  value='nao'> Não
                                            </div>";} else{
                                                echo"<div>
                                                <input name='ofertaSemLance' type='radio' style='height:11px;position: relative;opacity: 1;pointer-events: all;' value='sim'> Sim 
                                                <input name='ofertaSemLance' type='radio' style='height:11px;position: relative;opacity: 1;pointer-events: all;'  value='nao' checked> Não
                                            </div>";
                                            }
                                            echo"
                                            
                                        </div>
                                    </div>
                                   
                                    <br>
                                    <br>
                                    <div>
                                        <button id='finalizar' name='editar' style='margin: 2px 0 0 23%;background-color: grey;color:black; margin-bottom: 15% ;' class='right btn white' type='submit'> Finalizar Edição ➢ </button>
                                          
                                        
                                    </div>
                                </div>
                            </div>
                              </form>
                              <button onclick='fechar4()' name='editar' style='margin: 2px 0 0 23%;background-color: grey;color:black; margin-top: -15%;' class='right btn red'>  Cancelar </button>
                    </div>
                </div>

          
            
       
    </div>
                    ";
                endif;
            ?>
            

            <!-- FIM DO POPUP -->

            <div class="row container">
                <div class="row">
                    
                    <div class="col s12" style="display: flex;flex-direction: row;flex-wrap: nowrap;justify-content: center;">
                        <br>
                        <div style="box-shadow: 7px 7px 17px 0px rgb(240 240 240);height: 210px; width: 210px;" class="left"> <img style="width: 100%;height: 100%;" src="<?php echo $img?>">  </div>
                        <div style="margin-top: -2%;border-radius: 2%;height: 220px; width: 58%;" class="right"> 
                            <h5 style="font:revert;font-size:120%;padding-left: 6%;"> <?php echo $nome_faca;?> </h5>
                            <p style="font-size:10px;margin-left: 6%;padding-left: 1%; max-width: 98%; height: 58%; word-wrap: break-word; overflow-x:auto;">
                                <?php
                                    if(isset($_SESSION['logado'])):
                                        if($_SESSION['logado']):
                                            
                                            $desc = str_replace("\r\n","<br>",$descricao_faca);
                                            echo $desc;
                                        else:
                                            $desc = str_replace("*Lance Inicial: R$$lanceInicial_faca*","",$descricao_faca);
                                            $desc = str_replace("\r\n","<br>",$desc);
                                            echo $desc;
                                        endif;
                                        
                                    else:
                                        $desc = str_replace("*Lance Inicial: R$$lanceInicial_faca*","",$descricao_faca);
                                        $desc = str_replace("\r\n","<br>",$desc);
                                        echo $desc;
                                    endif;
                                    
                                ?>
                            </p>
                            <?php
                            if(isset($_SESSION['logado'])):
                                if($_SESSION['logado']):
                                    echo "<h6 style='font:revert;font-size:110%;padding-left: 6%;'> Lance inicial: R$$lanceInicial_faca</h6>";
                                endif;
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php 
                    if(isset($_SESSION['logado'])):
                        if($_SESSION['logado']):
                            echo "
                            <div style='border-radius: 2%;height: 100px;margin-top:12px;' class='col s12'>
                                <div style='width: 40%;font-size: 17px;text-align: center;' class='left'>";
                                
                                if($admin == 1):
                                    echo "
                                
                                    <form action='requires/adicionar_estoque.php' method='GET'>
                                        <span style='font-size:70%;padding-right: 6px ;'>Em estoque: $estoquedisponivel_faca </span><br>
                                        <input style='text-align:center;font-size: 14px; height:20px;width: 30%;' name='add_estoque' placeholder='valor'>
                                        <input style='display:none' name='codigo_faca' value='$codigo_faca'>
                                        <input style='display:none' name='estoque_atual' value='$estoquedisponivel_faca'>
                                        <button style='width:36px;height:36px;padding:0' class='btn-floating grey' type='submit' name='adicionarestoque'> <i style='font-size: 15px' class= 'small material-icons'> add </i> </button>
                                        </form>
                                            <button onclick='popupexcluir()' class='btn red' style='color:black;margin-top: 10px; display: inline-block;'> Excluir </button>
                                             <button onclick='popupeditar()' class='btn yellow' style='color:black;margin-top: 10px; display: inline-block;'> Editar </button>
                                      
                                        ";
                                        
                                endif;
                                    echo "<button onclick='popup2()' class='btn white' style='color:black;margin-top: 12px;'> Dar baixa </button>
                                </div>
                                
                                <br>
                                <br>
                                
                                <div class='right'> 
                                    <div onclick='popup1()' style='background-color: grey;color:black;' class='btn white'>
                                        COPIAR DESCRICAO ➢
                                    </div>";
                                    mysqli_next_result($connect);
                                    $resultado = mysqli_query($connect,"SELECT * FROM operacao WHERE codigoUsuario = $codigo_usuario AND codigoFaca = $codigo_faca AND concluida = 0");
                                    if(mysqli_num_rows($resultado) > 0){
                                        echo"
                                        <div style='margin-top:15px'>
    
                                            <a style='font-size:70%;color:black' class='btn white' onclick='acessar()' href='#'> LEILOAR </a>
    
                                        </div>";
                                    }
                                    
                                echo "</div>";
                        else:
                            echo "<a class='right' href='https://api.whatsapp.com/send?l=pt&amp;phone=555596837807&text=Olá!%20Gostaria%20de%20saber%20qual%20valor%20da%20faca%20$nome_faca'><img 
                            src='https://i.imgur.com/ryESuZ5.png' style='height:40px;'></a>
                            
                            <br>
                            <br>
                            
                            <div class='container'> 
                                <div style='margin-top:15px'>

                                <a style='font-size:70%;color:black' class='btn white' onclick='acessar()' href='#'> VER FOTOS </a>

                                </div>
                            </div>";
                        endif;
                    else:
                        echo "<a class='right' href='https://api.whatsapp.com/send?l=pt&amp;phone=555596837807&text=Olá!%20Gostaria%20de%20saber%20qual%20valor%20da%20faca%20$nome_faca'><img 
                        src='https://i.imgur.com/ryESuZ5.png' style='height:40px;'></a>
                        
                        <br>
                        <br>
                        
                        <div class='container'> 
                            <div style='margin-top:15px'>

                            <a style='font-size:70%;color:black' class='btn white' onclick='acessar()' href='#'> VER FOTOS </a>

                            </div>
                        </div>";
                    endif;
                        
                        ?>
                        
                    </div>
                </div>
            </div>

        </main>

    </body>

    <script>

        document.querySelector("#radio2").checked = true;
        let radioBtns = document.querySelectorAll("input[name='resposta']");
        
        let findSelected = () => {
            let selected = document.querySelector("input[name='resposta']:checked");
            if(document.querySelector("#radio1").checked){
                var desc = document.getElementById('desc')
                var conteudo = desc.textContent;
                var alterado = conteudo.replaceAll("R$<?php echo $lanceInicial_faca; ?>","R$0")
                desc.textContent = alterado;
            } else if(document.querySelector("#radio2").checked) {
                var desc = document.getElementById('desc')
                var conteudo = desc.textContent;
                var alterado = conteudo.replaceAll("R$0","R$<?php echo $lanceInicial_faca; ?>")
                desc.textContent = alterado;
            }
        }
        
        radioBtns.forEach(radioBtn => {
           radioBtn.addEventListener("change",findSelected)
        })

        findSelected();
        
       
        /// Popup do leilão /// 
         function popupexcluir(){
             document.getElementById("transp").style.visibility = "visible"
            document.getElementById("popupexcluir").style.visibility = "visible"
        }
        function popupeditar(){
             document.getElementById("transp").style.visibility = "visible"
            document.getElementById("popupeditar").style.visibility = "visible"
        }
        function popup1(){
            document.getElementById("transp").style.visibility = "visible"
            document.getElementById("popup1").style.visibility = "visible"
        }

        function fechar1(){
            document.getElementById("transp").style.visibility = "hidden"
            document.getElementById("popup1").style.visibility = "hidden"
        }

        /// Popup de dar baixa /// 
        function popup2(){
            document.getElementById("transp").style.visibility = "visible"
            document.getElementById("popup2").style.visibility = "visible"
        }

        function fechar2(){
            document.getElementById("transp").style.visibility = "hidden"
            document.getElementById("popup2").style.visibility = "hidden"
        }
        function fechar3(){
            document.getElementById("transp").style.visibility = "hidden"
            document.getElementById("popupexcluir").style.visibility = "hidden"
        }
         function fechar4(){
            document.getElementById("transp").style.visibility = "hidden"
            document.getElementById("popupeditar").style.visibility = "hidden"
        }
        
        function voltar(){
            javascript:history.go(-1);
        }
            
        function copiarDesc() {

            let desc = document.getElementById("desc")
            desc.select();
            desc.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Texto copiado.");

        }
        
        function acessar(){
            window.location = '<?php echo $linkFotos_faca;?>';
        }
      
    var uploadfoto = document.getElementById('uploadfoto');
    var fotopreview = document.getElementById('fotopreview');

    uploadfoto.addEventListener('change', function(e) { //adiciona o evento "change" no input
        showThumbnail(this.files); //chama a função showThumbnail utilizando os arquivos carregados pelo input
    });

    function showThumbnail(files) { 
        if (files && files[0]) { // se existir algum arquivo
        var reader = new FileReader(); // adiciona a função de leitor à reader

        reader.onload = function (e) { // uma vez que o upload foi carregado
            fotopreview.src = e.target.result; // troca o src da foto preview para a url do arquiv
        }
        
        reader.readAsDataURL(files[0]); // lê o caminho do arquivo que foi carregado
        
        }
    }

        
    console.log("<?php echo $teste?>");    
    </script>

</html>