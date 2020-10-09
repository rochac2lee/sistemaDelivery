<?php

include("../includes/conexao.php");

$tipo         = $_POST['tipo'];
$categoriaRec = $_POST['categoriaRec'];
$dataVenc     = $_POST['dataVenc'];
$dataRef      = $_POST['dataRef'];
$descricao    = $_POST['descricao'];
$pessoa       = $_POST['pessoa'];
$valor        = $_POST['valor'];
$nDoc         = $_POST['nDoc'];
$codTipoDoc   = $_POST['codTipoDoc'];
$observacao   = $_POST['newDescricao'];
$statusItem   = $_POST['statusItem'];

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');
$date       = date('Y-m-d H:i');

$conexao->exec("INSERT INTO contas_rec (id, tipo, categoria, dataVenc, dataRef, descricao, idUsuario, valor, nDoc, codTipoDoc, observacoes, data_hora_cadastro, baixa)
													VALUES ('', '$tipo', '$categoriaRec', '$dataVenc', '$dataRef', '$descricao', '$pessoa', '$valor', '$nDoc', '$codTipoDoc', '$observacao', '$date', '$statusItem')" );


sleep(3);
echo "<script>window.location='../../ui-finances.php';</script>";

$conexao->commit();

?>
