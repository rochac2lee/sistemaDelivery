<?php

include("../includes/conexao.php");

$id     = $_GET['id'];
$status = $_GET['status'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("UPDATE produtos SET status = '$status' WHERE id = '$id'" );

echo "<script>window.location='../../ui-delivery.php';</script>";

$conexao->commit();

?>
