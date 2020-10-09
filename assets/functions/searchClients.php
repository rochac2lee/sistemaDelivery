<?php

  include("../includes/conexao.php");

	$select = "SELECT id, nome FROM usuarios WHERE tipo = 1";

	   $result = $conexao -> prepare($select);
    $result -> execute();
    echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
?>
