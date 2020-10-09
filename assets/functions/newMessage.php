<?php

include("../includes/conexao.php");

$nome     = $_POST['nome'];
$telefone = $_POST['telefone'];
$email    = $_POST['email'];
$mensagem = $_POST['mensagem'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');

$conexaoDelivery->beginTransaction();

$conexaoDelivery->exec("INSERT INTO mensagem (id, nome, telefone, email, mensagem)
													        	VALUES ('', '$nome', '$telefone', '$email', '$mensagem')" );

echo "<script>window.location='../../../orcamento.html';</script>";

$conexaoDelivery->commit();

?>
