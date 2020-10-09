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

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

	function viewNewProduct() {
		document.getElementById('frmNewProduct').style.display = 'block';
		document.getElementById('btnClose').style.display = 'block';
		document.getElementById('listProducts').style.display = 'none';
		document.getElementById('btnNewProduct').style.display = 'none';
	}

</script>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

						<div class="row">
								<div class="col-xl-12">
										<div class="breadcrumb-holder">
												<h1 class="main-title float-left">Produtos</h1>
												<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">
														<button onclick="viewNewProduct()" class="btn btn-raised btn-info" id="btnNewProduct"><i class="fa fa-plus-circle"></i>&nbsp; Adicionar um produto</button>
														<button onclick="hideNewProduct()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i>&nbsp; Cancelar</button>
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

								<div class="card mb-3 animated fadeIn" id="frmNewProduct" style="display: none;">

									<div class="card-header">
										<h3 style="display: -webkit-inline-box;"><i class="fa fa-caret-right"></i> Adicionar um produto</h3>
									</div>
									<div class="card-body">

										<form action="assets/functions/newProduct.php" name="newProduct" id="newProduct" method="post" enctype="multipart/form-data">

										<div class="row">

											<div class="col-lg-3">

												<div id="banner_image">
													<center>
													<label for="upload">
																<img src="assets/images/picture2.png" class="animated fadeIn" id="banner" style="width: 100%; height: 150px; object-fit: cover;">
																<input type="file" id="upload" onchange="preview_image(event)" name="uploadBanner[]" style="display:none">
													</label>
												</center>

												<script type='text/javascript'>
													function preview_image(event) {
													 var reader = new FileReader();
													 reader.onload = function() {
														var output = document.getElementById('banner');
														document.getElementById('banner').style.width = '100%';
														document.getElementById('banner').style.height = '200px';
														output.src = reader.result;
													 }
													 reader.readAsDataURL(event.target.files[0]);
													}
												</script>

												</div>

											</div>

											<div class="col-lg-12">
											<div class="form-group">
											<label>Nome</label>
											<input type="text" class="form-control" autofocus="" name="nomeProduto" id="nomeProduto" required="">
											</div>
											</div>

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
											<label>Descrição</label>
											<textarea class="form-control editor" rows="3" name="descricao" id="descricao"></textarea>
											</div>
											</div>

										</div>

										<div class="row">

											<div class="col-auto">
									      <label>Preço</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="preco" id="preco" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-auto">
									      <label>Preço Promocional</label>
									      <div class="input-group mb-2">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fa fa-dollar-sign"></i></div>
									        </div>
									        <input type="text" class="form-control" name="precoPromo" id="precoPromo" placeholder="0,00">
									      </div>
									    </div>

											<div class="col-lg-3">
											<div class="form-group">
											<label>Categoria</label>
											<select class="form-control col-md-10 float-left" name="idCategoria" id="idCategoria">
												<option value="">Selecione...</option>
											<?php
												$select = "SELECT * FROM categorias ORDER BY nome ASC";
												$result = $conexao -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

												if ($data = $result->fetch()) {
													do {

														$idCategoria = $data['id'];
														$nome        = utf8_encode($data['nome']);

														echo "<option value='$idCategoria'>$nome</option>";

												} while($data = $result->fetch());
											}

											?>
											</select>
											</div>
											</div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewProduct(){
												if (document.newProduct.nomeProduto.value == ""){
													return false;
												} else {
													document.newProduct.submit();
													document.getElementById('cadProd').style.visibility = 'hidden';
													document.getElementById('cadProd').style.display = 'none';
													loading();
												}
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewProduct()" id="cadProd"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->


								<div class="card mb-3 animated fadeIn" id="listProducts">
									<div class="card-body">
										<table class="table table-responsive-xl table-striped" id="tb1">
										  <thead>
											<tr>
											  <th scope="col">Nome</th>
											  <th scope="col">Categoria</th>
											  <th scope="col">Preço</th>
											  <th scope="col">Preço Promocional</th>
											  <th scope="col"><center>Ações</center></th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$select = "SELECT * FROM produtos ORDER BY id ASC";
											$result = $conexao -> prepare($select);
											$result -> execute();
											$count = $result->rowCount();

												if ($data = $result -> fetch()) {
													do {

														$codigo      = $data['id'];
														$produto     = $data['nome'];
														$idCategoria = $data['categoria'];
														$banner      = $data['foto'];
														$preco       = $data['preco'];
														$precoPromo  = $data['precoPromo'];

														$selectCategoria = "SELECT * FROM categorias where id = '$idCategoria'";
														$resultCategoria = $conexao -> prepare($selectCategoria);
														$resultCategoria -> execute();
														$countCategoria = $resultCategoria->rowCount();

															if ($dataCategoria = $resultCategoria -> fetch()) {
																do {

																	$categoria = $dataCategoria['nome'];

																} while ($dataCategoria = $resultCategoria->fetch());
															}

														if($precoPromo == "") {
															$precoPromo = "-";
														}

														echo "
															  <td>
																	<img width='50' src='assets/uploads/banner/$banner'>
																	<a href=''>$produto</a>
																</td>
															  <td>$categoria</td>
															  <td>$preco</td>
															  <td>$precoPromo</td>

															  <td><center>

															  <a href='assets/functions/deleteRelatorio.php?idRel=$idRel&nomeRel=$titulo&nome=$singleNome' data-confirm='Deseja realmente excluir esse relatório?' data-title='Delete'><i class='fa fa-trash-alt' aria-hidden='true'></i> Excluir</a>

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
