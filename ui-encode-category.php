<?php

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

<style>

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 38px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 38px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}

.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 38px;
    user-select: none;
    -webkit-user-select: none;
}

.materialIconGreen {
	width: 14%;
	text-align: center;
}
.card-materialIcon {
	padding-bottom: 0px;
}

</style>

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

	function viewNewCategory() {
		document.getElementById('frmNewCategory').style.display = 'block';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('listCategory').style.display = 'none';
		document.getElementById('btnNewCategory').style.display = 'none';
	}

	function hideNewCategory() {
		document.getElementById('frmNewCategory').style.display = 'none';
		document.getElementById('btnClose').style.display = 'none';
		document.getElementById('listCategory').style.display = 'flex';
		document.getElementById('btnNewCategory').style.display = 'block';
	}

	function viewNewPlan() {
		document.getElementById('frmNewPlan').style.display = 'block';
		document.getElementById('btnClosePlan').style.display = 'block';
		document.getElementById('listplans').style.display = 'none';
		document.getElementById('btnNewPlan').style.display = 'none';
	}

	function hideNewPlan() {
		document.getElementById('btnClosePlan').style.display = 'none';
		document.getElementById('btnClosePlan').style.display = 'none';
		document.getElementById('listplans').style.display = 'flex';
		document.getElementById('btnNewPlan').style.display = 'block';
	}

</script>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Encode</h1>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="frmNewCategory" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Adicionar Novo Tipo de Negócio</span>
										<ol class="float-right">
												<button onclick="hideNewCategory()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i></button>
										</ol>
									</div>
									<div class="card-body">

										<form action="assets/functions/newCompanyType.php" name="newCategory" id="newCategory" method="post" enctype="multipart/form-data" style="margin-top: 30px;">

										<div class="row" style="padding-top: 15px">

											<div class="col-lg-6">
											<div class="form-group">
									      <label>Tipo de Negócio</label>
									      <input type="text" class="form-control" name="tipoNegocio" id="tipoNegocio">
									    </div>
									    </div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Status</label>
											<select class="form-control" name="status" id="status">
												<option value="">Selecione...</option>
												<option selected value='1'>Ativo</option>
												<option value='0'>Inativo</option>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewTipoNegocio(){
												if (document.newCategory.tipoNegocio.value == "" && document.newCategory.status.value == ""){
													return false;
												} else {
													document.newCategory.submit();
													document.getElementById('cadTipoNegocio').style.visibility = 'hidden';
													document.getElementById('cadTipoNegocio').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewTipoNegocio()" id="cadTipoNegocio"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="listCategory">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Tipos de Negócio</span>
										<ol class="float-right">
												<button onclick="viewNewCategory()" class="btn btn-raised btn-info" id="btnNewCategory"><i class="fa fa-plus-circle"></i>&nbsp; Tipo de Negócio</button>
										</ol>
									</div>
									<div class="card-body div-scroll">
										<table class="table table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Tipo</th>
											  <th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$select = "SELECT * FROM tipos_negocio ORDER BY tipoNegocio ASC";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$id     = $data['id'];
														$tipo   = $data['tipoNegocio'];
														$status = $data['status'];

														switch ($status) {
															case 0:
																$action = "<a onclick='loading()' href='assets/functions/updateCompanyType.php?id=$id&status=1'>Ativar</a>";
																break;

															case 1:
																$action = "<a onclick='loading()' href='assets/functions/updateCompanyType.php?id=$id&status=0'>Desativar</a>";
																break;
														}

														echo "
															  <td>$tipo</td>

															  <td><center>
															  $action
																</center></td>
															</tr>
														";

													} while ($data = $result->fetch());
												}
											?>
										  </tbody>
										</table>
									</div>
								</div> <!-- end card -->

							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="frmNewPlan" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Novo Plano</span>
										<ol class="float-right">
												<button onclick="hideNewPlan()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClosePlan"><i class="fa fa-times-circle"></i></button>
										</ol>
									</div>
									<div class="card-body">

										<form action="assets/functions/newPlan.php" name="newPlan" id="newPlan" method="post" enctype="multipart/form-data" style="margin-top: 30px;">

										<div class="row" style="padding-top: 15px">

											<div class="col-lg-6">
											<div class="form-group">
									      <label>Plano</label>
									      <input type="text" class="form-control" name="plano" id="plano">
									    </div>
									    </div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Status</label>
											<select class="form-control" name="statusPlano" id="statusPlano">
												<option value="">Selecione...</option>
												<option selected value='1'>Ativo</option>
												<option value='0'>Inativo</option>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewPlan(){
												if (document.newPlan.plano.value == "" && document.newPlan.statusPlano.value == ""){
													return false;
												} else {
													document.newPlan.submit();
													document.getElementById('cadPlan').style.visibility = 'hidden';
													document.getElementById('cadPlan').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewPlan()" id="cadPlan"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="listplans">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Planos</span>
										<ol class="float-right">
												<button onclick="viewNewPlan()" class="btn btn-raised btn-info" id="btnNewPlan"><i class="fa fa-plus-circle"></i>&nbsp; Plano</button>
										</ol>
									</div>
									<div class="card-body div-scroll">
										<table class="table table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Plano</th>
											  <th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$select = "SELECT * FROM planos ORDER BY titulo ASC";
											$result = $conexaoDelivery -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$id     = $data['id'];
														$tipo   = $data['titulo'];
														$status = $data['status'];

														switch ($status) {
															case 0:
																$action = "<a onclick='loading()' href='assets/functions/updatePlan.php?id=$id&status=1'>Ativar</a>";
																break;

															case 1:
																$action = "<a onclick='loading()' href='assets/functions/updatePlan.php?id=$id&status=0'>Desativar</a>";
																break;
														}

														echo "
															  <td>$tipo</td>

															  <td><center>
															  $action
																</center></td>
															</tr>
														";

													} while ($data = $result->fetch());
												}
											?>
										  </tbody>
										</table>
									</div>
								</div> <!-- end card -->

							</div>

						</div>

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

</div>
<!-- END main -->

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>

$(document).ready(function() {
    $('.select2').select2();
});
</script>

<script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<script>
	$(document).ready(function(){
		$("#cnpj").inputmask("99.999.999/9999-99");
		$("#telefone").inputmask("(99) 9999-9999");
		$("#auth_usuario").inputmask("(99) 99999-9999");
		$("#celular").inputmask("(99) 99999-9999");
		$("#preco").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#valorTaxa").maskMoney({allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
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
          title: "Exclusão de Produto",
          text: "Deseja realmente excluir esse Produto?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Pronto! Produto excluído com sucesso!", {
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
