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
        <div id="transp" style="visibility:hidden;margin-top: -100px;opacity : 0.5;position: fixed;z-index:9998;height:100%;width:100%;background-color: rgb(0, 0, 0);"> </div>
        <main>
            
            <div id='popup2'>
                            
                <div class='container'>
                    <a style='padding:0 5px;color:black;cursor:pointer'
                    onclick='voltar()'>
                        <i style='font-size:20px'class= 'material-icons'> keyboard_return </i>
                    </a>
                </div>            
                            
                <div id='content'>
                    <div style='font-size: 105%;' class='center'> Categorias de Facas </div>
                    <div style='width: 100%;max-height: 100%;overflow-x:hidden'>
                    
                    
                        <?php
                        require("requires/conexao.php");
                        $result = mysqli_query($connect,"SELECT * FROM tipofaca;");
                        if(mysqli_num_rows($result) > 0):
                            
                            while ($row = mysqli_fetch_assoc($result)):
                                $codigo = $row['codigo'];
                                $nome = $row['nome'];
                               
                                if($codigo != 1){
                            echo "
                               <script>
         function popupexcluir$codigo(){
             document.getElementById('transp').style.visibility = 'visible'
            document.getElementById('popupexcluir$codigo').style.display = 'block'
        }
      
        function fechar$codigo(){
            document.getElementById('transp').style.visibility = 'hidden'
            document.getElementById('popupexcluir$codigo').style.display = 'none'
        }
    </script>

                            <div style='width:100%'>
                           
                                <div style='border:solid;border-width:1px;width:80%;margin-left:10%;height: 40%;'> 
                                    <div class='left'style='border:solid;border-width:1px;height: 60px;width: 60px;margin: 1.7% 2% 0% 2%;'> <img style='width: 100%;height: 100%;' src='uploads/sadrian.jpg'> </div>
                                    

                                            <p style='font-size: 60%;margin: 5px 0px 0px 17%;'> Categoria de código #$codigo        Nome: <b> $nome </b> </p>
                                           <form action='requires/editar_categoria.php' method='POST'>
                                            <input name='nome' style='font-size: 60%;width: 26%;height: 25%; margin: 5px' placeholder='Novo Nome'>
                                            <input name='codigo' style='display:none;' value='$codigo'>
                                            <button  style='color:black; padding: 5px;background-color: Chartreuse; border-radius:10%;border-color: white; display: inline-block;font-size: 60%;'> Confirmar edição </button>
                                                                </form>
                                             
                                             <button onclick = 'popupexcluir$codigo()' style='color:black; background-color: red; border-radius:10%; border-color: white; padding: 5px; display: inline-block;font-size: 60%;'> Excluir </button>
                                             
                                           
                                            
                                        </div>
                                                                                <div>
                                          <div id='popupexcluir$codigo' style='margin-left: 40px;display: none;z-index:9999;position: relative;background-color: rgb(255, 255, 255); bottom:120px; text-align: center;'>
                    
                            <p>Clique em confirmar para apagar a faca.</p>
                            
                       <div style='display:flex;justify-content:center;' >
                       <form action='requires/apagar_categoria.php' method='POST' >
                            <input name='codigo' value='$codigo' style='display:none'>
                            <button type = 'submit' name = 'excluir' class='btn red' style='border-radius: 5%;color: white;background-color:black;margin:10px;'> Confirmar </button>
                            </form>
                            <button onclick='fechar$codigo()'class='btn' style='border-radius: 5%;color: white;background-color:black;margin:10px;'> Cancelar </button>
                            
                            </div>
                                    </div>
                                </div>";}
                           
                            endwhile;
                        endif;
                        ?>
                        <div style='display:flex;justify-content:center;' > 
                            <button type='submit' class='btn' style='border-radius: 5%;color: white;background-color:black'> Confirmar </button>
                        </div>

                    </div>
                        
                </div>
                    
            </div>
        </main>
    </body>
</html>