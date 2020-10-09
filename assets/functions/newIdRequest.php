<?php

include("../includes/conexao.php");

$comanda = $_GET['comanda'];
$idCaixa = $_GET['idCaixa'];

$selectPedido = "SELECT id FROM pedidos ORDER BY id DESC LIMIT 1";
$resultPedido = $conexao -> prepare($selectPedido);
$resultPedido -> execute();
$countPedido = $resultPedido->rowCount();

if ($dataPedido = $resultPedido->fetch()) {
	do {

		$lastPedido = $dataPedido['id'];

	} while ($dataPedido = $resultPedido->fetch());
}

	$lastPedido = $lastPedido + 1;

$conexao->exec("INSERT INTO pedidos (id, idCaixa, valorTotal, valorCobrado, data_hora_cadastro, data_hora_atualizacao)
													VALUES ('$lastPedido', '$idCaixa', '0,00', '0,00', '$date', '$date')" );

		echo "<script>window.location='../../ui-new-request.php?idPedido=$lastPedido&comanda=$comanda';</script>";

		$conexao->commit();

?>
