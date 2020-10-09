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
	width: 6%;
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

						<div class="row" style="margin-top: 6%">

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 col-xl-12">

								<div class="card mb-3 animated fadeIn" id="listProducts">
									<div class="card-materialIcon" style="font-size: 18px;">
										<i class="materialIconGreen fa fa-qrcode"></i> <span class="float-right">Gerador de QR Code</span>
									</div>
									<div class="card-body">

										<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&amp;display=swap" rel="stylesheet">
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

										.whats {
											font-family: 'Inter', sans-serif;
											font-size: 32px;
											margin-left: 20px;
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
														            $novo = substr_replace($novo, '9', 3, 0);
														            $novo = substr_replace($novo, ') ', 3, 0);
														        }else{
														            $novo = substr_replace($numero, '(', 0, 0);
														            $novo = substr_replace($novo, ') ', 3, 0);
														        }
														        return $novo;
														    }

														?>

													<h6 class="whats"><i class="fab fa-whatsapp"></i>&nbsp; <? echo formataWhats($whatsapp) ?></h6>
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
										  top: 50%;
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
