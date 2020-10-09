<?php

$idEnpresa  = $_GET['idEmpresa'];
$tipo       = $_GET['tipo'];

		include("../includes/conexao.php");

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');

		$conexaoDelivery->beginTransaction();

		//UPLOAD
		$logo   = $_FILES['uploadBanner'];
		$numFile  = count(array_filter($logo['name']));

		//REQUISITOS
		$permite 	= array('image/bmp', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
		$maxSize	= 1024 * 1024 * 24;

		//PASTA
		$folder = '../uploads/banner';

		if ($numFile > 0) {
			//Faz o upload de multiplos arquivos
			for ($count = 0; $count < $numFile; $count++) {
				$name 	= $logo['name'][$count];
				$type	= $logo['type'][$count];
				$size	= $logo['size'][$count];
				$error	= $logo['error'][$count];
				$tmp	= $logo['tmp_name'][$count];

				move_uploaded_file($tmp, $folder.'/'.$name);

				$conexaoDelivery->exec("INSERT INTO uploads (idClienteEncode, arquivo, tipo, id)
																					VALUES('$idEnpresa', '$name', '$tipo', '')" );
			}
		} else {
				$logo = "Encode.png";
		}

		sleep(3);
		echo "<script>window.location='../../ui-business-menu.php';</script>";

		$conexaoDelivery->commit();

?>
