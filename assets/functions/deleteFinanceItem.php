<?php

include("../includes/conexao.php");

$idItem        = $_GET['id'];
$viewCategoria = $_GET['categoria'];

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');
$date       = date('Y-m-d H:i');

switch ($viewCategoria) {
	case 'entradas':
		$tabela = "contas_rec";
		$nav = "entradas";
		break;

	case 'saidas':
		$tabela = "contas_pag";
		$nav = "saidas";
		break;

	case 'sangria':
		$tabela = "contas_san";
		$nav = "saidas";
		break;
}

$conexao->exec("DELETE FROM $tabela WHERE id = '$idItem'" );

echo "<script>window.location='../../ui-finances.php?nav=$nav';</script>";

$conexao->commit();


?>
