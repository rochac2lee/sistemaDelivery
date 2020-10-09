<?php

include("../includes/conexao.php");

$comanda = $_GET['comanda'];

$total = 0;

$select = "SELECT * FROM produtos";
$result = $conexao -> prepare($select);
$result->execute();
$qtdProdutosCadastrados = $result->rowCount();

$qtdProdutosCadastrados++;

$idPedido  = $_GET['idPedido'];
$idCliente = $_GET['idCliente'];

for($i == 0; $i <= $qtdProdutosCadastrados; $i++) {
	$x = "idProduto".$i;
	$viewIdProduto = $_COOKIE[$x];

	$y = "qtdProduto".$i;
	$viewQtdProduto = $_COOKIE[$y];

	$select = "SELECT id, nome, categoria, foto, preco FROM produtos where id = '$viewIdProduto' order by id ASC";
	$result = $conexao -> prepare($select);
	$result->execute();
	$count = $result->rowCount();

	if ($data = $result->fetch()) {
		do {

			$id     = $data['id'];
			$nome   = $data['nome'];
			$categoria = $data['categoria'];

			if($categoria == 999) {
				$nome = "Taxa de Entrega";
			}

			$banner = $data['foto'];
			$preco  = $data['preco'];

			$viewQtd     = $_COOKIE['qtdProduto'.$id];
			$qtd         = $_COOKIE['qtdProduto'.$id]."x -";
			$observacao  = $_COOKIE['observacao'.$id];

			$total  = preg_replace('/[^0-9]+/','.',$total);
			$subTotal  = preg_replace('/[^0-9]+/','.',$subTotal);
			$viewPreco = preg_replace('/[^0-9]+/','.',$preco);

			$subTotal = ($viewQtd * $viewPreco);

			$total += $subTotal;

			$subTotal = number_format ($subTotal, 2, ',', '.');
			$total    = number_format ($total, 2, ',', '.');

			echo "
					<div style='float: left; width: 100%;'>
						<h5><strong>$qtd $nome</strong></h5>
						<i onclick=window.location.href='assets/functions/clearCookie.php?idPedido=$idPedido&idCliente=$idCliente&idProduto=$id&comanda=$comanda'; style='margin-top: -15px; cursor: pointer; float: right;' class='fa fa-trash-alt'></i>
						<div><h6><span>R$ $subTotal</span></h6></div>
						<div><p><span>$observacao</span></p></div>
					</div>
					<div class='clearfix'></div>
			";

		} while ($data = $result->fetch());
	}
};

$select = "SELECT id, idProduto, quantidade, observacao FROM pedido_itens where idPedido = '$idPedido' order by id ASC";
$result = $conexao -> prepare($select);
$result->execute();
$count = $result->rowCount();

if ($data = $result->fetch()) {
	do {

		$viewIdProduto  = $data['idProduto'];
		$viewQtd        = $data['quantidade'];
		$viewObservacao = $data['observacao'];

		$selectProduto = "SELECT id, nome, categoria, foto, preco FROM produtos where id = '$viewIdProduto' order by id ASC";
		$resultProduto = $conexao -> prepare($selectProduto);
		$resultProduto->execute();
		$countProduto = $resultProduto->rowCount();

		if ($dataProduto = $resultProduto->fetch()) {
			do {

				$id     = $dataProduto['id'];
	  		$nome   = utf8_decode($dataProduto['nome']);
				$categoria = $dataProduto['categoria'];
				if($categoria == 999) {
					$nome = "Taxa de Entrega";
				}
				$banner = $dataProduto['foto'];
				$preco  = $dataProduto['preco'];

				$qtd         = $viewQtd."x -";
				$observacao  = $viewObservacao;

				$subTotal = preg_replace('/[^0-9]+/','.',$subTotal);
				$total = preg_replace('/[^0-9]+/','.',$total);
				$viewPreco = preg_replace('/[^0-9]+/','.',$preco);

				$subTotal = ($viewQtd * $viewPreco);

				$total += $subTotal;

				$subTotal = number_format ($subTotal, 2, ',', '.');
				$total    = number_format ($total, 2, ',', '.');

				$nome   = utf8_encode($nome);

				echo "
						<div style='float: left; width: 100%;'>
							<h5><strong>$qtd $nome</strong></h5>
							<i onclick=window.location.href='assets/functions/clearCookie.php?idPedido=$idPedido&idCliente=$idCliente&idProduto=$id&comanda=$comanda'; style='margin-top: -15px; cursor: pointer; float: right;' class='fa fa-trash-alt'></i>
							<div><h6><span>R$ $subTotal</span></h6></div>
							<div><p><span>$observacao</span></p></div>
						</div>
						<div class='clearfix'></div>
				";

			} while ($dataProduto = $resultProduto->fetch());
		}
	} while ($data = $result->fetch());
}

echo "
<input type='text' value='$total' id='totalPedido' name='totalPedido' style='display: none;'>
<h5 style='float: right; '>R$ $total</h5>
<div class='clearfix'></div>
";

?>
