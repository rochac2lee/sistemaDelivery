<?php

include("../includes/conexao.php");

$categoria = $_POST['categoria'];
$status    = $_POST['statusCategoria'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("INSERT INTO categorias (id, nome, status)
                          VALUES ('', '$categoria', '$status')" );

echo "<script>window.location='../../ui-products.php?status=1';</script>";

$conexao->commit();

?>
