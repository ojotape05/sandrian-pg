<?php
    
    session_start();
    
    if(!isset($_SESSION['logado'])):
        header('Location: index.php');
    endif;

    $id_usuario = $_SESSION['id_usuario'];
    $nome_usuario = $_SESSION['nome'];
    $admin = $_SESSION['admin'];

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
        a {
            text-decoration: none;
        }
        a:hover{
            color: white;
        }
    </style>
    </head>
	
<?php
    require("requires/conexao.php");
    $sql = "SELECT * FROM usuario WHERE codigo = '$id_usuario'";
    $resultado = mysqli_query($connect,$sql);
    $dados = mysqli_fetch_assoc($resultado);
    include("requires/header.php")?>
	<main style="height: 700px;max-width: 1300px;margin-top: 30px;display: flex;flex-direction: column;align-items: center;">
	    
	    <div class='container' style='margin-top: 50px;'>
            <a style='padding:0 5px;color:black;cursor:pointer'
            onclick='voltar()'>
                <i style='font-size:20px'class= 'material-icons'> keyboard_return </i>
            </a>
        </div>
	    
		<div class="row container" style="margin-right: auto; margin-left: auto;border:solid 1px;width: 50%;margin-top:15px">
			<form class="col s12" action= "<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
				
				<h4 align="center"> Editar perfil </h4>
				
				<div class="row">
					<div class="input-field inline col s6 offset-s4">
						<input style='width:65%' placeholder="Nome" name="nome" type="text">
					</div>
				</div>
				
				<div class="row">
					<div class="input-field inline col s6 offset-s4">
					  <input style='width:65%' placeholder="Senha" name="senha" type="password">
					</div>
				</div>
                <input name='id_usuario' style='display:none' value='<?php echo $id_usuario;?>'>
				<button style='color:white'type="submit" name="editar" class="col s8 offset-s2 btn waves-effect #f57f17 black darken-4">
				Editar  </button>
			</form>
		</div>


        <?php
            if($admin == 1):
                $servidor = $_SERVER['PHP_SELF'];
                echo "
                <h5 align=center> Editar outros usuários </h5>

                <form action='$servidor' method='GET'>
                    <div style='display:flex;justify-content:center;'>
                        <a class='dropdown-trigger btn black' href='#' data-target='dropdown1'>Usuários</a>
                            <ul id='dropdown1' class='dropdown-content'>";
                            $sql = "SELECT * FROM usuario where codigo != $id_usuario";
                            $resultado = mysqli_query($connect,$sql);
                            while ($row = mysqli_fetch_assoc($resultado)):

                                $nome_pesquisa = $row['nome'];
                                $codigo_pesquisa  = $row['codigo'];
                                $login_pesquisa = $row['login'];
                
                                echo "<li> <a href='perfil.php?pesquisa=$login_pesquisa'> $login_pesquisa ($nome_pesquisa) </a></li>";
                            endwhile;
                            echo "
                            </ul>
                        
                    </div>
                </form>";
                    
                    
                    echo"
                </div>";
            endif;
        ?>

    

        <?php
            if(isset($_POST['editar'])): //checando se o usuário clicou em editar
                require("requires/editar.php");
            endif;

            if(isset($_GET['pesquisa'])): //checando se o usuário pesquisou
                require("requires/pesquisa.php");
            endif;
            
            if($admin == 1):
                echo "<a style='margin-top: 10px;background-color:green;'href='requires/exportar.php'> 
                    <button style='color:white;'type='button' class='btn'>Exportar para o Excel</button>
                    </a>";
            endif;
        
        ?>
       
        
    
	</main>

</html>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        var options = {
            
        };
        var instances = M.Dropdown.init(elems, options);
      });
    
</script>
	