<?php

include("../includes/conexao.php");

$categoria = $_GET['categoria'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("DELETE FROM categorias WHERE id = '$categoria'");

echo "<script>window.location='../../ui-products.php?status=1';</script>";

$conexao->commit();

?>
