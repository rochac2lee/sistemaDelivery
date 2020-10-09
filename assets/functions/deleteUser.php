<?php

include("../includes/conexao.php");

$id        = $_GET['id'];

$conexao->beginTransaction();

$conexao->exec("DELETE from usuarios WHERE id = '$id'" );

sleep(3);

echo "<script>window.location='../../ui-users.php';</script>";

$conexao->commit();

?>
