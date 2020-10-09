<?php

include("../includes/conexao.php");

if (isset($_GET['id']) && isset($_GET['status'])) {
  $id     = $_GET['id'];
  $status = $_GET['status'];
} else {
  $id        = $_POST['idMotoboy'];
  $status    = $_POST['statusMotoboy'];
  $valorTaxa = $_POST['valorTaxa'];
}

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("UPDATE usuarios SET motoboy = '$status', taxaMotoboy = '$valorTaxa' WHERE id = '$id'" );

echo "<script>window.location='../../ui-delivery.php';</script>";

$conexao->commit();

?>
