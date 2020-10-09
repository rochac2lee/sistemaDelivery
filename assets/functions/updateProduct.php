<?php

include("../includes/conexao.php");

$codigo      = $_GET['id'];

$produto     = $_POST['produto'];
$descricao   = $_POST['descricao'];
$preco       = $_POST['preco'];
$precoPromo  = $_POST['precoPromo'];
$margemLucro = $_POST['margemLucro'];
$status      = $_POST['status'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');

	$conexao->beginTransaction();

	//INFO IMAGEM
	$file 		= $_FILES['uploadBanner'];
	$numFile	= count(array_filter($file['name']));

	//PASTA
	$folder		= '../uploads/banner/';

	//REQUISITOS
	$permite 	= array('image/jpeg', 'image/png');
	$maxSize	= 1024 * 1024 * 2;

	//MENSAGENS
	$msg		= array();
	$errorMsg	= array(
	  1 => 'O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.',
	  2 => 'O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML',
	  3 => 'o upload do arquivo foi feito parcialmente',
	  4 => 'Nao foi feito o upload do arquivo'
	);

	if($numFile <= 0) {
		$imagem = "produto_padrao.png";
	} else {

		for($i = 0; $i < $numFile; $i++) {
	    $name  = $file['name'][$i];
	    $type	 = $file['type'][$i];
	    $size	 = $file['size'][$i];
	    $error = $file['error'][$i];
	    $tmp	 = $file['tmp_name'][$i];

	    $imagem = $name;

	    if($error != 0)
	      $msg[] = "<b>$name :</b> ".$errorMsg[$error];
	    else if(!in_array($type, $permite))
	      $msg[] = "<b>$name :</b> Erro imagem nao suportada!";
	    else if($size > $maxSize)
	      $msg[] = "<b>$name :</b> Erro imagem ultrapassa o limite de 5MB";
	    else {
	      if (move_uploaded_file($tmp, $folder.'/'.$imagem)) {
					$imagem = $name;
				}
			}
		}

	}

	$conexao->exec("UPDATE produtos SET nome='$produto', foto='$imagem', preco='$preco', precoPromo='$precoPromo', lucro='$margemLucro',  descricao='$descricao', status='$status' WHERE id = '$codigo'" );

echo "<script>window.location='../../ui-view-product.php?id=$codigo';</script>";

$conexao->commit();

?>
