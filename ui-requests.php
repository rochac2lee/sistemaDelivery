<?php

require('assets/includes/session.php');

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
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php')?>

<div id="loading" style="display: none; width: 100%; height: 100%; background: #000000a6; position: absolute; z-index: 1;">

	<img src="assets/images/loading.gif" style="width: 10%; top: 45%; left: 50%; position: fixed;">

</div>

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

</script>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<?php

							if ($countCaixa != "") {

    						/* $select = "SELECT
                            pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
														usuarios.id as idCliente, usuarios.nome as nomeCliente,
														endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
                           FROM pedidos
                           LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
													 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
													 WHERE DAY(pedidos.data_hora_cadastro) = DAY(current_timestamp) and MONTH(pedidos.data_hora_cadastro) = MONTH(current_timestamp) and YEAR(pedidos.data_hora_cadastro) = YEAR(current_timestamp)
													 ORDER BY pedidos.id DESC"; */
								 $select = "SELECT
                             pedidos.id, pedidos.idCaixa, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
 														usuarios.id as idCliente, usuarios.nome as nomeCliente,
 														endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
                            FROM pedidos
                            LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
 													 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
 													 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
													 WHERE pedidos.idCaixa = '$idCaixa'
 													 ORDER BY pedidos.id DESC";
								}
      					$result = $conexao -> prepare($select);
      					$result -> execute();
      					$count = $result->rowCount();

								$comanda = $count;

								$nextComanda = ++$count;

								setCookie('comanda', $nextComanda, time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');

						?>


						<script>

						function newComanda() {

							var idCaixa = getCookie('idCaixa');
							var comanda = getCookie('comanda');

							window.location.href="assets/functions/newIdRequest.php?idCaixa=" + idCaixa + "&comanda=" + comanda;
							loading();
						}
						</script>

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Pedidos</h1>
												<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">
														<?php
														if ($countCaixa == 1) {
														?>
															<button onclick="newComanda()" class="btn btn-raised btn-info" id="btnNewRequest"><i class="fa fa-plus-circle"></i>&nbsp; Novo Pedido</button>
														<?php
														} else {
														?>
														<button onclick="caixa();" class="btn btn-raised btn-info" id="btnNewRequest"><i class="fa fa-plus-circle"></i>&nbsp; Novo Pedido</button>
														<?php
														}
														?>
														<button onclick="hideNewRequest()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i>&nbsp; Cancelar</button>
													</li>
												</ol>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">


							<!-- início do formulário cadastro de cargos -->
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<div class="card mb-3 animated fadeIn" id="listRequests">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-file-invoice"></i> <span class="float-right"><?php echo $day."/".$monthname ?></span>
									</div>
									<div class="card-body">
										<table class="table table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Comanda</th>
											  <th scope="col">Cliente</th>
											  <th scope="col">Status</th>
											  <th scope="col">Valor Total</th>
											  <th scope="col">Valor Cobrado</th>
											  <th scope="col">Pagamento</th>
											  <th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
											<?php

		        						if ($data = $result -> fetch()) {
		        							do {

														$viewIdCliente  = $data['idCliente'];

		                        $viewIdPedido   = "#".$data['id'];
		                        $idPedido       = $data['id'];
		                        $formaPagamento = $data['formaPagamento'];

														switch ($formaPagamento) {
															case 1:
																$viewFormaPagamento = "Dinheiro";
																break;

															case 2:
																$viewFormaPagamento = "Cartão";
																break;

															case 3:
																$viewFormaPagamento = "Dinheiro e Cartão";
																break;
														}

		                        $status         = $data['status'];

														switch ($status) {
															case 1:
																$viewStatus = "Pedido realizado";
																$class="badge badge-primary";
																break;

															case 2:
																$viewStatus = "Pedido confirmado";
																$class="badge badge-info";
																break;

															case 3:
																$viewStatus = "Em produção";
																$class="badge badge-info";
																break;

															case 4:
																$viewStatus = "Pronto para entrega";
																$class="badge badge-info";
																break;

															case 5:
																$viewStatus = "Pedido à caminho";
																$class="badge badge-info";
																break;

															case 6:
																$viewStatus = "Pedido Entregue";
																$class="badge badge-success";
																break;

														}

		                        $dataPedido     = $data['data_hora_cadastro'];
		                        $dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

		                        $valorTotal     = $data['valorTotal'];
		                        $valorCobrado   = $data['valorCobrado'];

														$total = preg_replace('/[^0-9]+/','.',$total);
														$valorCobrado = preg_replace('/[^0-9]+/','.',$valorCobrado);

														$total = $total + $valorCobrado;

														$total = number_format($total, 2, ',', '.');
														$valorCobrado = number_format($valorCobrado, 2, ',', '.');

		                        $nomeCliente    = $data['nomeCliente'];
		                        $rua            = $data['rua'];
		                        $numero         = $data['numero'];
		                        $bairro         = $data['bairro'];
		                        $complemento    = $data['complemento'];
		                        $descricao      = $data['descricao'];

														$style = "style='cursor: pointer;' onclick=window.location.href='ui-new-request.php?idPedido=$idPedido&idCliente=$viewIdCliente&comanda=$comanda'";

														if ($status != 6) {
															$styleBtnReload = "display: block;";
														} else {
															$styleBtnReload = "display: none;";
														}

														$newStatus = $status + 1;

														$changeStatus = "onclick=loading();window.location.href='assets/functions/statusRequest.php?idPedido=$idPedido&status=$newStatus'";

														$finishStatus = "onclick=loading();window.location.href='assets/functions/statusRequest.php?idPedido=$idPedido&status=6'";

														echo "
															<tr>
															  <td $style>#$comanda</td>
															  <td $style>$nomeCliente</td>
																<td><p class='$class'>$viewStatus</p>
																			<i $finishStatus style='float: right; cursor: pointer; margin-left: 5px; color: green; $styleBtnReload' class='fa fa-1-5x fa-check'></i>&nbsp;&nbsp;
																			<i $changeStatus style='float: right; cursor: pointer; $styleBtnReload' class='fa fa-1-5x fa-sync-alt'></i>
																</td>
															  <td $style>$valorTotal</td>
															  <td $style>$valorCobrado</td>
															  <td $style>$viewFormaPagamento</td>
															  <td>
																<a href='ui-view-request.php?idPedido=$idPedido&comanda=$comanda'><i class='fa fa-search'></i> Ver Detalhes</a><br>
																</td>
															</tr>
														";

														$comanda--;

													} while ($data = $result->fetch());
												}

												echo "
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td>$total</td>
														<td></td>
														<td></td>
													</tr>
													";

													if ($total == "") {
														$total = "0,00";
													}

													$cookie_name = "pedidosDia";
													setcookie($cookie_name, $total, time() + (86400 * 30), "/sistemaDelivery");

											?>
										  </tbody>
										</table>
									</div>
								</div> <!-- end card -->
								<!-- fim do formulário cadastro de cargos -->

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

<script>
	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
		$("#preco").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#precoPromo").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	});
</script>

<script src="assets/plugins/trumbowyg/trumbowyg.min.js"></script>
<script src="assets/plugins/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
<script>
$(document).ready(function () {
    'use strict';
	$('.editor').trumbowyg();
});
</script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>

<script src="assets/plugins/jquery.filer/js/jquery.filer.min.js"></script>
<script>
$(document).ready(function(){

	'use-strict';

    //Example 2
    $('#uploadBanner').filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'pdf', 'png', 'gif', 'psd'],
        changeInput: true,
        showThumbs: true,
        addMore: true,
        captions: {
            button: "<i class='fa fa-upload'></i>",
            feedback: "Selecione um arquivo...",
            feedback2: "arquivo selecionado",
            drop: "Drop file here to Upload",
            removeConfirmation: "Deseja realmente remover o arquivo?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        },
    });

});
</script>


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

</body>
</html>
