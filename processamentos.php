<?php
    
    session_start();
    
    if(isset($_SESSION['logado'])):
        if($_SESSION['logado']):
            $nome_usuario = $_SESSION['nome'];
            $admin = $_SESSION['admin'];
        else:
            header("Location: login.php");
        endif;
    else:
        header("Location: login.php");
    endif;

    
?>
<html>
    <head>
        <title> Sadrian </title>
        <link rel="icon" type="imagem/jpg" href="requires/faca-icon.jpg" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" async >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" defer>
        
        <style>
             #popup2{
                margin-top:100px;left:2%;height:400px;width:95%;background-color: rgb(255, 255, 255);
            }
        </style>
    </head>
    
    <body>
        <?php include("requires/header.php")?>
        <main>
            
            <div id='popup2'>
                            
                <div class='container'>
                    <a style='padding:0 5px;color:black;cursor:pointer'
                    onclick='voltar()'>
                        <i style='font-size:20px'class= 'material-icons'> keyboard_return </i>
                    </a>
                </div>            
                            
                <div id='content'>
                    <div style='font-size: 105%;' class='center'> Facas em leilão </div>
                    <div style='width: 100%;max-height: 100%;overflow-x:hidden'>
                    
                    <form action='requires/darbaixa_todas.php' method='POST'>
                        <?php
                        require("requires/conexao.php");
                        $result = mysqli_query($connect,"SELECT o.codigo,o.data_inicioBaixa,usu.nome,f.img FROM operacao o JOIN usuario usu JOIN faca f ON(usu.codigo = codigoUsuario AND f.codigo = codigoFaca) WHERE concluida = 0");
                        if(mysqli_num_rows($result) > 0):
                            $n = 0;
                            while ($row = mysqli_fetch_assoc($result)):
                                $codigo = $row['codigo'];
                                $data = $row['data_inicioBaixa'];
                                $nome_usu_process = $row['nome'];
                                $img_faca_process = $row['img'];
                                
                                $image = imagecreatefromjpeg($img_faca_process);
                                imagejpeg($image, "uploads/compress_foto_faca_$codigo.jpg", 10);
                                
                            echo "
                            <div style='width:100%'>
                                <div style='display:flex;justify-content: center;align-items: center;border:solid;border-width:1px;width:80%;margin-left:10%;height: 40%;'>
                                    <div name='conteudo'>
                                        <div class='left'style='border:solid;border-width:1px;height: 60px;width: 60px;margin: 1.7% 2% 0% 2%;'> <img style='width: 100%;height: 100%;' src='uploads/compress_foto_faca_$codigo.jpg'> </div>
                                        
                                        <div>
                                            <p style='font-size: 60%;margin: 5px 0px 0px 17%;'> Processamento #$codigo ($nome_usu_process [$data]) </p>
                                            <input name='codigo_usuario' value='$codigo_usuario' style='display:none'>
                                            <input name='codigo$n' value='$codigo' style='display:none'>
                                            <input name='comprador$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px' placeholder='Nome do comprador'>
                                            <input name='valor_venda$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px' placeholder='Valor da venda'>
                                            <select name='metodopag$codigo' style='font-size: 50%;width: 13%;height: 25%; margin: 5px; display: inline-block'>
                                                <option value='' disabled selected>Método de Pagamento</option>
                                                <option value='Em aberto' selected> Em aberto </option>
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
                                </div>
                            </div>";
                            $n= $n + 1;
                            endwhile;
                        endif;
                        ?>
                        <div style='display:flex;justify-content:center;' > 
                            <button type='submit' class='btn' style='border-radius: 5%;color: white;background-color:black'> Confirmar </button>
                        </div>
                    </form>
                    
                    </div>
                        
                </div>
                    
            </div>
        </main>
    </body>
</html>