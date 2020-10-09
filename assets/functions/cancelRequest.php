<?php

include("../includes/conexao.php");

$idPedido  = $_GET['idPedido'];
$idCliente = $_GET['idCliente'];
$comanda   = $_GET['comanda'];

$select = "SELECT * FROM produtos";
$result = $conexao -> prepare($select);
$result->execute();
$qtdProdutosCadastrados = $result->rowCount();

$conexao->beginTransaction();

$conexao->exec("DELETE FROM pedido_itens WHERE idPedido = '$idPedido'" );

$conexao->exec("DELETE FROM pedidos WHERE id = '$idPedido'" );

for($j == 0; $j <= $qtdProdutosCadastrados; $j++) {

	$delIdProduto    = "idProduto".$j;
	$delQtdProduto   = "qtdProduto".$j;
	$delPrecoProduto = "precoProduto".$j;
	$delObservacao   = "observacao".$j;

	setCookie($delIdProduto, '', time() - ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');
	setCookie($delQtdProduto, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');
	setCookie($delPrecoProduto, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');
	setCookie($delObservacao, '', time() - ( 60 * 60 * 24 * 30 ) , '/sistemaDelivery');


};

echo "<script>window.location='../../ui-requests.php';</script>";

$conexao->commit();

?>
