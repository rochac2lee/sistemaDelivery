<?php

include("../includes/conexao.php");

$conexao->beginTransaction();

	$idPedido  = $_GET['idPedido'];
	$idCliente = $_GET['idCliente'];
	$comanda   = $_GET['comanda'];

	$idEndereco = $_POST ["idEndereco"];

	if ($idEndereco == "") {

		$rua  					 = trim(strip_tags( $_POST ["newRua"]));
		$numero 				 = trim(strip_tags( $_POST ["newNumero"]));
		$bairro 				 = trim(strip_tags( $_POST ["newBairro"]));
		$complemento 		 = trim(strip_tags( $_POST ["newComplemento"]));
		$descricao  		 = trim(strip_tags( $_POST ["newDescricao"]));

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');
		$date     = date('Y-m-d H:i:s');

		$select = "SELECT * FROM endereco_cliente ORDER BY id DESC LIMIT 1";
		$result = $conexao -> prepare($select);
		$result -> execute();
		$count = $result->rowCount();

			if ($data = $result -> fetch()) {
				do {

					$lastId = $data['id'];

				} while($data = $result -> fetch());
			}

		$newId = $lastId + 1;

		$conexao->exec("INSERT INTO endereco_cliente (idCliente, rua, numero, bairro, complemento, descricao, data_hora_cadastro, id)
															         VALUES('$idCliente', '$rua', '$numero', '$bairro', '$complemento', '$descricao', '$date', '$newId')" );

		$conexao->exec("UPDATE pedidos SET idCliente='$idCliente', idEndereco='$newId', data_hora_cadastro='$date' WHERE id = '$idPedido'" );

		echo "<script>window.location='../../ui-new-request.php?idPedido=$idPedido&idCliente=$idCliente&step=checkout&comanda=$comanda';</script>";

	} else {

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');
		$date     = date('Y-m-d H:i:s');


		$conexao->exec("UPDATE pedidos SET idCliente='$idCliente', idEndereco='$idEndereco', data_hora_cadastro='$date' WHERE id = '$idPedido'" );

		echo "<script>window.location='../../ui-new-request.php?idPedido=$idPedido&idCliente=$idCliente&step=checkout&comanda=$comanda';</script>";

	}


$conexao->commit();

?>
