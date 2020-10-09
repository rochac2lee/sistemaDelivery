<?php

include("../includes/conexao.php");

$bairros     = $_POST['bairros'];
$preco       = $_POST['preco'];
$idCategoria = $_POST['idCategoria'];
$status = 1;

	date_default_timezone_set('America/Brasilia');
	$dateTime      = date('d/m/Y H:i:s');

		$conexao->beginTransaction();

		$conexao->exec("INSERT INTO produtos (id, nome, foto, preco, categoria, status, data_hora_cadastro)
																VALUES ('', '$bairros', 'location.png', '$preco', '$idCategoria', '$status', '$dateTime')" );

		sleep(3);
		echo "<script>window.location='../../ui-delivery.php';</script>";

		$conexao->commit();

?>
