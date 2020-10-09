<?php

$monthAtual    = date('m');
$yearAtual     = date('Y');

try {
		include("../includes/conexao.php");
		// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !

		$jsonArray = array();
		$jsonArrayItem = array();

		$selectRecAz = "SELECT DISTINCT data_corrente, qtd_caminhoes, qtd_descargas, qtd_cotas, turno1, turno2, turno3 FROM tb_RecAz where MONTH(data_corrente) = '$monthAtual' and YEAR(data_corrente)  = '$yearAtual' order by id ASC";
		$resultRecAz = $conexao -> prepare($selectRecAz);
		$resultRecAz -> execute();
		$countRecAz = $resultRecAz->rowCount();

		if ($data_RecAz = $resultRecAz->fetch()) {
			do {

				$data = $data_RecAz['data_corrente'];

				$dataMesCorrente = date('m', strtotime($data));
				$dataAnoCorrente = date('y', strtotime($data));
				$dataDiaCorrente = date('d', strtotime($data));


				$jsonArrayItem['label']         = $dataDiaCorrente;

				$jsonArrayItem['qtdCaminhoes'] = $data_RecAz['qtd_caminhoes'];
				$jsonArrayItem['qtdDescargas'] = $data_RecAz['qtd_descargas'];
				$jsonArrayItem['qtdCotas']     = $data_RecAz['qtd_cotas'];
				$jsonArrayItem['qtdTurno1']     = $data_RecAz['turno1'];
				$jsonArrayItem['qtdTurno2']     = $data_RecAz['turno2'];
				$jsonArrayItem['qtdTurno3']     = $data_RecAz['turno3'];

			array_push($jsonArray, $jsonArrayItem);

			} while ($data_RecAz = $resultRecAz->fetch());
		}

	header('Content-type: application/json');

   	echo json_encode($jsonArray);

} catch(PDOException $e) {
	echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}
?>
