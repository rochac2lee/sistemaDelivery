<?php

include("../includes/conexao.php");

$tipoNegocio = $_POST['tipoNegocio'];
$status      = $_POST['status'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');

$conexaoDelivery->beginTransaction();

$conexaoDelivery->exec("INSERT INTO tipos_negocio (id, tipoNegocio, status)
														VALUES ('', '$tipoNegocio', '$status')" );

sleep(3);
echo "<script>window.location='../../ui-encode-category.php';</script>";

$conexaoDelivery->commit();

?>
