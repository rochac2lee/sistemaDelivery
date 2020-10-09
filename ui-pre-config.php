<?php

$config = false;
$step = $_GET['step'];

require('assets/includes/session.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php')?>

<input type="text" id="step" style="display: none" value="<?php echo $step; ?>">

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

							<div class="row">
								<div class="col-xl-12">
									<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Seja Bem Vindo, <?php echo $singleNome; ?>!</h1>
										<ol class="breadcrumb float-right">
										<li class="breadcrumb-item">Home</li>
										<li class="breadcrumb-item active">Configurações</li>
										</ol>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							<!-- end row -->

							<div class="row">

								<div class="animated fadeInLeft col-xl-5" style="background-color: #e0e0e0;">
									<center><img src="assetS/images/EncodeLG.png" style="width: 40%"></center>

									<h1 style="text-align: center; margin-bottom: 40px; font-weight: 600;">Seu negócio<br>mais informatizado!</h1>
									<h1 style="text-align: center; margin-bottom: 20px;">Fácil. Inteligente. Online.</h1>
									<h3 style="margin: 0 12% 8% 12%;">
										<i class="fa fa-caret-right"></i> Gestão de Pedidos<br>
										<i class="fa fa-caret-right"></i> Abertura/Fechamento do Caixa<br>
										<i class="fa fa-caret-right"></i> Tela de Pedidos para Cozinha<br>
										<i class="fa fa-caret-right"></i> Controle de Motoboys<br>
										<i class="fa fa-caret-right"></i> Contas a Pagar/Receber<br>
										e muito mais!</h3>
								</div>
								<div class="animated fadeInRight col-xl-7" id="step1">

									<form action="assets/functions/updateInfoConfigs.php?step=1" method="post" enctype="multipart/form-data">

									<div class="card mb-3" style="margin-top: 22px">
										<div class="card-materialIcon" style="font-size: 18px;">
											<i class="materialIconGreen fa fa-info-circle"></i> <span class="float-right">Dados da Empresa</span>
										</div>
										<!-- end card-header -->

										<div class="card-body">

											<div class="row">

												<div class="form-group col-md-12">
												<label>Nome da Empresa</label>
												<input class="form-control" name="nome_empresa" type="text" value="<?php echo $nome_empresa ?>">
												</div>

											</div>

											<div class="row">

                        <div class="form-group col-md-4">
												<label>Tipo de Negócio</label>
												<select class="form-control" name="tipo_negocio" id="tipo_negocio" type="text">
                          <option value="">Selecione...</option>
                          <?
                          $select = "SELECT * FROM tipos_negocio WHERE status = 1 ORDER BY tipoNegocio ASC";
                          $result = $conexaoDelivery -> prepare($select);
                          $result -> execute();
                          $count = $result->rowCount();

                          if ($data = $result -> fetch()) {
                            do {

                              $idTipoNegocio = $data["id"];
                              $tipoNegocio   = $data["tipoNegocio"];

                              if ($empresaTipoNegocio == $idTipoNegocio) {
                                echo "<option selected value='$idTipoNegocio'>$tipoNegocio</option>";
                              } else {
                                echo "<option value='$idTipoNegocio'>$tipoNegocio</option>";
                              }

                            } while ($data = $result->fetch());
    											}
                        ?>
                        </select>
												</div>

												<div class="form-group col-md-4">
												<label>CNPJ</label>
												<input class="form-control" name="cnpj_empresa" id="cnpj" type="text" value="<?php echo $cnpj_empresa ?>">
												</div>

												<div class="form-group col-md-4">
												<label>Site</label>
												<input class="form-control" name="endereco_site" type="text" value="<?php echo $endereco_site ?>">
												</div>

												<div class="form-group col-md-6">
												<label>Telefone</label>
												<input type="text" style="padding: 3px;" class="form-control" name="telefone_empresa" id="telefone" value="<?php echo $telefone_empresa ?>">
												</div>

												<div class="form-group col-md-6">
												<label>Linkedin</label>
												<input type="text" style="padding: 3px;" class="form-control" name="linkedin_empresa" value="<?php echo $linkedin_empresa ?>">
												</div>

											</div>

											<div class="form-group" style="float:right;">
											<button type="submit" id="next" class="btn btn-primary">Próximo &nbsp;<i class="fa fa-angle-right"></i></button>
											</div>

										</div>
										<!-- end card-body -->

									</div>
									<!-- end card -->

									</form>

								</div>
								<!-- end col -->

								<div class="animated fadeInRight col-xl-7" id="step2">

									<form action="assets/functions/updateInfoConfigs.php?step=2" method="post" enctype="multipart/form-data">

									<div class="card mb-3" style="margin-top: 22px">
										<div class="card-materialIcon" style="font-size: 18px;">
											<i class="materialIconGreen fa fa-cog"></i> <span class="float-right">Dados do Sistema</span>
										</div>
										<!-- end card-header -->

										<div class="card-body">

												<div class="row">

														<div class="form-group col-lg-12">

															<label>Logo da sua Empresa</label>

															<center>
															<div id="banner_image">
																<label for="upload">
																			<img src="assets/images/picture2.png" class="animated fadeIn" id="banner" style="width: 100%; height: 150px; object-fit: cover;">
																			<input type="file" id="upload" onchange="preview_image(event)" name="uploadBanner[]" style="display:none">
																</label>

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
															</center>
														</div>
													</div>

													<div class="clearfix"><div>


												</div>

												<div class="row">

													<div class="form-group col-md-3">
														<label>Cor Principal</label>
														<div id="cpPrincipal" class="input-group colorpicker-component" title="Using format option">
														  <input class="form-control input-lg" name="corPrincipal" id="corPrincipal" type="text" value="<?php echo $corPrincipal ?>">
														  <span class="input-group-addon"><i></i></span>
														</div>
														<script>
														  $(function () {
															$('#cpPrincipal').colorpicker({
															  format: null
															});
														  });
														</script>
													</div>

													<div class="form-group col-md-3">
														<label>Cor Secundária</label>
														<div id="cpSecundaria" class="input-group colorpicker-component" title="Using format option">
														  <input class="form-control input-lg" name="corSecundaria" id="corSecundaria" type="text" value="<?php echo $corSecundaria ?>">
														  <span class="input-group-addon"><i></i></span>
														</div>
														<script>
														  $(function () {
															$('#cpSecundaria').colorpicker({
															  format: null
															});
														  });
														</script>
													</div>

												</div>

												<div class="row">

													<div class="form-group col-md-3">
														<label>Cor Sidebar Menu</label>
														<div id="cpSidebarMenu" class="input-group colorpicker-component" title="Using format option">
														  <input class="form-control input-lg" name="corSidebarMenu" id="corSidebarMenu" type="text" value="<?php echo $corSidebarMenu ?>">
														  <span class="input-group-addon"><i></i></span>
														</div>
														<script>
														  $(function () {
															$('#cpSidebarMenu').colorpicker({
															  format: null
															});
														  });
														</script>
													</div>

													<div class="form-group col-md-3">
														<label>Cor Sidebar Submenu</label>
														<div id="cpSidebarSubMenu" class="input-group colorpicker-component" title="Using format option">
														  <input class="form-control input-lg" name="corSidebarSubMenu" id="corSidebarSubMenu" type="text" value="<?php echo $corSidebarSubMenu ?>">
														  <span class="input-group-addon"><i></i></span>
														</div>
														<script>
														  $(function () {
															$('#cpSidebarSubMenu').colorpicker({
															  format: null
															});
														  });
														</script>
													</div>

												</div>

												<div class="form-group" style="float:right;">
												<button type="submit" id="saveSettings" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Salvar</button>
												</div>

										</div>
										<!-- end card-body -->

									</div>
									<!-- end card -->

									</form>

								</div>
								<!-- end col -->

							</div>
							<!-- end row -->


							<script>
							var step = document.getElementById('step').value;
							function step1() {
								document.getElementById('step1').style.display = "block";
								document.getElementById('step2').style.display = "none";
							}
							function step2() {
								document.getElementById('step1').style.display = "none";
								document.getElementById('step2').style.display = "block";
							}
							if (step == 1) {
								step1();
							}
							if (step == 2) {
								step2();
							} else {
								step1();
							}
							</script>


            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

</div>
<!-- END main -->

<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/moment.min.js"></script>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="assets/js/pikeadmin.js"></script>

<script src="assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- BEGIN Java Script for this page -->
<script src="assets/plugins/trumbowyg/trumbowyg.min.js"></script>
<script src="assets/plugins/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
<script>
$(document).ready(function () {
    'use strict';
	$('.editor').trumbowyg();
});
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

$(document).ready(function(){

	$('#saveSettings').click(function(){
       swal("Bom Trabalho!", "Configurações salvas com sucesso!", "success");

    });

});
</script>

<script>
$(document).ready(function(){
  $("#cnpj").inputmask("99.999.999/9999-99");
  $("#telefone").inputmask("(99) 99999-9999");
  $("#celular").inputmask("(99) 99999-9999");
});
</script>

<!-- END Java Script for this page -->

</body>
</html>
