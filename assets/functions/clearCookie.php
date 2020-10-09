<?php

include("../includes/conexao.php");

$idPedido  = $_GET['idPedido'];
$idProduto = $_GET['idProduto'];
$idCliente = $_GET['idCliente'];
$comanda   = $_GET['comanda'];

$delIdProduto    = "idProduto".$idProduto;
$delQtdProduto   = "qtdProduto".$idProduto;
$delPrecoProduto = "precoProduto".$idProduto;
$delObservacao   = "observacao".$idProduto;

$select = "SELECT * FROM pedido_itens WHERE idPedido = '$idPedido' and idProduto = '$idProduto'";
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

if ($count != "") {

	$conexao->exec("DELETE FROM pedido_itens WHERE idPedido = '$idPedido' and idProduto = '$idProduto'" );

}

setCookie($delIdProduto, '', time() - ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');
setCookie($delQtdProduto, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');
setCookie($delPrecoProduto, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');
setCookie($delObservacao, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');

echo "<script>window.location='../../ui-new-request.php?idPedido=$idPedido&idCliente=$idCliente&comanda=$comanda';</script>";

?>
