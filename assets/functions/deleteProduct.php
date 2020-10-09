<?php

$id     = $_GET['id'];
$status = $_GET['status'];

include("../includes/conexao.php");

	$conexao->exec("UPDATE produtos SET visivel = '0' WHERE id = '$id'" );

	echo "<script>window.location='../../ui-products.php?status=$status';</script>";

	$conexao->commit();

?>
