<?php

include("../includes/conexao.php");

$conexao->beginTransaction();

$id        = $_GET['id'];
$empresa   = $_POST['empresa'];
$cnpj      = $_POST['cnpj'];
$email     = $_POST['email'];
$telefone  = $_POST['telefone'];
$bancoDB   = $_POST['bancoDB'];
$usuarioDB = $_POST['usuarioDB'];
$senhaDB   = $_POST['senhaDB'];
$status    = $_POST['status'];

date_default_timezone_set('America/Brasilia');
$dateTime = date('d/m/Y H:i');
$date     = date('Y-m-d H:i:s');

	if ($id == "") {

		$conexao->exec("INSERT INTO clientes_encode (empresa, cnpj, email, telefone, bancoDB, usuarioDB, senhaDB, status, data_hora_cadastro, id)
										        	          VALUES('$empresa', '$cnpj', '$email', '$telefone', '$bancoDB', '$usuarioDB', '$senhaDB', '$status', '$date', '')" );

	} else {

		$conexao->exec("UPDATE clientes_encode SET empresa='$empresa', cnpj='$cnpj', telefone='$telefone', bancoDB='$bancoDB', usuarioDB='$usuarioDB', status='$status' WHERE id = '$id'" );

	}

$conexao->commit();

echo "<script>window.location='../../ui-clientsSys.php';</script>";

?>
