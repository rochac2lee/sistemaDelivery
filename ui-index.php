<div class="zoom">
	<?php
	require('assets/includes/session.php');

	if ($statusSistema == 0) {
		header("location: ui-pre-config.php");
	}

	$marginListInline = "margin-top: 7px;";

	$select = "SELECT * FROM caixa WHERE status = 1 ORDER BY id DESC LIMIT 1";
	$result = $conexao -> prepare($select);
	$result->execute();
	$countCaixa = $result->rowCount();

	if ($data = $result -> fetch()) {
		do {

			$idCaixa = $data['id'];

			setCookie('idCaixa', $idCaixa, time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');

		} while ($data = $result -> fetch());
	}

	?>
</div>

<!DOCTYPE html>
<html lang="en" style="zoom: 100%!important">

<?php require('assets/includes/head.php')?>

<style>
.swal-modal {
	zoom: 80%;
}
.tabpanel {
	margin-top: 10px!important;
}
</style>

<body class="adminbody">

	<div id="main">

		<div class="zoom">
		<?php require('assets/includes/menu.php')?>
		</div>

		<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 1;">

			<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

		</div>

		<script type="text/javascript">

		function loading() {
			document.getElementById('loading').style.display = 'block';
		}

	</script>

	<?php

	if ($idCaixa != "") {
	$select = "SELECT
							pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
							usuarios.id as idCliente,
							endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
						 FROM pedidos
						 LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
						 LEFT JOIN endereco_cliente ON pedidos.idCliente = endereco_cliente.idCliente
						 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
						 WHERE pedidos.idCaixa = '$idCaixa'
						 ORDER BY pedidos.id DESC";
	}
	$result = $conexao -> prepare($select);
	$result -> execute();
	$count = $result->rowCount();

	$comanda = $count;
	$total = 0;

		if ($data = $result -> fetch()) {
			do {

				$valorTotal     = $data['valorTotal'];
				$valorCobrado   = $data['valorCobrado'];

				$total        = preg_replace('/[^0-9]+/','.',$total);
				$valorCobrado = preg_replace('/[^0-9]+/','.',$valorCobrado);

				$total += $valorCobrado;

				$nomeCliente    = $data['nome'];
				$rua            = $data['rua'];
				$numero         = $data['numero'];
				$bairro         = $data['bairro'];
				$complemento    = $data['complemento'];
				$descricao      = $data['descricao'];

			} while ($data = $result->fetch());
		}

			if ($total == "") {
				$total = "0,00";
			}

			$total        = number_format($total, 2, ',', '.');
			$valorCobrado = number_format($valorCobrado, 2, ',', '.');

			$cookie_name = "pedidosDia";
			setcookie($cookie_name, $total, time() + (86400 * 30), "/sistemaDelivery");

	?>


	<div class="content-page zoom">

		<!-- Start content -->
		<div class="content">

			<div class="container-fluid">

				<div class="row">
					<div class="col-xl-12">
						<div class="breadcrumb-holder">
							<h1 class="main-title float-left">Dashboard</h1>
							<ol class="breadcrumb float-right">
								<li class="breadcrumb-item">Home</li>
								<li class="breadcrumb-item active">'Dashboard</li>
							</ol>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<?php

				$select = "SELECT * FROM categorias WHERE id != 999";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$categorias = $result->rowCount();

				$select = "SELECT * FROM produtos WHERE categoria != 999";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$produtos = $result->rowCount();

				$select = "SELECT * FROM produtos WHERE categoria = 999";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$taxasEntrega = $result->rowCount();

				$select = "SELECT * FROM usuarios WHERE motoboy = 1";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$motoboys = $result->rowCount();

				$select = "SELECT * FROM usuarios WHERE tipo = 1 and id != 1 and id != 2";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$clientes = $result->rowCount();

				$select = "SELECT * FROM pedidos";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$pedidos = $result->rowCount();

				$select = "SELECT SUM(quantidade) as qtdProdutos FROM pedido_itens";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$count = $result->rowCount();

				if ($data = $result -> fetch()) {
					do {
						$qtdProdutos = $data['qtdProdutos'];
						if ($qtdProdutos == NULL) {
							$qtdProdutos = 0;
						}
					} while ($data = $result -> fetch());
				}


				$select = "SELECT
										pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
										usuarios.id as idCliente,
										endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
									 FROM pedidos
									 LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
									 LEFT JOIN endereco_cliente ON pedidos.idCliente = endereco_cliente.idCliente
									 ORDER BY pedidos.id DESC";
				$result = $conexao -> prepare($select);
				$result -> execute();
				$count = $result->rowCount();

				if ($data = $result -> fetch()) {
					do {

						$valorTotal     = $data['valorTotal'];
						$valorCobrado   = $data['valorCobrado'];

						$total        = preg_replace('/[^0-9]+/','.',$total);
						$valorCobrado = preg_replace('/[^0-9]+/','.',$valorCobrado);

						$total += $valorCobrado;

						$valorCobrado   = number_format($valorCobrado, 2, ',', '.');

					} while ($data = $result->fetch());
				}

				//$total          = number_format($total, 2, ',', '.');

				if ($total != 0) {

					$TMv = $total / $pedidos;

					$TMc = $total / $clientes;

				}

				$TMv = number_format($TMv, 2, ',', '.');

				$TMc = number_format($TMc, 2, ',', '.');

				if ($_COOKIE['statusCaixa'] == 0) {
					$statusCaixa = "Fechado";
					$button = "onclick=caixa()";
					$bgCaixa = "bg-danger";
					$stCaixa = "style=cursor:pointer";
				} else {
					$statusCaixa = "Aberto";
					$button = "onclick=window.location.href='ui-finances.php?nav=resultado'";
					$bgCaixa = "bg-green";
					$stCaixa = "style=cursor:pointer";
				}

				?>

				<input type="text" value="<? echo $categorias ?>" id="qtdCategorias" style="display: none">
				<input type="text" value="<? echo $produtos ?>" id="qtdProdutos" style="display: none">
				<input type="text" value="<? echo $taxasEntrega ?>" id="taxasEntrega" style="display: none">
				<input type="text" value="<? echo $motoboys ?>" id="motoboy" style="display: none">
				<input type="text" value="<? echo $pedidos ?>" id="requests" style="display: none">

				<div class="row">

					<div class="col-lg-12" style="zoom: 110%; margin-bottom: 3%; display: none" id="stepView">
						<div id="stepper" class="bs-stepper">
						  <div class="bs-stepper-header" role="tablist">
						    <!-- your steps here -->
						    <div class="step" data-target="#productsCategory">
						      <button type="button" class="step-trigger" role="tab" aria-controls="productsCategory" id="productsCategory-trigger">
						        <span class="bs-stepper-circle" id="btnCircleProductsCategory"><i class="fa fa-list-ul"></i></span>
						        <span class="bs-stepper-label" id="labelProductsCategory">Categorias de Produtos</span>
						      </button>
						    </div>
						    <div class="line"></div>
						    <div class="step" data-target="#products">
						      <button type="button" class="step-trigger" role="tab" aria-controls="products" id="products-trigger">
						        <span class="bs-stepper-circle" id="btnCircleProducts"><i class="fa fa-box"></i></span>
						        <span class="bs-stepper-label" id="labelProducts">Adicionar Produtos</span>
						      </button>
						    </div>
								<div class="line"></div>
						    <div class="step" data-target="#delivery">
						      <button type="button" class="step-trigger" role="tab" aria-controls="delivery" id="delivery-trigger">
						        <span class="bs-stepper-circle" id="btnCircleTax"><i class="fa fa-receipt"></i></span>
						        <span class="bs-stepper-label" id="labelTax">Configure o Delivery</span>
						      </button>
						    </div>

								<div class="line"></div>
						    <div class="step" data-target="#pdv">
						      <button type="button" class="step-trigger" role="tab" aria-controls="pdv" id="pdv-trigger">
						        <span class="bs-stepper-circle" id="btnCircleRequest"><i id="faIcon" class="fa fa-cash-register"></i></span>
						        <span class="bs-stepper-label" id="labelRequest">Primeira Venda</span>
						      </button>
						    </div>

						  </div>
							<div class="bs-stepper-content">
						    <!-- your steps content here -->
						    <div id="productsCategory" class="content tabpanel" role="tabpanel" aria-labelledby="productsCategory-trigger">
									<h3>Primeiros Passos</h3>
									<p class="lead">Para que seus produtos apareçam de forma organizada para os seus clientes, crie categorias.<br>Exemplo: Caso seu negócio seja uma pizzaria, você pode criar categorias como "Pizzas Tradicionais", "Pizzas Especiais", "Pizzas Nobres", etc.</p>
									<hr class="my-4">
									<p class="lead">
										<a class="btn btn-primary" href="ui-products.php?status=1" role="button"><i class="fa fa-plus"></i>&nbsp;Categorias</a>
									</p>
								</div>
						    <div id="products" class="content tabpanel" role="tabpanel" aria-labelledby="products-trigger">
									<h3>Cadastre seus Produtos</h3>
									<p class="lead">Após criar as categorias, cadastre seus produtos. Utilize nomes fáceis de lembrar. Isso é muito importante para facilitar na hora das vendas.</p>
									<hr class="my-4">
									<p class="lead">
										<a class="btn btn-primary" href="ui-products.php?status=1" role="button"><i class="fa fa-plus"></i>&nbsp; Produtos</a>
									</p>
								</div>
								<div id="delivery" class="content tabpanel" role="tabpanel" aria-labelledby="delivery-trigger">
									<h3>Gerencie suas Entregas</h3>
									<p class="lead">Ao configurar as taxas de entrega e cadastrar entregadores, ao fazer suas vendas você verá a opção Taxas de Entrega e poderá vincular os entregadores aos pedidos.<br>Você terá a sua disposição um relatório com o total de entregas de cada entregador.</p>
									<hr class="my-4">
									<p class="lead">
										<a class="btn btn-primary" href="ui-delivery.php" role="button"><i class="fa fa-cog"></i>&nbsp; Configurar</a>
									</p>
								</div>
								<?php if ($statusCaixa != "Aberto") { ?>
								<div id="pdv" class="content tabpanel" role="tabpanel" aria-labelledby="pdv-trigger">
									<h3>Faça sua Primeira venda!</h3>
									<p class="lead">Para fazer sua primeira venda você precisa <strong>abrir o Caixa</strong>.<br>Após realizar todas as suas vendas do dia, lembre-se de fazer o fechamento do Caixa, pois assim o sistema irá fazer os cálculos corretamente.</p>
									<hr class="my-4">
									<p class="lead">
										<a class="btn btn-primary" href="#abrirCaixa" <? echo $button; ?> role="button">Abrir o Caixa &nbsp;<i class="fa fa-arrow-right"></i></a>
									</p>
								</div>
							<?php } else { ?>
								<div id="pdv" class="content tabpanel" role="tabpanel" aria-labelledby="pdv-trigger">
									<h3>Faça sua Primeira venda!</h3>
									<p class="lead">Você ja pode realizar suas vendas! Aproveite todas as funcionalizades do Sistema Delivery Encode!</p>
									<hr class="my-4">
									<p class="lead">
										<a class="btn btn-primary" href="https://encode.dev.br/sistemaDelivery/ui-requests.php" role="button">Ir para Pedidos &nbsp;<i class="fa fa-arrow-right"></i></a>
									</p>
								</div>
							<?php }  ?>
						  </div>
						</div>
					</div>

<script type="text/javascript" src="https://johann-s.github.io/bs-stepper/dist/js/bs-stepper.min.js"></script>
<script>

var qtdCategorias = document.getElementById('qtdCategorias').value;
var qtdProdutos   = document.getElementById('qtdProdutos').value;
var taxasEntrega  = document.getElementById('taxasEntrega').value;
var motoboy       = document.getElementById('motoboy').value;
var vendas        = document.getElementById('requests').value;

var stepper = new Stepper(document.querySelector('.bs-stepper'));

/*
document.addEventListener('DOMContentLoaded', function () {
  stepper = new Stepper(document.querySelector('#stepper'), {
    linear: false,
		animation: true
  })
});
*/

if (qtdCategorias == 0 || qtdProdutos == 0 || taxasEntrega == 0 || motoboy == 0 || vendas == 0) {
	document.getElementById('stepView').style.display = "block";
}

if (qtdCategorias > 0) {
	document.getElementById('btnCircleProductsCategory').classList.add("btn-success");
	document.getElementById('labelProductsCategory').classList.add("label-success");
	stepper.next();
}

if (qtdProdutos > 0) {
	document.getElementById('btnCircleProducts').classList.add("btn-success");
	document.getElementById('labelProducts').classList.add("label-success");
	stepper.next();
}

if (taxasEntrega > 0 && motoboy > 0) {
	document.getElementById('btnCircleTax').classList.add("btn-success");
	document.getElementById('labelTax').classList.add("label-success");
	stepper.next();
}

if (vendas > 0) {
	document.getElementById('btnCircleRequest').classList.add("btn-success");
	document.getElementById('labelRequest').classList.add("label-success");
	document.getElementById('faIcon').classList.remove("fa-cash-register");
	document.getElementById('faIcon').classList.add("fa-check");
	document.getElementById('labelRequest').innerHTML = "Sistema Configurado!";
	document.getElementById('pdv').style.display = "none";
	stepper.next();
}


</script>

					<div class="col-lg-6">
						<div class="col-lg-12">
							<div class="card mb-3">
								<div class="card-materialIcon" style="font-size: 18px;">
									<i class="materialIconGreen fa fa-sort-amount-up"></i> <span class="float-right">Ranking de Pedidos</span>
								</div>
								<div class="card-body">

									<table class="table table-striped" id="tb1">
										<thead>
											<tr>
												<th style="width:50px">Favorito</th>
												<th scope="col">id</th>
												<th scope="col">Cliente</th>
												<th scope="col">Pedidos</th>
											</tr>
										</thead>
										<tbody>

											<?php
											$selectCliente = "SELECT
											count(pedidos.idCliente) as qtdPedidos,
											usuarios.id,
											usuarios.nome
											FROM
											pedidos
											INNER JOIN
											usuarios ON pedidos.idCliente = usuarios.id
											WHERE usuarios.id != 125 GROUP BY pedidos.idCliente ORDER BY qtdPedidos DESC LIMIT 5";
											$resultCliente = $conexao -> prepare($selectCliente);
											$resultCliente -> execute();
											$countCliente = $resultCliente->rowCount();

											if ($dataCliente = $resultCliente->fetch()) {
												do {

													$idCliente   = $dataCliente['id'];
													$nomeCliente = $dataCliente['nome'];
													$qtdPedidos  = $dataCliente['qtdPedidos'];

													//Favorita o cliente automaticamente
													$conexao->beginTransaction();
													$conexao->exec("UPDATE usuarios SET favorito = '1' WHERE id = '$idCliente'" );
													$conexao->commit();

														$favClass = "fas fa-1-5x fa-star fav";

													echo "
													<tr>
													<td style='text-align: center'><i class='$favClass'></i></td>
													<td>$idCliente</td>
													<td>$nomeCliente</td>
													<td>$qtdPedidos</td>
													</tr>
													";

												} while ($dataCliente = $resultCliente->fetch());
											}
											?>

										</tbody>
									</table>
								</div><!-- end card-->
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="row">

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
								<div <?php echo $button." ".$stCaixa ?> class="card-box noradius noborder <?php echo $bgCaixa ?>">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20">Caixa</h6>
									<h1 class="m-b-20 text-white"><?php echo $statusCaixa ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
								<div class="card-box noradius noborder bg-info">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20">Clientes</h6>
									<h1 class="m-b-20 text-white counter"><?php echo $clientes ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
								<div class="card-box noradius noborder bg-green">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20">Pedidos</h6>
									<h1 class="m-b-20 text-white counter"><?php echo $pedidos ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
								<div class="card-box noradius noborder bg-secondary">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20">Produtos Vendidos</h6>
									<h1 class="m-b-20 text-white counter"><?php echo $qtdProdutos ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
								<div class="card-box noradius noborder bg-secondary">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20">Vendas - <?php echo $day."/".$monthname ?></h6>
									<h1 class="m-b-20 text-white"><?php echo $_COOKIE["pedidosDia"]; ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
								<div class="card-box noradius noborder bg-success">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20 left">Ticket Médio</h6> <p class="label-right white right">(por Venda)</p>
									<div class="clearfix"></div>
									<h1 class="m-b-20 text-white"><?php echo $TMv; ?></h1>
								</div>
							</div>

							<div class="col-xs-12 col-md-6 col-lg-6 col-xl-6">
								<div class="card-box noradius noborder bg-success">
									<i class="float-right text-white"></i>
									<h6 class="text-white text-uppercase m-b-20 left">Ticket Médio</h6> <p class="label-right white right">(por Cliente)</p>
									<div class="clearfix"></div>
									<h1 class="m-b-20 text-white"><?php echo $TMc; ?></h1>
								</div>
							</div>

						</div>
					</div>
				</div>

				<?php

				$filtroAno = 2020;

				for ($i=1; $i <= $month && $year == $filtroAno; $i++) {

					$select = "SELECT COUNT(id) as id FROM usuarios WHERE id != 1 and id != 2 and MONTH(data_hora_cadastro) = $i and YEAR(data_hora_cadastro) = $year";
					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

					if ($data = $result -> fetch()) {
						do {

							$qtdClientes = $data['id'];

							if ($i != $month) {
								if ($qtdClientes == "") { $qtdClientes = 0; }
								$qtdNovosClientes = $qtdNovosClientes."".$qtdClientes.", ";
							} else {
								if ($qtdClientes == "") { $qtdClientes = 0; }
								$qtdNovosClientes = $qtdNovosClientes."".$qtdClientes;
							}

						} while ($data = $result -> fetch());
					}

				}

				for ($i=1; $i <= $month && $year == $filtroAno; $i++) {

					$select = "SELECT SUM(quantidade) as qtdProdutos FROM pedido_itens INNER JOIN pedidos ON pedido_itens.idPedido = pedidos.id WHERE MONTH(data_hora_cadastro) = $i and YEAR(data_hora_cadastro) = $year";
					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

					if ($data = $result -> fetch()) {
						do {

							$qtdProdutos = $data['qtdProdutos'];

							if ($i != $month) {
								if ($qtdProdutos == "") { $qtdProdutos = 0; }
								$qtdProdVendidos = $qtdProdVendidos."".$qtdProdutos.", ";
							} else {
								if ($qtdProdutos == "") { $qtdProdutos = 0; }
								$qtdProdVendidos = $qtdProdVendidos."".$qtdProdutos;
							}

						} while ($data = $result -> fetch());
					}

				}

				for ($i=1; $i <= $month && $year == $filtroAno; $i++) {

					$select = "SELECT COUNT(id) as qtdPedidos FROM pedidos WHERE MONTH(data_hora_cadastro) = $i and YEAR(data_hora_cadastro) = $year";
					$result = $conexao -> prepare($select);
					$result -> execute();
					$count = $result->rowCount();

					if ($data = $result -> fetch()) {
						do {

							$qtdPedidos = $data['qtdPedidos'];

							if ($i != $month) {
								if ($qtdPedidos == "") { $qtdPedidos = 0; }
								$qtdPedidosRealizados = $qtdPedidosRealizados."".$qtdPedidos.", ";
							} else {
								if ($qtdPedidos == "") { $qtdPedidos = 0; }
								$qtdPedidosRealizados = $qtdPedidosRealizados."".$qtdPedidos;
							}

						} while ($data = $result -> fetch());
					}

				}

				?>

			</div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

	</div>
	<!-- END content-page -->

	<div class="content-page" style="margin-left: 200px">

		<!-- Start content -->
		<div class="content" style="margin-top: 0">

			<div class="container-fluid">

				<div class="col-lg-12" style="margin-left: -6px;">
					<div class="row" style="padding-top: 25px;">

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
							<div class="card mb-3">
								<div class="card-materialIcon zoom">
									<i class="materialIconGreen fa fa-chart-line"></i> <span class="float-right">Clientes<br><p style="font-size: 10px;
    float: right;">(por Mês)</p></span>
								</div>
								<div class="card-body">
									<canvas id="novosClientes" style="zoom: 100%"></canvas>
								</div>
								<div class="card-footer small text-muted">Atualizado em <?php echo $day." de ".$monthname." de ".$year ?></div>
							</div><!-- end card-->
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
							<div class="card mb-3">
								<div class="card-materialIcon zoom">
									<i class="materialIconGreen fa fa-chart-line"></i> <span class="float-right">Produtos Vendidos<br><p style="font-size: 10px;
    float: right;">(por Mês)</p></span>
								</div>
								<div class="card-body">
									<canvas id="produtosVendidos" style="zoom: 100%"></canvas>
								</div>
								<div class="card-footer small text-muted">Atualizado em <?php echo $day." de ".$monthname." de ".$year ?></div>
							</div><!-- end card-->
						</div>

					</div>

					<div class="row" style="padding-top: 25px;">

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
							<div class="card mb-3">
								<div class="card-materialIcon zoom">
									<i class="materialIconGreen fa fa-chart-line"></i> <span class="float-right">Pedidos<br><p style="font-size: 10px;
    float: right;">(por Mês)</p></span>
								</div>
								<div class="card-body">
									<canvas id="chartPedidos" style="zoom: 100%"></canvas>
								</div>
								<div class="card-footer small text-muted">Atualizado em <?php echo $day." de ".$monthname." de ".$year ?></div>
							</div><!-- end card-->
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
							<div class="card mb-3">
								<div class="card-materialIcon zoom">
									<img src="assets/images/birthday.png" class="materialIconBlue" width="13%"> <span class="float-right">Aniversariantes do Mês</span>
								</div>
								<div class="card-body">
									<table class="table table-striped zoom" id="tb1">
										<thead>
											<tr>
												<th scope="col">Cliente</th>
												<th scope="col">Data de Nascimento</th>
												<th scope="col">Celular</th>
											</tr>
										</thead>
										<tbody>

										<?php
											$select = "SELECT nome, nascimento, celular FROM usuarios WHERE MONTH(DATE_FORMAT(STR_TO_DATE(nascimento, '%d/%m/%Y'), '%Y-%m-%d')) = $month";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

											if ($data = $result -> fetch()) {
												do {

													$nome       = $data['nome'];
													$nascimento = $data['nascimento'];
													$celular    = $data['celular'];

													echo "
													<tr>
													<td>$nome</td>
													<td>$nascimento</td>
													<td>$celular</td>
													</tr>
													";


												} while ($data = $result -> fetch());
											}

										?>

										</tbody>
									</table>

								</div>
								<div class="card-footer small text-muted">Atualizado em <?php echo $day." de ".$monthname." de ".$year ?></div>
							</div><!-- end card-->
						</div>

					</div>
				</div>

			</div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

	</div>
	<!-- END content-page -->

	<?php require("assets/includes/copyright.php") ?>

</div>
<!-- END main -->

<!-- smooth scrolling -->
	<script src="assets/js/SmoothScroll.min.js"></script>
	<script type="text/javascript" src="assets/js/move-top.js"></script>
	<script type="text/javascript" src="assets/js/easing.js"></script>
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear'
				};
			*/

			$().UItoTop({ easingType: 'easeOutQuart' });

			});
	</script>
	<!-- //here ends scrolling icon -->
