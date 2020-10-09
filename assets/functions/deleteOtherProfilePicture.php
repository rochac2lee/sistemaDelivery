<?php

include("../includes/conexao.php");

$id        = $_GET['id'];
$avatar    = "admin.png";

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$conexao->beginTransaction();

$conexao->exec("UPDATE usuarios SET avatar = '$avatar' WHERE id = '$id'" );

echo "<script>window.location='../../ui-otherprofile.php?id=$id';</script>";

$conexao->commit();

?>
