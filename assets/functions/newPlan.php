<?php

include("../includes/conexao.php");

$plano       = $_POST['plano'];
$status      = $_POST['statusPlano'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');

$conexaoDelivery->beginTransaction();

$conexaoDelivery->exec("INSERT INTO planos (id, titulo, status)
														VALUES ('', '$plano', '$status')" );

sleep(3);
echo "<script>window.location='../../ui-encode-category.php';</script>";

$conexaoDelivery->commit();

?>
