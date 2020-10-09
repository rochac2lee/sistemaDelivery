<?php

include("../includes/conexao.php");

$conexao->beginTransaction();

$idPedido = $_GET['idPedido'];

if ($idPedido == "") {

	if ($_GET['id'] == "") {

		$nome  					 = trim(strip_tags( $_POST ["nome"]));
		$dataNasc				 = trim(strip_tags( $_POST ["data_nascimento"]));
		$celular 				 = trim(strip_tags( $_POST ["celular"]));

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');
		$date     = date('Y-m-d H:i:s');

		$conexao->exec("INSERT INTO usuarios (nome, nascimento, avatar, tipo, celular, data_hora_cadastro, id)
										        	VALUES('$nome', '$dataNasc', 'admin.png', '1', '$celular', '$date', '')" );

		echo "<script>window.location='../../ui-clients.php';</script>";

	} else {
		$id = $_GET['id'];

		$nome  					 = trim(strip_tags( $_POST ["nome"]));
		$dataNasc				 = trim(strip_tags( $_POST ["data_nascimento"]));
		$celular 				 = trim(strip_tags( $_POST ["celular"]));

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');
		$date     = date('Y-m-d H:i:s');

		$conexao->exec("UPDATE usuarios SET nome='$nome', nascimento='$dataNasc', celular='$celular' WHERE id = '$id'" );

		echo "<script>window.location='../../ui-clients.php';</script>";

	}

} else {


	$select = "SELECT * FROM usuarios ORDER BY id DESC LIMIT 1";
	$result = $conexao -> prepare($select);
	$result -> execute();
	$count = $result->rowCount();

		if ($data = $result -> fetch()) {
			do {

				$lastId = $data['id'];

			} while($data = $result -> fetch());
		}

	$newId = $lastId + 1;

	$nome  					 = trim(strip_tags( $_POST ["newNome"]));
	$dataNasc				 = trim(strip_tags( $_POST ["newDataNasc"]));
	$celular 				 = trim(strip_tags( $_POST ["newCelular"]));

	date_default_timezone_set('America/Brasilia');
	$dateTime = date('d/m/Y H:i');
	$date     = date('Y-m-d H:i:s');

	$conexao->exec("INSERT INTO usuarios (nome, nascimento, avatar, tipo, celular, data_hora_cadastro, id)
														VALUES('$nome', '$dataNasc', 'admin.png', '1', '$celular', '$date', '$newId')" );

	echo "<script>window.location='../../ui-new-request.php?idPedido=$idPedido&idCliente=$newId';</script>";

}

$conexao->commit();

?>
