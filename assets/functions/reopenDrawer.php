<?php

include("../includes/conexao.php");

$select = "SELECT * FROM caixa ORDER BY id DESC LIMIT 1";
$result = $conexao -> prepare($select);
$result->execute();
$count = $result->rowCount();

if ($data = $result->fetch()) {
	do {

		$id = $data['id'];

	} while ($data = $result -> fetch());
}

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');

$statusCaixa   = $_POST['statusCaixa'];
$saldoAnterior = $_POST['saldoAnterior'];
$saldoDia      = $_POST['saldoDia'];
$saldoAtual    = $_POST['saldoAtual'];
$lucro         = $_POST['lucro'];

$conexao->exec("UPDATE caixa SET dataHoraFechamento='', saldo_anterior='$saldoAnterior', saldo_dia='$saldoDia', saldo_atual='$saldoAtual', lucro='$lucro', status='$statusCaixa' WHERE id = '$id'" );

echo "<script>window.location='../../ui-finances.php?nav=resultado';</script>";

$conexao->commit();

?>