<!-- //smooth scrolling -->

<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/moment.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>

<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>

<!-- BEGIN Java Script for this page -->

<!-- BEGIN Java Script for this page -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>


	function caixa(){
   swal({
          title: "O Caixa está fechado!",
          text: "Você precisa abrir o caixa primeiro!",
          icon: "warning",
          buttons: true,
					buttons: {
				    cancel: "Cancel",
				    financeiro: {
				      text: "Abrir o Caixa",
				      value: "financeiro",
				    }
				  },
          dangerMode: true
  })
	.then((value) => {
  switch (value) {

    case "financeiro":
      swal("Redirencionando...");
			icon: "success",
			window.location.href="ui-finances.php?nav=resultado&openDrawer=1";
      break;

    default:
      swal("O Caixa permanecerá fechado!");
  }
	});
}

</script>
<!-- END Java Script for this page -->

<script>

// comboBarLineChart
var novosClientes = document.getElementById("novosClientes").getContext('2d');
var myChart = new Chart(novosClientes, {
	type: 'line',
	data: {
		labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
		datasets: [{
			label: 'Novos Clientes',
			borderColor: '#6c757d',
			borderWidth: 3,
			fill: true,
			data: [<?php echo $qtdNovosClientes; ?>]
		}],
		borderWidth: 1
	},
	options: {
		responsive: true,
		legend: {
			position: 'bottom',
			align: 'end'
		},
		elements: {
			line: {
				tension: 0
			}
		}
	}
});

