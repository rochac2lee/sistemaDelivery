<?php

include("../includes/conexao.php");

$id       = $_GET['idEmpresa'];
$whats2   = $_POST['whats2'];
$whatsapp = $_POST['whats'];

	$conexaoDelivery->beginTransaction();

	$conexaoDelivery->exec("UPDATE clientes_encode SET whatsMask ='$whats2', whatsapp = '$whatsapp' WHERE id = '$id'" );

	echo "<script>window.location='../../ui-business-menu.php';</script>";

	$conexaoDelivery->commit();

?>
