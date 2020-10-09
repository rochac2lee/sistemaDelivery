<?php

include("../includes/conexao.php");

$screen        = $_GET['screen'];

$idPedido       = $_GET['idPedido'];
$status         = $_GET['status'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

if($status <= 4) {
  $conexao->exec("UPDATE pedidos SET status='$status', data_hora_atualizacao='$date' WHERE id = '$idPedido'" );
} else {
  $conexao->exec("UPDATE pedidos SET status='$status' WHERE id = '$idPedido'" );
}


if ($screen == "report-request") {
  echo "<script>window.location='../../ui-report-requests.php';</script>";
} else {
  echo "<script>window.location='../../ui-requests.php';</script>";
}

$conexao->commit();

?>
