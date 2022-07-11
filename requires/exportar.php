<?php
    header("Access-Control-Allow-Origin: *");

    include("conexao.php");// Permite caracteres latinos.
    $consulta = mysqli_query($connect,'SELECT o.codigo, o.data_inicioBaixa, o.data_finalBaixa, f.custo, f.nome AS nomeFaca, o.comprador,usu.nome AS nomeVend, o.valorFinal, o.observacao, o.pagamento, o.planceinicial, o.codigoFaca FROM operacao o JOIN faca f JOIN usuario usu ON(o.codigoFaca = f.codigo AND o.codigoUsuario = usu.codigo) WHERE concluida = 1');		

    $StringJson = "["; 
    // Gera arquivo CSV
    $fp = fopen("relatorio-exportado.csv", "w"); // o "a" indica que o arquivo será sobrescrito sempre que esta função for executada.
    $escreve = fwrite($fp, "Codigo;Data Inicial;Data Final;Descrição;Comprador;Valor;Vendedor;Pagamento;OBS;Enviado?;Custo");
    if ($StringJson != "[") {$StringJson .= ",";}
    while ($registro = mysqli_fetch_assoc($consulta)) {
        $escreve = fwrite($fp,"\n$registro[codigo];$registro[data_inicioBaixa];$registro[data_finalBaixa];$registro[nomeFaca];$registro[comprador];$registro[valorFinal];$registro[nomeVend];$registro[pagamento];$registro[observacao];;$registro[custo]");           
        if ($StringJson != "[") {$StringJson .= ",";}
        $StringJson .= '{"codigo":"' . $registro['codigo']  . '",';
        $StringJson .= '"data_inicioBaixa":"' . $registro['data_inicioBaixa']  . '",';
        $StringJson .= '"data_finalBaixa":"' . $registro['data_finalBaixa']  . '",';
        $StringJson .= '"nome":"' . $registro['nomeFaca']  . '",';
        $StringJson .= '"comprador":"' . $registro['comprador']  . '",';
        $StringJson .= '"valorFinal":"' . $registro['valorFinal']  . '",';
        $StringJson .= '"nomeVend":"' . $registro['nomeVend']  . '",';
        $StringJson .= '"pagamento":"' . $registro['pagamento']  . '",';
        $StringJson .= '"observacao":"' . $registro['observacao']  . '",';
        $StringJson .= '"custo":"' . $registro['custo']  . '"}';
    }
    $StringJson .= "]";
    fclose($fp);
    include("../PHPExcel/Classes/PHPExcel/IOFactory.php");
    $objReader = PHPExcel_IOFactory::createReader('CSV');
    $objReader->setDelimiter(";"); // define que a separação dos dados é feita por ponto e vírgula
    $objReader->setInputEncoding('UTF-8'); // habilita os caracteres latinos.
    $objPHPExcel = $objReader->load('relatorio-exportado.csv'); //indica qual o arquivo CSV que será convertido
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('relatorio-exportado.xls'); // Resultado da conversão; um arquivo do EXCEL
    header("Location: relatorio-exportado.xls");
?>