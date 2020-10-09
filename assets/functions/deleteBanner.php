<?php

include("../includes/conexao.php");

$id = $_GET['id'];

date_default_timezone_set('America/Brasilia');
$dateTime   = date('d/m/Y H:i:s');
$date       = date('Y-m-d H:i');

$url = "../uploads/banner/";

$select = "SELECT * FROM uploads where id = $id";
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

  if ($data = $result -> fetch()) {
    do {

      $url    = "../uploads/banner/";
      $imagem = $data['arquivo'];

    } while ($data = $result -> fetch());
  }

$imagem = $url.$imagem;

unlink($imagem);

$conexao->exec("DELETE FROM uploads WHERE id = '$id'" );

echo "<script>window.location='../../ui-business-menu.php';</script>";

$conexao->commit();


?>
