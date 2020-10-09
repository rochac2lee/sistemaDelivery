<?php

include("../includes/conexao.php");

$idPedido       = $_GET['idPedido'];
$idCliente      = $_GET['idCliente'];
$comanda        = $_GET['comanda'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$select = "SELECT nome, celular FROM usuarios WHERE id = '$idCliente'";
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

if ($data = $result->fetch()) {
	do {

		$nome    = $data['nome'];
		$celular = $data['celular'];

	} while ($data = $result->fetch());
}

	$conexao->exec("UPDATE pedidos SET idCliente='$idCliente', nome='$nome', celular='$celular', data_hora_cadastro='$date' WHERE id = '$idPedido'" );

	echo "<script>window.location='../../ui-new-request.php?idPedido=$idPedido&idCliente=$idCliente&comanda=$comanda';</script>";


	$conexao->commit();

?>
