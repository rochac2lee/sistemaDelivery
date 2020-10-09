<?php

include("../includes/conexao.php");

$idItem        = $_GET['id'];
$viewCategoria = $_GET['categoria'];

switch ($viewCategoria) {
	case 'entradas':
		$tabela = "contas_rec";
		break;

	case 'saidas':
		$tabela = "contas_pag";
		break;

	case 'sangria':
		$tabela = "contas_san";
		break;
}

$tipo         = $_POST['tipo'];
$categoria    = $_POST['categoriaItem'];
$dataVenc     = $_POST['dataVenc'];
$dataRef      = $_POST['dataRef'];
$descricao    = $_POST['descricao'];
$pessoa       = $_POST['pessoa'];
$valor        = $_POST['valor'];
$nDoc         = $_POST['nDoc'];
$codTipoDoc   = $_POST['codTipoDoc'];
$observacao   = $_POST['observacao'];
$statusItem   = $_POST['statusItem'];

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');
$date       = date('Y-m-d H:i');

$conexao->exec("UPDATE $tabela SET categoria='$categoria', dataVenc='$dataVenc', dataRef='$dataRef', descricao='$descricao', idUsuario='$pessoa', valor='$valor', nDoc='$nDoc', codTipoDoc='$codTipoDoc', observacoes='$observacao', baixa='$statusItem' WHERE id = '$idItem'" );

echo "<script>window.location='../../ui-finances-details.php?id=$idItem&categoria=$viewCategoria';</script>";

$conexao->commit();

?>
