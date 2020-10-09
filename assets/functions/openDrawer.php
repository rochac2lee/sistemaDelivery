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

if ($statusCaixa == 1) {
	$saldoAnterior = $_POST['saldoAnterior'];
	$saldoDia      = "0,00";
	$saldoAtual    = $_POST['saldoAtual'];
	$lucro         = "0,00";
	$dateOpen      = date('Y-m-d H:i');
} else {

	$saldoAnterior = $_POST['saldoAnterior'];
	$saldoDia      = $_POST['saldoDia'];
	$saldoAtual    = $_POST['saldoAtual'];
	$lucro         = $_POST['lucro'];
	$lucro         = preg_replace('/[^0-9]+/','.', $lucro);

	$select = "SELECT * FROM caixa WHERE id = 0 ORDER BY id ASC";
	$result = $conexao -> prepare($select);
	$result->execute();
	$count = $result->rowCount();
	$lucroAcumulado = 0;
	if ($data = $result->fetch()) {
		do {

			$viewLucroAcumulado = $data['lucro'];
			$viewLucroAcumulado = preg_replace('/[^0-9]+/','.',$viewLucroAcumulado);

			$lucroAcumulado = $lucroAcumulado + $viewLucroAcumulado;

		} while ($data = $result -> fetch());
	}

	$lucroAcumulado = $lucroAcumulado + $lucro;
	$lucroAcumulado = number_format($lucroAcumulado, 2, ',', '.');

	$dateClose     = date('Y-m-d H:i');
}

$dataRef       = $_POST['dataHora'];
$pessoa        = $_POST['pessoa'];
$observacao    = $_POST['newDescricao'];

if ($statusCaixa == 1) {

	setCookie('statusCaixa', '1', time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');

	$conexao->exec("INSERT INTO caixa (id, dataHoraAbertura, dataHoraFechamento, saldo_anterior, saldo_dia, saldo_atual, lucro, observacao, status, data_hora_cadastro)
													   VALUES ('', '$dateOpen', '$dateClose', '$saldoAnterior', '$saldoDia', '$saldoAtual', '$lucro', '$observacao', '$statusCaixa', '$date')" );
} else {

	setCookie('statusCaixa', '0', time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');

	$conexao->exec("UPDATE caixa SET dataHoraFechamento='$dateClose', saldo_anterior='$saldoAnterior', saldo_dia='$saldoDia', saldo_atual='$saldoAtual', lucro='$lucroAcumulado', observacao='$observacao', status='$statusCaixa' WHERE id = '$id'" );

}

sleep(3);
echo "<script>window.location='../../ui-finances.php?nav=resultado';</script>";

$conexao->commit();

?>