// comboBarLineChart
var produtosVendidos = document.getElementById("produtosVendidos").getContext('2d');
var myChart = new Chart(produtosVendidos, {
	type: 'line',
	data: {
		labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
		datasets: [{
			label: 'Prudutos Vendidos',
			borderColor: '#484c4f',
			borderWidth: 3,
			fill: true,
			data: [<?php echo $qtdProdVendidos; ?>]
		}],
		borderWidth: 1
	},
	options: {
		responsive: true,
		legend: {
			position: 'bottom',
			align: 'end'
		},
		elements: {
			line: {
				tension: 0
			}
		}
	}
});

// comboBarLineChart
var pedidos = document.getElementById("chartPedidos").getContext('2d');
var myChart = new Chart(pedidos, {
	type: 'line',
	data: {
		labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
		datasets: [{
			label: 'Pedidos',
			borderColor: '#484c4f',
			borderWidth: 3,
			fill: true,
			data: [<?php echo $qtdPedidosRealizados; ?>]
		}],
		borderWidth: 1
	},
	options: {
		responsive: true,
		legend: {
			position: 'bottom',
			align: 'end'
		},
		elements: {
			line: {
				tension: 0
			}
		}
	}
});

</script>

<script src="assets/plugins/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>
<script>
    $(document).ready(function() {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
</script>

</body>
</html>
