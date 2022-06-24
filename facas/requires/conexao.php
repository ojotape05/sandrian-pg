<?php 

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $dbname = "leilaofaca";

    $connect= pg_connect($servidor,$usuario,$senha,$dbname);
    if(!$connect){
        die("Erro de conexão ao BD: ".pg_connect_error());
    }

?>