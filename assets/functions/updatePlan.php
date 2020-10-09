<?php

include("../includes/conexao.php");

$id           = $_GET['id'];
$status       = $_GET['statusPlano'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');

$conexaoDelivery->beginTransaction();

$conexaoDelivery->exec("UPDATE planos SET status = '$status' WHERE id = '$id'");

sleep(3);
echo "<script>window.location='../../ui-encode-category.php';</script>";

$conexaoDelivery->commit();

?>
