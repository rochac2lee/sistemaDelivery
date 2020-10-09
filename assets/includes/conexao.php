<?php

try {
	$conexaoDelivery = new PDO('mysql:host=opmy0018.servidorwebfacil.com:3306;dbname=rochac2lee_sistemaDelivery', 'rocha_delivery', 'qwerty@848625');
	$conexaoDelivery -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}

$idEmpresa = $_COOKIE["idEmpresa"];

$select = "SELECT * from clientes_encode WHERE id = '$idEmpresa'";
$result = $conexaoDelivery -> prepare($select);
$result -> execute();
$count = $result->rowCount();
	if ($data = $result -> fetch()) {
		do {

			$idEmpresaAtual = $data['id'];
			$empresaAtual   = $data['empresa'];
			$whatsMask      = $data['whatsMask'];
			$whatsapp       = $data['whatsapp'];
			$qrCodeEmpresa  = $data['qrCode'];
			$bancoDB        = $data['bancoDB'];
			$usuarioDB      = $data['usuarioDB'];
			$senhaDB        = $data['senhaDB'];

		} while ($data = $result -> fetch());
	}

	try {
		$conexao = new PDO("mysql:host=opmy0018.servidorwebfacil.com:3306;dbname=$bancoDB", "$usuarioDB", "$senhaDB");
		$conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
	}


?>
