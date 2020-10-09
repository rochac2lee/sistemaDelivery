<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Brasilia');

$dateFil = date('Y/m/d'); // 2019/01/24

try {
		include("../includes/conexao.php");
		// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
			
		$datafiltroIn = $dateFil." 00:00"; // 2019/01/24 00:00
		$datafiltroFi = $dateFil." 23:59"; // 2019/01/24 23:59
		
		$countRegistros     = 0;
		$countRegPendentes  = 0;
		$countRegConcluidos = 0;


		$jsonArray = array();
		$jsonArrayItem = array();

	$select = "
		SELECT 
			RequisicaoDescarga.RegRequisicao, RequisicaoDescarga.DtRequisicao, RequisicaoDescarga.DtSaida, RequisicaoDescarga.Motorista, RequisicaoDescarga.PlacaCavalo, RequisicaoDescarga.SitReg, RequisicaoDescarga.PesoBru,
			Motorista.Motorista, Motorista.Nome
		FROM 
			[Corporate].[dbo].RequisicaoDescarga
		INNER JOIN
			[Corporate].[dbo].Motorista
		ON
			Motorista.Motorista = RequisicaoDescarga.Motorista
		WHERE
			RequisicaoDescarga.DtRequisicao >= '$datafiltroIn' and RequisicaoDescarga.DtRequisicao <= '$datafiltroFi'
		ORDER BY 
			RequisicaoDescarga.RegRequisicao DESC";

	$result = $conexao_sql->prepare($select);
	$result->execute();
	$count = $result->rowCount(); 
	
	if ($data = $result->fetch()) {
		do {

			$status 	     = $data['SitReg'];

			if ($status == "C") {
				
				$countRegConcluidos = $countRegConcluidos + 1;
			} else {

				$countRegPendentes = $countRegPendentes + 1;
			}

			$countRegistros = $countRegistros + 1;

			$jsonArrayItem['qtdCam'] = $countRegistros;
			$jsonArrayItem['qtdPen'] = $countRegPendentes;
			$jsonArrayItem['qtdOk']  = $countRegConcluidos;

			$jsonArrayItem['qtdant'] = $countRegistros + 50;			

		} while ($data = $result->fetch());
	} 		

	array_push($jsonArray, $jsonArrayItem);

	header('Content-type: application/json');
   	
   	echo json_encode($jsonArray);

} catch(PDOException $e) {
			echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}
?>