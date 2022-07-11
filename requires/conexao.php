<?php 

    $servidor = "162.241.203.152";
    $usuario = "vende768_wp299";
    $senha = "-k9Q29pwS-";
    $dbname = "vende768_leilaofaca";

    $connect= mysqli_connect($servidor,$usuario,$senha,$dbname);
    if(!$connect){
        die("Erro de conexão ao BD: ".mysqli_connect_error());
    }

?>