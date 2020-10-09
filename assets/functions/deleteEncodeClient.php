<?php

include("../includes/conexao.php");

$id = $_GET['id'];

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');
$date       = date('Y-m-d H:i');


$conexao->exec("DELETE FROM clientes_encode WHERE id = '$id'" );

echo "<script>window.location='../../ui-clientsSys.php';</script>";

$conexao->commit();


?>
