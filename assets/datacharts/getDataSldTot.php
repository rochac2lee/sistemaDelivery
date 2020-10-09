<?php

try {
		include("../includes/conexao.php");
		// RECEBENDO OS DADOS PREENCHIDOS DO FORMULÁRIO !
		
		$jsonArray = array();
		$jsonArrayItem = array();

		$selectQtdSaldos = "SELECT * FROM tb_saldos order by id_saldo ASC";
		$resultQtdSaldos = $conexao -> prepare($selectQtdSaldos);
		$resultQtdSaldos -> execute();
		$countQtdSaldos = $resultQtdSaldos->rowCount();			

		if ($data_QtdSaldos = $resultQtdSaldos->fetch()) {
			do {	

				$IdCli            = $data_QtdSaldos['id_cliente'];

				//$SldQtdTotal      = $data_QtdSaldos['qtd_total'];
				//$SldQtdNomeado    = $data_QtdSaldos['qtd_nomeado'];
				//$SldQtdDisponivel = $data_QtdSaldos['qtd_disponivel'];

				$selectNomeCli = "SELECT nome FROM tb_clientes where id_cliente = '$IdCli'";
				$resultNomeCli = $conexao -> prepare($selectNomeCli);
				$resultNomeCli -> execute();
				$countNomeCli = $resultNomeCli->rowCount();			

				if ($data_NomeCli = $resultNomeCli->fetch()) {
					do {	

						$jsonArrayItem['label']         = $data_NomeCli['nome'];

						$jsonArrayItem['qtdTotal']      = $data_QtdSaldos['qtd_total'];
						$jsonArrayItem['qtdDisponivel'] = $data_QtdSaldos['qtd_disponivel'];
						$jsonArrayItem['qtdNomeado']    = $data_QtdSaldos['qtd_nomeado'];

						array_push($jsonArray, $jsonArrayItem);

					} while ($data_NomeCli = $resultNomeCli->fetch());
				}	
			} while ($data_QtdSaldos = $resultQtdSaldos->fetch());
		}			

	header('Content-type: application/json');
   	
   	echo json_encode($jsonArray);

} catch(PDOException $e) {
			echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}
?>