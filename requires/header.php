<style>
    @media (max-width: 394px){
        #logo-container{
            font-size: 80% !important;
        }
    }
</style>

<?php

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 21600)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>

<header class="col s12 m6" style='z-index:9999;top: 0;position: fixed;width: 100%;'>
    <nav style="background-color: black;" role="navigation">
        <div class="nav-wrapper container"><a style="left: 50%;width: 50%;;font-size: 110%;" id="logo-container" href="index.php" class="brand-logo center">Sadrian - Casa de Lâminas</a>
            
        <?php
            if(isset($_SESSION['logado'])):
                if($_SESSION['logado']):
                    echo "<ul class='left'>
                            <li style='font-size:80%'> Olá $nome_usuario! </li>
                        </ul>";
                    if($admin == 1):
                        echo "<ul class='right'>
                            
                            <li><a class='tiny' style='padding:0 5px' href='cadastro-usuarios.php'> <i style='font-size:15px' class= 'material-icons'> person_add </i> </a> </li>
                            <li><a class='tiny' style='padding:0 5px' href='cadastro.php'> <i style='font-size:15px' class= 'material-icons'> add_circle </i> </a> </li>    
                            <li><a style='padding:0 5px' href='requires/logout.php'> <i style='font-size:15px'class= 'material-icons'> exit_to_app </i> </a> </li>
                        </ul>";
                    else:
                        echo "
                        <ul class='right'>
                            <li><a style='padding:0 5px' href='requires/logout.php'> <i style='font-size:15px'class= 'material-icons'> exit_to_app </i> </a> </li>
                        </ul>";
                    endif;
                else:
                    echo "
                    <ul class='right'>
                        <li><a style='font-size:10px;padding:0 5px' href='../login.php'> LOGIN </a> </li>
                    </ul>
                    <ul class='left'>
                        <li><a style='font-size:10px;padding:0 5px' onclick='voltar()'> VOLTAR </a> </li>
                    </ul>";
                endif;
            else:
                echo "
                    <ul class='right'>
                        <li><a style='font-size:10px;padding:0 5px' href='../login.php'> LOGIN </a> </li>
                    </ul>
                    <ul class='left'>
                        <li><a style='font-size:10px;padding:0 5px' onclick='voltar()'> VOLTAR </a> </li>
                    </ul>";
            endif;
        ?>
        </div>
    </nav>
</header>

<script>
    function voltar(){
        javascript:history.go(-1);
    }
</script>