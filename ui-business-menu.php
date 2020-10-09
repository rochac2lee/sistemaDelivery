<?php

require('assets/includes/session.php');

$nomeEmpresa = preg_replace('/[ -]+/' , '' , $empresaAtual);
$nomeEmpresa = strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($nomeEmpresa)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"), "aaaaeeiooouuncAAAAEEIOOOUUNC-")) );

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

.iframe {
	width: 45.5%;
  border-radius: 25px;
  display: block;
  position: sticky;
  border: 0;
  height: 96%;
  margin-top: 6%;
  margin-left: 30.5%;
  overflow: hidden;
}
.mobile {
	text-align: center;
	position: absolute;
	width: 100%;
	height: 680px;
	display: block;
}
</style>

<script type="text/javascript">

	function loading() {
		document.getElementById('loading').style.display = 'block';
	}

</script>

<style>

.sidenav {
  height: 100%;
  width: 0%;
  position: fixed;
  z-index: 1;
  top: 40px;
	background-color: var(--corSecundaria)!important;
  right: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.closebtn {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.closebtn:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">

				<div id="mySidenav" class="sidenav">
				  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

					<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&amp;display=swap" rel="stylesheet">
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
					<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>

					<style>

					.background {
						background: <?php echo $corPrincipal ?>;
						color: <?php echo $corTexto ?>;
						font-family: Inter;
						padding: 15px;
						border-left: 15px solid var(--corSecundaria);
						border-left-style: groove;
						width: 1000px;
					}

					.background:before {
						background: url("assets/uploads/sistema/<?php echo $logo_sistema; ?>");
						color: <?php echo $corTexto ?>;
						font-family: Inter;
						padding: 15px;
					}

					.qrCode {
						float: right;
						width: 90%;
					}

					.logo {
						width: 100%;
					}

					.nomeEmpresa {
						font-family: 'Inter', sans-serif;
						font-size: 40px;
						display: inline-block;
						padding-left: 5px;
						color: <?php echo $corTexto2 ?>;
					}

					.categoria {
						font-family: 'Inter', sans-serif;
						font-size: 36px;
						display: inline-block;
						padding-left: 5px;
						color: <?php echo $corTexto ?>;
					}

					hr {
					    margin-top: 1rem;
					    margin-bottom: 1rem;
					    border: 0;
					    border-top: 1px solid var(--corSecundaria);
					}

					.whats {
						font-family: 'Inter', sans-serif;
						font-size: 32px;
						margin-left: 20px;
						line-height: 1.5em;
					}

					</style>

					<div id="html-content-holder" class="background">
						<div class="row">
							<div class="col-md-3">
								<img class="logo" src="assets/uploads/sistema/<?php echo $logo_sistema; ?>">
							</div>
							<div class="col-md-9" style="margin-top: 3%;">
								<strong>
									<h5 class="nomeEmpresa"><? echo $nome_empresa ?></h5>
								</strong>
								<br>
								<p class="categoria"><? echo $tipoNegocio ?></p>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-md-9">
								<? if ($endereco_site != "") { ?>
								<h6 class="whats"><i class="fa fa-globe-americas"></i>&nbsp; <? echo $endereco_site ?></h6>
								<? } ?>
								<? if ($whatsapp != "") {
									function formataWhats($numero){
													if(strlen($numero) == 10){
															$novo = substr_replace($numero, '(', 0, 0);
															$novo = substr_replace($novo, '', 3, 0);
															$novo = substr_replace($novo, ') ', 3, 0);
													}else{
															$novo = substr_replace($numero, '(', 0, 0);
															$novo = substr_replace($novo, ') ', 3, 0);
													}
													return $novo;
											}

									?>

								<h6 class="whats"><i class="fab fa-whatsapp"></i>&nbsp; <? echo $whatsMask; ?></h6>
								<? } ?>
							</div>

							<div class="col-md-3">
								<img class="qrCode" src="qrCode/temp/<?php echo $qrCodeEmpresa; ?>">
							</div>
						 </div>
					</div>

					<style>
					.container {
						position: relative;
						opacity: 1;
						width: 50%;
						max-width: none;
					}

					.image {
						opacity: 1;
						display: block;
						width: 100%;
						height: auto;
						transition: .5s ease;
						backface-visibility: hidden;
					}

					.middle {
						transition: .5s ease;
						opacity: 0;
						position: absolute;
						top: 55%;
						left: 50%;
						transform: translate(-50%, -50%);
						-ms-transform: translate(-50%, -50%)
					}

					.container:hover .image {
						opacity: 0.3;
					}

					.container:hover .middle {
						opacity: 1;
					}

					.text {
						background-color: #4CAF50;
						color: white;
						font-size: 16px;
						padding: 16px 32px;
					}
					</style>

					<div class="container">
						<h2 style="text-align:center; color: var(--corTexto2)">Seu cartão está pronto!</h2>
						<h4 style="text-align:center; margin-bottom: 15px; color: var(--corTexto)">Dica: Ao indicar sua empresa, mostre seu cartão digital.</h4>
						<div class="image">
							<div id="previewImage"></div>
						</div>

						<div class="middle">
							<a id="btn-Convert-Html2Image" class="btn btn-raised btn-lg btn-success animated fadeIn" href="#">
								<i class="fa fa-cloud-download-alt"></i>&nbsp; Baixar
							</a>
						</div>
					</div>

					<script>
						$(document).ready(function() {

							document.getElementById("mySidenav").style.width = "80%";
							document.getElementById("html-content-holder").style.display = "block";

							// Global variable
							var element = $("#html-content-holder");

							// Global variable
							var getCanvas;

							function carregaImagem() {
								html2canvas(element, {
									onrendered: function(canvas) {
										$("#previewImage").append(canvas);
										canvas.setAttribute("id", "cardCompany");
										getCanvas = canvas;
									}
								});
								document.getElementById("mySidenav").style.width = "0%";
								document.getElementById("html-content-holder").style.display = "none";
							};
							carregaImagem();

							$("#btn-Convert-Html2Image").on('click', function() {
								var imgageData =
									getCanvas.toDataURL("image/png");

								// Now browser starts downloading
								// it instead of just showing it
								var newData = imgageData.replace(
								/^data:image\/png/, "data:application/octet-stream");

								$("#btn-Convert-Html2Image").attr(
								"download", "card.png").attr(
								"href", newData);
							});
						});
					</script>

				</div>

				<script>
				function openNav() {
				  document.getElementById("mySidenav").style.width = "90%";
				}

				function closeNav() {
				  document.getElementById("mySidenav").style.width = "0";
				}
				</script>

				<span style="font-size:30px;cursor:pointer; float: right" onclick="openNav()">&#9776;</span>

						<div class="row" style="margin-top: 6%">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="frmNewProduct">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-mobile"></i> <span class="float-left" style="margin-left: 18%">Configurações</span>
										<ol class="float-right">
												<button onclick="hideNewTaxa()" style="display: none;" class="btn btn-raised btn-secondary" id="btnClose"><i class="fa fa-times-circle"></i></button>
										</ol>
									</div>
									<div class="card-body">

										<form action="assets/functions/uploadBannerCompanyMenu.php?idEmpresa=<?php echo $idEmpresa ?>&tipo=1" name="newBanner" id="newBanner" method="post" enctype="multipart/form-data">

										<div class="row" style="padding-top: 15px">

											<div class="col-md-12" style="margin-bottom: 40px;">
												<h6>Banner do Cabeçalho</h6>
												<label>Envie uma imagem para o topo do seu cardápio</label>

												<div id="banner_image" style="text-align: center">
													<label for="upload">
																<img src="https://img.icons8.com/clouds/2x/upload.png" onchange="verificaNewBanner()" class="animated fadeIn" id="banner" style="width: 180px; height: 130px; object-fit: cover; cursor: pointer;">
																<input type="file" multiple id="upload" onchange="preview_image(event)" name="uploadBanner[]" style="display:none">
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

												</div>

												<hr>

												<div class="row">

												<?
												$select = "SELECT * FROM uploads where idClienteEncode = '$idEmpresaAtual' and tipo = 1 order by id ASC";
												$result = $conexaoDelivery -> prepare($select);
												$result -> execute();
												$count = $result->rowCount();

													if ($data = $result -> fetch()) {
														do {

															$id     = $data['id'];
															$url    = "assets/uploads/banner/";
															$imagem = $data['arquivo'];

															$imagem = $url.$imagem;

															echo "
															<div class='card col-sm-6' style='padding: 0; margin-bottom: 5px'>
																<div class='card-body' style='padding: 0'>
																	<a data-fancybox='gallery' href='$imagem'>
																		<img alt='image' src='$imagem' class='img-fluid'>
																		<div class='card-footer' style='padding: 0.75rem 0.50rem;'>
																			<a href='assets/functions/deleteBanner.php?id=$id' data-confirm='Deseja realmente excluir esse cliente?' class='btn btn-danger btn-sm right' data-placement='top' data-toggle='tooltip' data-title='Delete'><i class='fa fa-trash-alt'></i></a>
																			<div class='clearfix'></div>
																		</div>
																	</a>
																</div>
															</div>

															";

														} while ($data = $result -> fetch());
													}

												?>

												</div>


											</div>

										</div>

										<div class="modal-footer">

											<script type="text/javascript">
											function verificaNewBanner(){
												document.newBanner.submit();
												document.getElementById('cadBanner').style.visibility = 'hidden';
												document.getElementById('cadBanner').style.display = 'none';
												loading();
											}
											</script>
											<button type="button" class="btn btn-success" onclick="verificaNewBanner()" id="cadBanner"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									<form action="assets/functions/updateWhatsapp.php?idEmpresa=<?php echo $idEmpresa ?>" name="newWhats" id="newWhats" method="post">

										<div class="row">

											<div class="col-lg-12">
												<h6>Atendimento pelo Whatsapp</h6>
												<label>Informe um número de atendimento</label>
									      <div class="input-group mb-2 col-md-6" style="padding-left: 0">
									        <div class="input-group-prepend">
									          <div class="input-group-text"><i class="fab fa-whatsapp"></i></div>
									        </div>

									        <input type="text" class="form-control" onkeyup="removeEspecialCharacter()" name="whats2" value="<?php echo $whatsapp; ?>" id="whats2">
													<input type="text" class="form-control display-none" name="whats" value="" id="whats">
									      </div>
									    </div>

										</div> <!-- end row -->

										<div class="modal-footer">

											<script type="text/javascript">
											function setWhats(){
													document.newWhats.submit();
													document.getElementById('cadWhats').style.visibility = 'hidden';
													document.getElementById('cadWhats').style.display = 'none';
													loading();
											}
											function removeEspecialCharacter() {
												var x = document.getElementById('whats2').value;
												x = x.replace(/[- )(]/g,'');

												document.getElementById('whats').value = x;
											}
											</script>
											<button type="button" class="btn btn-success" onclick="setWhats()" id="cadWhats"><i class="fa fa-save"></i>&nbsp; Salvar</button>
										</div>

									</form>

									</div>
									<!-- end card-body -->

								</div>
								<!-- end card -->
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-6">

								<div class="card mb-3 animated fadeIn" id="listMotoboys">
									<div class="card-materialIcon" style="font-size: 18px;">
										<img class="materialIconGreen" src="qrcode/temp/<? echo $qrCodeEmpresa ?>" style="width: 20%;"> <span class="float-right">Seu Cardápio</span>
									</div>
									<div class="card-body" style="height: 680px; text-align: center!important">

										<img class="mobile" src="assets/images/mobile.png">

										<iframe class="iframe" src="../cardapio/<? echo $nomeEmpresa ?>/index.php?zoom=80"></iframe>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

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
		$("#whats2").inputmask("(99) 9999-9999");
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
           title: "Exclusão de Imagem",
           text: "Deseja realmente excluir essa Imagem?",
           icon: "warning",
           buttons: true,
           dangerMode: true
         })
         .then((willDelete) => {
           if (willDelete) {
             swal("Pronto! Imagem excluída com sucesso!", {
               icon: "success",
             });
             window.location.href = link;
           }
         });
});

</script>
<!-- END Java Script for this page -->

</body>
</html>
