<?php
    
    
    session_start();
    
    if(isset($_SESSION['logado'])):
        if($_SESSION['logado']):
            $nome_usuario = $_SESSION['nome'];
            $admin = $_SESSION['admin'];
        endif;
    endif;
    
    
    if(!isset($_GET["page"])){
        header("Location: index.php?page=1");
    }
    else{
        if($_GET["page"] == ""){
            header("Location: index.php?page=1");
        }
    }

    
?>

<html>
    <head>
        
        <meta charset="utf-8">
        <title> Sadrian </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
        <link rel="icon" type="imagem/jpg" href="requires/faca-icon.jpg" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
       

        <style>
            
            .posts{
                width: 50%;
                max-width: 520px;
                min-width: 310px;
            }
            
            #flutuante{
                z-index:9998;
            }
            
            #divulgacao{
                float: right;
                max-width: 110px;
                width: 100%;
                z-index:9998;
                position:relative;
                text-align: center
            }
            
            .card-action{
                padding: 1;
            }
            
            .card-image{
                max-height: 70% !important; 
            }
            
            @media only screen and (max-width: 465px){
                .card-content{
                    font-size: 3vw !important;
                }
            }
            
            @media only screen and (max-width: 601px){
                #divulgacao{
                    max-width: 50px !important;
                    font-size: 10px !important;
                    
                }
            }
                
            
            @media only screen and (max-width: 800px){

                img {
                    height: 50%;
                }

                #flutuante{
                    margin-left: 100px;
                }
                
                .lul {
                    height: 350px !important
                }
            }
            
            @media only screen and (min-width: 800px) {
                #flutuante{
                    margin-top: 20px;
                    margin-left: 200px !important;
                }
                .card-content {
                    padding: 5% 0px 0px 0px;
                }
            }
              
            
            

        </style>
    </head>

    <body>

        <?php include("requires/header.php")?>
        
        <main style="margin-top: 100px;">

        <?php
        require("requires/conexao.php");
        $result = mysqli_query($connect,"SELECT link FROM divulgacao");
        $fetch = mysqli_fetch_assoc($result);
        $link_divulgacao = $fetch['link'];
        ?>

        <div name='conteudo'>
            <div class="container">
                <div id="divulgacao">
                     <span style="font-size:13px;color:black">Conheça nosso grupo de leilão!</span><br><a href="<?php echo $link_divulgacao; ?>">Clique aqui</a>
                     <br>
                     <?php
                        $servidor = $_SERVER['PHP_SELF'];
                        if(isset($_SESSION['logado'])):
                            if($_SESSION['logado']):
                                if($admin == 1):
                                    echo "
                                    <button onclick='mudaLink()' style='cursor:pointer;border: none;background: none;color: #15a2e7;'><i class='tiny material-icons'>border_color</i></button>
                                    <form id='input_link' style='visibility:hidden' action='$servidor' method='GET'>
                                        <input style='height: 10px;width: 70%;max-width: 60px;font-size: 7px;' name='link' type='text' placeholder='Link' required>
                                        <button class='tiny' style='padding:0;color:grey;border:none;background:none;' type='submit' name='edita_link'> > </button>
                                    </form>";
                                endif;                           
                            endif;
                        endif;
                     ?>
                     
                </div>
            </div>
            <div name='oi' style='margin-right: 10%;width: 80%;height: 80%;position: fixed;display: flex;margin-left: 10%;align-content: center;flex-direction: row;align-items: center;justify-content: space-evenly;'>
                <div class="container" style='max-width: 100%;height: 55%;display: flex;flex-direction: column-reverse;justify-content: center;position: fixed;'>
                    <div>
                        <?php
                        if(isset($_GET['page'])){
                            $page_previous = $_GET['page'] - 1;
                            $page_next = $_GET['page'] + 1;
                            if($page_previous > 0){
                                echo "<a href='index.php?page=$page_next' style='background-color:black;float: right;' class='btn-floating'><span style='margin-left: 7px;margin-top: 7px;' class='material-icons'> arrow_forward </span> </a> 
                                <a href='index.php?page=$page_previous' style='background-color:black;float: left;' class='btn-floating'><span style='margin-left: 7px;margin-top: 7px;' class='material-icons'> arrow_back </span> </a> ";
                            }
                            else{
                                echo "<a href='index.php?page=$page_next' style='background-color:black;float: right;' class='btn-floating'><span style='margin-left: 7px;margin-top: 7px;' class='material-icons'> arrow_forward </span> </a> ";
                            }  
                        }
                        else{
                            echo "<a href='index.php?page=$page_next' style='background-color:black;float: right;' class='btn-floating'><span style='margin-left: 7px;margin-top: 7px;' class='material-icons'> arrow_forward </span></a> ";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php

            if(isset($_GET['edita_link'])):
                $link_divulgacao_mudar = $_GET['link'];
                mysqli_query($connect,"UPDATE divulgacao SET link = '$link_divulgacao_mudar'");
                echo "<script> voltar() </script>";
            endif;

            if(isset($_SESSION['logado'])):
                if($_SESSION['logado']):
                    echo "<div id='flutuante' style='margin-top:-20px;margin-left: 40px;position: fixed;height: 70px;'>
                            <ul>
                                <li style='margin: 10px 0;'><a class='btn-floating right waves-effect waves-light btn-small black' style='margin-right: 10%' href='perfil.php' ><i class='material-icons'>person</i></a></li>";
                    if($admin == 1):
                        echo "
                        <li style=' margin: 10px 0;'><a href='processamentos.php' class='btn-floating right waves-effect waves-light btn-small black' style='margin-right: 10%' ><i class='material-icons'>art_track</i></a></li>
                        <li style=' margin: 10px 0;'><a href='listar_categorias.php' class='btn-floating right waves-effect waves-light btn-small black' style='margin-right: 10%' ><i class='material-icons'>bookmark</i></a></li>
                        ";
                    endif;
                    echo "</ul>
                    </div>";
                endif;
            endif;


            ?>
            

            <form action="<?php echo $_SERVER['PHP_SELF']?>" method='GET' style='position:relative;z-index:9997'>
                <div id='divpesquisa' style="width: 35%;border-radius: 15px;" class='nav-wrapper container z-depth-1'>
                    <input style="display:none;" name='page' type='text' value="1">
    				<div class='input-field'>
    				  <input style="font-size: 80%;padding: 12px 0px 10px 25px !important;border-radius: 15px" name='pesquisa' type='search' placeholder="Pesquisar" required>
    				</div>
    			 </div>
    			 
				 <div style="width: 35%;border-radius: 15px;" class='nav-wrapper container'>
				     <button style='display:none' type='submit'> buscar </button>
				 </div>
				 
            </form>


            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET" style='margin-top: 10px;position:relative;z-index:9997;'>
                <div style="display:flex;justify-content:center;margin-left: 23%;margin-right: 23%;">
                    <a class="dropdown-trigger btn black" href="#" data-target="dropdown1">Categorias</a>
                    <ul id="dropdown1" class="dropdown-content">
                    <?php
                    $sql = "SELECT * FROM tipofaca WHERE nome != ' ' or nome != ''";
                    $resultado = mysqli_query($connect,$sql);
                    while ($row = mysqli_fetch_assoc($resultado)):

                        $nome_categoria = $row['nome'];
                        $codigo_categoria  = $row['codigo'];
                        echo "<li> <a style='color:black'href='index.php?page=1&categoria=$nome_categoria'> $nome_categoria </a></li>";
                    endwhile;
                    echo "
                    </ul>
                </div>
            </form>";
                    ?>
            <?php
                if(isset($_GET['page'])){
                    if(isset($_GET['categoria'])){
                        include("requires/categorias.php");
                    }
                    else if(isset($_GET['pesquisa'])){
                        include("requires/pesquisa_home.php");
                    }
                    else if(isset($_SESSION['logado'])){
                        if($_SESSION['logado']){
                            require('requires/index_logado.php');
                        }
                        else {
                            include('requires/index_deslogado.php');  
                        }
                    }
                    else{
                        include('requires/index_deslogado.php');
                    }
                }
            ?>
        </div>
        </main>
        


    </body>

</html>

<script>
    
    ////////////////////////////

    function mudaLink(){
        document.getElementById("input_link").style.visibility = "visible"
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        var options = {
            
        };
        var instances = M.Dropdown.init(elems, options);
      });
</script>