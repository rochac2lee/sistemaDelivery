<?php

include("../includes/conexao.php");

$idPedido       = $_GET['idPedido'];
$comanda        = $_GET['comanda'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("UPDATE pedidos SET idMotoboy='0' WHERE id = '$idPedido'" );

echo "<script>window.location='../../ui-view-request.php?idPedido=$idPedido&comanda=$comanda';</script>";

$conexao->commit();

?>
