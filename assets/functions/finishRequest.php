<?php

include("../includes/conexao.php");

$idPedido = $_GET['idPedido'];
$comanda  = $_GET['comanda'];

$select = "SELECT * FROM produtos";
$result = $conexao -> prepare($select);
$result->execute();
$qtdProdutosCadastrados = $result->rowCount();

$qtdProdutosCadastrados++;

$conexao->beginTransaction();

for($i == 0; $i <= $qtdProdutosCadastrados; $i++) {

	$x = "idProduto".$i;
	if (isset($_COOKIE[$x])) {

		$idProduto = $_COOKIE[$x];

		$y = "qtdProduto".$i;
		$qtdProduto = $_COOKIE[$y];

		$z = "observacao".$i;
		$observacao = $_COOKIE[$z];

		$select = "SELECT * FROM pedido_itens WHERE idPedido = '$idPedido' and idProduto = '$idProduto'";
		$result = $conexao -> prepare($select);
		$result -> execute();
		$count = $result->rowCount();

		if ($count == "") {

			$conexao->exec("INSERT INTO pedido_itens (id, idPedido, idProduto, quantidade, observacao)
																VALUES ('', '$idPedido', '$idProduto', '$qtdProduto', '$observacao')" );

		} else {

			$conexao->exec("UPDATE pedido_itens SET quantidade='$qtdProduto', observacao='$observacao' WHERE idPedido = '$idPedido' and idProduto = '$idProduto'" );

		}

	}
};

$totalPedido    = $_POST['totalPedido'];
$formaPagamento = $_POST['formaPagamento'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$select = "SELECT status FROM pedidos WHERE id = '$idPedido'";
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

if ($data = $result -> fetch()) {
	do {

		$getStatus = $data['status'];

		if ($getStatus == 0) {
			$getStatus = 1;
		}

	} while($data = $result -> fetch());
}

$conexao->exec("UPDATE pedidos SET valorTotal='$totalPedido', valorCobrado='$totalPedido', status='$getStatus', formaPagamento='$formaPagamento' WHERE id = '$idPedido'" );

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

echo "<script>window.location='../../ui-view-request.php?idPedido=$idPedido&comanda=$comanda';</script>";


$conexao->commit();

?>
