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

	function viewNewTaxa() {
		document.getElementById('frmNewProduct').style.display = 'block';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('listProducts').style.display = 'none';
		document.getElementById('btnNewProduct').style.display = 'none';
	}

	function hideNewTaxa() {
		document.getElementById('frmNewProduct').style.display = 'none';
		document.getElementById('btnClose').style.display = 'none';
		document.getElementById('listProducts').style.display = 'block';
		document.getElementById('btnNewProduct').style.display = 'block';
	}

	function viewNewMotoboy() {
		document.getElementById('frmNewMotoboy').style.display = 'block';
		document.getElementById('btnCloseMotoboy').style.display = 'block';
		document.getElementById('listMotoboys').style.display = 'none';
		document.getElementById('btnNewMotoboy').style.display = 'none';
	}

	function hideNewMotoboy() {
		document.getElementById('frmNewMotoboy').style.display = 'none';
		document.getElementById('btnCloseMotoboy').style.display = 'none';
		document.getElementById('listMotoboys').style.display = 'block';
		document.getElementById('btnNewMotoboy').style.display = 'block';
	}

</script>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Delivery</h1>
												<div class="clearfix"></div>
										</div>
								</div>
						</div>
						<!-- end row -->

						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="frmNewProduct" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Adicionar Taxa de Entrega</span>
										<ol class="float-right">
												<button onclick="hideNewTaxa()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i></button>
										</ol>
									</div>
									<div class="card-body">

										<form action="assets/functions/newTax.php" name="newTax" id="newTax" method="post" enctype="multipart/form-data" style="margin-top: 30px;">

										<div class="row" style="padding-top: 15px">

											<style type="text/css">
												.trumbowyg-box, .trumbowyg-editor-visible, .trumbowyg-en, .trumbowyg {
													    min-height: 150px!important;
												}
												.trumbowyg-editor, .trumbowyg-textarea {
													min-height: 150px!important;
												}
											</style>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Título / Bairros</label>
											<textarea class="form-control editor" rows="3" name="bairros" id="bairros"></textarea>
											</div>
											</div>

										</div>

										<div class="row">

											<div class="col-auto">
									      <label>Taxa de Entrega</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="preco" id="preco" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-lg-6">
											<div class="form-group">
											<label>Categoria</label>
											<select class="form-control col-md-10 float-left" name="idCategoria" id="idCategoria">
												<option value="">Selecione...</option>
											<?php
												$select = "SELECT * FROM categorias WHERE id = 999 ORDER BY id ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$idCategoria = $data['id'];
														$nome        = utf8_encode($data['nome']);

														echo "<option selected value='$idCategoria'>$nome</option>";

												} while($data = $result->fetch());
											}

											?>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewTax(){
												if (document.newTax.bairros.value == "" && document.newTax.preco.value == ""){
													return false;
												} else {
													document.newTax.submit();
													document.getElementById('cadTaxa').style.visibility = 'hidden';
													document.getElementById('cadTaxa').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewTax()" id="cadTaxa"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="listProducts">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-receipt"></i> <span class="float-left" style="margin-left: 18%">Taxa de Entrega</span>
										<ol class="float-right">
												<button onclick="viewNewTaxa()" class="btn btn-raised btn-info" id="btnNewProduct"><i class="fa fa-plus-circle"></i>&nbsp; Taxa</button>
										</ol>
									</div>
									<div class="card-body">
										<table class="table table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Título / Bairros</th>
											  <th scope="col">Preço</th>
											  <th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$select = "SELECT * FROM produtos WHERE categoria = 999 ORDER BY id ASC";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$id          = $data['id'];
														$bairros     = $data['nome'];
														$valor       = $data['preco'];
														$status      = $data['status'];

														switch ($status) {
															case 0:
																$action = "<a href='assets/functions/updateStatusTax.php?id=$id&status=1'>Ativar</a>";
																break;

															case 1:
																$action = "<a href='assets/functions/updateStatusTax.php?id=$id&status=0'>Desativar</a>";
																break;
														}

														echo "
															  <td>$bairros</td>
															  <td>$valor</td>

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

								<div class="card mb-3 animated fadeIn" id="frmNewMotoboy" style="display: none;">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-motorcycle"></i> <span class="float-left" style="margin-left: 18%">Adicionar Entregador</span>
										<ol class="float-right">
												<button onclick="hideNewMotoboy()" style="display: none;" class="btn btn-raised btn-secondary" id="btnCloseMotoboy"><i class="fa fa-times-circle"></i></button>
										</ol>
									</div>
									<div class="card-body">

										<form action="assets/functions/newMotoboy.php" name="newMotoboy" id="newMotoboy" method="post" enctype="multipart/form-data" style="margin-top: 30px;">

										<div class="row" style="padding-top: 15px">

											<div class="col-lg-6">
											<div class="form-group">
											<label>Nome</label>
											<select style="float: left; width: 100%" class="form-control select2" name="idMotoboy" id="idMotoboy">

											<?php

											$select = "SELECT id, celular, nome FROM usuarios";
											$result = $conexao -> prepare($select);
											$result->execute();
											$count = $result->rowCount();

											echo '<option value="">Selecione...</option>';

											if ($data = $result->fetch()) {
												do {

													$id      = $data['id'];
													$nome    = $data['nome'];
													$celular = $data['celular'];

													$nome = $nome;

													echo "<option value='$id'>$nome - $celular</option>";

												} while ($data = $result->fetch());
											}

											?>
											</select>
											</div>
											</div>

											<div class="col-lg-3">
											<div class="form-group">
											<label>Status</label>
											<select name="statusMotoboy" id="statusMotoboy" class="form-control" />
												<option selected value="1">Ativo</option>
												<option value="0">Inativo</option>
											</select>
											</div>
											</div>

											<div class="col-lg-3">
												<label>Valor da Taxa</label>
												<div class="input-group mb-2">
													<div class="input-group-prepend">
														<div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
													</div>
													<input type="text" class="form-control" name="valorTaxa" id="valorTaxa" placeholder="0,00">
												</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewMotoboy(){
												if (document.newMotoboy.idMotoboy.value == "" || document.newMotoboy.valorTaxa.value == ""){
													return false;
												} else {
													document.newMotoboy.submit();
													document.getElementById('cadMotoboy').style.visibility = 'hidden';
													document.getElementById('cadMotoboy').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewMotoboy()" id="cadMotoboy"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->

								<div class="card mb-3 animated fadeIn" id="listMotoboys">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-motorcycle"></i> <span class="float-left" style="margin-left: 18%">Entregadores</span>
										<ol class="float-right">
												<button onclick="viewNewMotoboy()" class="btn btn-raised btn-info" id="btnNewMotoboy"><i class="fa fa-plus-circle"></i>&nbsp; Motoboy</button>
										</ol>
									</div>
									<div class="card-body">
										<table class="table table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Motoboy</th>
											  <th scope="col">Taxa</th>
											  <th scope="col">Celular</th>
												<th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$select = "SELECT * FROM usuarios WHERE motoboy = 1 ORDER BY nome ASC";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$id      = $data['id'];
														$nome    = $data['nome'];
														$celular = $data['celular'];
														$status  = $data['motoboy'];
														$taxaMotoboy  = $data['taxaMotoboy'];

														switch ($status) {
															case 0:
																$action = "<a href='assets/functions/newMotoboy.php?id=$id&status=1'>Ativar</a>";
																break;

															case 1:
																$action = "<a href='assets/functions/newMotoboy.php?id=$id&status=0'>Desativar</a>";
																break;
														}

														echo "
															  <td>$nome</td>
															  <td>$taxaMotoboy</td>
															  <td>$celular</td>
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

	<div id="optEdit">
		<span class='dot_whats animated fadeInLeft'><i class="text-green-opacity fa fa-2x fa-motorcycle"></i></span>
	</div>

</div>
<!-- END main -->

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>

$(document).ready(function() {
    $('.select2').select2();
});
</script>

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
