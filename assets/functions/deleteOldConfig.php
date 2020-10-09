<?php

include("../includes/conexao.php");

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

$select = "SELECT
            id_config, idTipoNegocio, logo_sistema
          FROM
            configs
          ORDER BY id_config DESC LIMIT 1
          ";
$result = $conexao -> prepare($select);
$result -> execute();
$countUsersActual = $result->rowCount();

if ($data = $result->fetch()) {
  do {

    $id_config      = $data['id_config'];

  } while ($data = $result->fetch());
}

$conexao->beginTransaction();

$conexao->exec("DELETE FROM configs WHERE id_config = '$id_config'");

echo "<script>window.location='../../ui-settings.php';</script>";

$conexao->commit();

?>
