<?php

$status = $_GET['status'];

include("../includes/conexao.php");

$nomeProduto = $_POST['nomeProduto'];
$descricao   = $_POST['descricao'];
$preco       = $_POST['preco'];
$precoPromo  = $_POST['precoPromo'];
$margemLucro = $_POST['margemLucro'];
$idCategoria = $_POST['idCategoria'];
$status = 1;
	date_default_timezone_set('America/Brasilia');
	$dateTime      = date('d/m/Y H:i:s');

	//UPLOAD
	$banner   = $_FILES['uploadBanner'];
	$numFile  = count(array_filter($banner['name']));

	//REQUISITOS
	$permite 	= array('image/bmp', 'image/jpeg', 'image/jpg', 'image/gif', 'image/png');
	$maxSize	= 1024 * 1024 * 24;

	//PASTA
	$folder = '../uploads/banner';

		$conexao->beginTransaction();

	if ($numFile > 0) {
		//Faz o upload de multiplos arquivos
		for ($count = 0; $count < $numFile; $count++) {
			$name 	= $banner['name'][$count];
			$type	= $banner['type'][$count];
			$size	= $banner['size'][$count];
			$error	= $banner['error'][$count];
			$tmp	= $banner['tmp_name'][$count];

			$banner = $name;

			if(move_uploaded_file($tmp, $folder.'/'.$banner)) {

				$conexao->exec("INSERT INTO produtos (id, nome, foto, preco, precoPromo, lucro, descricao, categoria, status, visivel, data_hora_cadastro)
																	VALUES ('', '$nomeProduto', '$banner', '$preco', '$precoPromo', '$margemLucro', '$descricao', '$idCategoria', '$status', '1', '$dateTime')" );

			}
		}
	} else {

			$banner = 'produto_padrao.png';

			$conexao->exec("INSERT INTO produtos (id, nome, foto, preco, precoPromo, lucro, descricao, categoria, status, visivel, data_hora_cadastro)
																VALUES ('', '$nomeProduto', '$banner', '$preco', '$precoPromo', '$margemLucro', '$descricao', '$idCategoria', '$status', '1', '$dateTime')" );

	}

		sleep(3);
		echo "<script>window.location='../../ui-products.php?status=$status';</script>";

		$conexao->commit();

?>
