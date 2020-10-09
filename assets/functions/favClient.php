<?php

include("../includes/conexao.php");

$id     = $_GET['id'];
$fav    = $_GET['fav'];

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("UPDATE usuarios SET favorito = '$fav' WHERE id = '$id'" );

echo "<script>window.location='../../ui-clients.php';</script>";

$conexao->commit();

?>
