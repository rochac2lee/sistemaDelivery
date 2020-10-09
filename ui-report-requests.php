<?php

$dateSearch = $_GET['filtroData'];
$dateMonth  = $_GET['filtroMonth'];

require('assets/includes/session.php');

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

						<div class="row" style="padding-top: 40px;">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<div class="card mb-3 animated fadeIn" id="listRequests">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-file-invoice"></i> <span class="float-right">Relatório - Pedidos<br><p style="font-size: 10px;
	    float: right;"><?php if ($dateSearch == "") { echo "<p class='float-right' style='margin-top: 5px; margin-bottom: 0'>Todo Período</p>"; } ?></p></span>
									</div>
									<div class="card-body">
										<div class="row" style="display: inline-flex; width: 90%;">
											<div class="col-lg-3">
												<div class="input-group">
												  <div class="input-group-prepend">
												    <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
												  </div>
												  <input type="date" class="form-control" onchange="filter()" style="width: 80%; border-left: 0;" value="<?php echo $dateSearch; ?>" id="filtroData">
												</div>
											</div>

											<div class="col-lg-3">
												<div class="input-group">
												  <div class="input-group-prepend">
												    <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
												  </div>
												  <input type="month" class="form-control" onchange="month()" style="width: 10%; border-left: 0;" value="<?php echo $dateMonth; ?>" id="filtroMonth">
												</div>
											</div>

											<?php if ($dateSearch != "" || $dateMonth != "") {?>
											<button class="btn btn-outline-secondary" onclick="clearFilter()" style="border: solid 3px #ced4da;" type="button"><i class="fa fa-times"></i></button>
											<?php } ?>


										</div>
										<div class="row" style="display: inline-flex; width: 10%; float: right;">
											<button class="btn btn-primary right" style="border: 1px solid #ced4da;" onclick="window.open('assets/functions/report.php?typeReport=request&<?php if ($dateSearch != '') { echo "dateFilter=".$dateSearch; } else if ($dateMonth != '') { echo "dateMonth=".$dateMonth."-01"; } else { echo "dateFilter="; } ?>', '_blank')" type="button">
												<i class="fa fa-print"></i>&nbsp; Imprimir
											</button>
										</div>

								<script>
								function filter() {
									var filtroData   = document.getElementById("filtroData").value;

									window.location.href='ui-report-requests.php?filtroData=' + filtroData;
								}

								function month() {
									var filtroMonth   = document.getElementById("filtroMonth").value;

									window.location.href='ui-report-requests.php?filtroMonth=' + filtroMonth;
								}

								function clearFilter() {
									window.location.href='ui-report-requests.php';
								}
								</script>
										<table class="table table-striped" id="tb1" style="margin-top: 15px">
										  <thead>
											<tr>
											  <th scope="col">ID</th>
											  <th scope="col">Caixa</th>
											  <th scope="col">Data</th>
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

											$total = 0;

											if ($dateMonth != "") {
												$dateMonth.= "-01";
												$select = "SELECT
			                              pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
																		usuarios.id as idCliente, usuarios.nome as nomeCliente,
																		endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao, caixa.id as idCaixa
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
																	 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE MONTH(caixa.dataHoraAbertura) = MONTH('$dateMonth') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateMonth')
																	 ORDER BY pedidos.id ASC";
											} else if ($dateSearch != "") {

			      						$select = "SELECT
			                              pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
																		usuarios.id as idCliente, usuarios.nome as nomeCliente,
																		endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao, caixa.id as idCaixa
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
																	 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateSearch') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateSearch') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateSearch')
																	 ORDER BY pedidos.id ASC";
											} else {
												$select = "SELECT
			                              pedidos.id, pedidos.idCaixa, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
																		usuarios.id as idCliente, usuarios.nome as nomeCliente,
																		endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao, caixa.id as idCaixa
			                             FROM pedidos
			                             LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
																	 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
																	 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
																	 ORDER BY pedidos.id ASC";
											}
		        					$result = $conexao -> prepare($select);
		        					$result -> execute();
		        					$count = $result->rowCount();

		        						if ($data = $result -> fetch()) {
		        							do {

														$viewIdCliente  = $data['idCliente'];

		                        $idPedido       = $data['id'];
		                        $viewIdCaixa    = $data['idCaixa'];
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

														$valorCobrado = preg_replace('/[^0-9]+/','.',$valorCobrado);

														$total += $valorCobrado;

														$valorCobrado   = number_format($valorCobrado, 2, ',', '.');

		                        $nomeCliente    = $data['nomeCliente'];
		                        $rua            = $data['rua'];
		                        $numero         = $data['numero'];
		                        $bairro         = $data['bairro'];
		                        $complemento    = $data['complemento'];
		                        $descricao      = $data['descricao'];

														$style = "style='cursor: pointer;' onclick=window.location.href='ui-new-request.php?idPedido=$idPedido&idCliente=$viewIdCliente'";

														if ($status == 6) {
															$styleBtnReload = "display: none;";
														} else {
															$styleBtnReload = "display: block;";
														}

														$newStatus = $status + 1;

														$changeStatus = "onclick=loading();window.location.href='assets/functions/statusRequest.php?idPedido=$idPedido&status=$newStatus&screen=report-request'";

														$finishStatus = "onclick=loading();window.location.href='assets/functions/statusRequest.php?idPedido=$idPedido&status=6&screen=report-request'";

														echo "
															  <td $style>$idPedido</td>
															  <td $style>$viewIdCaixa</td>
															  <td $style>$dataPedido</td>
															  <td $style>$nomeCliente</td>
															  <td><p class='$class'>$viewStatus</p>
																			<i $finishStatus style='float: right; cursor: pointer; margin-left: 5px; color: green; $styleBtnReload' class='fa fa-check'></i>&nbsp;&nbsp;
																			<i $changeStatus style='float: right; cursor: pointer; $styleBtnReload' class='fa fa-sync-alt'></i>
																</td>
															  <td $style>$valorTotal</td>
															  <td $style>$valorCobrado</td>
															  <td $style>$viewFormaPagamento</td>

															  <td>
																<a href='ui-view-request.php?idPedido=$idPedido'><i class='fa fa-search'></i> Ver Detalhes</a><br>

																</td>
															</tr>
														";

													} while ($data = $result->fetch());
												}

												$total          = number_format($total, 2, ',', '.');

												echo "
													<tr>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td>$total</td>
														<td></td>
														<td></td>
													</tr>
													";

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

$('[data-confirm]').click(function(e){
    e.preventDefault();
    var link = $(this).attr('href');

   swal({
          title: "Exclusão de Relatório",
          text: "Deseja realmente excluir esse Relatório? O arquivo ficará inacessível!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Relatório excluído com sucesso!", {
              icon: "success",
            });
            window.location.href = link;
          }
        });
});


function alertnewDepartament() {

$(document).ready(function(){

       swal("Bom Trabalho!", "Setor cadastrado com sucesso!", "success");

});
};

</script>
<!-- END Java Script for this page -->

</body>
</html>
