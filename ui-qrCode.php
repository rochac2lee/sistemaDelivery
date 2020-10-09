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

										<?

								    //set it to writable location, a place for temp generated PNG files
								    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrCode/temp'.DIRECTORY_SEPARATOR;

								    //html PNG location prefix
								    $PNG_WEB_DIR = 'qrCode/temp/';

								    include "qrCode/qrlib.php";

										//ofcourse we need rights to create temp dir
								    if (!file_exists($PNG_TEMP_DIR))
								        mkdir($PNG_TEMP_DIR);


								    $filename = $PNG_TEMP_DIR.'test.png';

								    //processing form input
								    //remember to sanitize user input in real-life solution !!!
								    $errorCorrectionLevel = 'H';
								    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
								        $errorCorrectionLevel = $_REQUEST['level'];

								    $matrixPointSize = 5;
								    if (isset($_REQUEST['size']))
								        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


								    if (isset($_REQUEST['titulo'])) {
											$text = $_REQUEST['titulo'];

								        //it's very important!
								        if (trim($_REQUEST['data']) == '')
								            die('data cannot be empty! <a href="?">back</a>');

								        // user data
								        $filename = $PNG_TEMP_DIR.''.$text.'.png';
								        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

								    }

										if (isset($_REQUEST['empresa'])) {
												$idEmpresa = $_REQUEST['empresa'];
												$filename = $text.'.png';

												$conexaoDelivery->exec("UPDATE clientes_encode SET qrCode = '$filename' WHERE id = '$idEmpresa'" );
										}

								    //display generated file
								    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';

								    //config form
								    echo '
										<form action="ui-qrCode.php" method="post">
										<div class="row">

										<div class="col-lg-2">
										<div class="form-group">
										<label>Selecione a Empresa</label>
										<select name="empresa" class="form-control" required />
											<option value="">Selecione...</option>
										';

										$select = "SELECT	id, empresa
																	FROM clientes_encode
																	WHERE status = 1 order by empresa ASC";

										$result = $conexaoDelivery -> prepare($select);
										$result -> execute();

										if ($data = $result->fetch()) {
											do {
												$viewIdEmpresa = $data['id'];
												$viewEmpresa   = $data['empresa'];
												echo '<option value="'.$viewIdEmpresa.'">'.$viewEmpresa.'</option>';
											} while ($data = $result->fetch());
										} else {
												echo '<option value="'.$idEmpresaAtual.'">'.$empresaAtual.'</option>';
										}

										echo '
										</select>
										</div>
										</div>

										<div class="col-md-2">
										<div class="form-group">
											<label>Nome do Arquivo:</label>
											<input name="titulo" class="form-control" value="'.(isset($_REQUEST['titulo'])?htmlspecialchars($_REQUEST['titulo']):'encode').'" />&nbsp;
										</div>
										</div>

												<div class="col-md-2">
												<div class="form-group">
													<label>Informação:</label>
													<input name="data" class="form-control" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'encode.dev.br').'" />&nbsp;
												</div>
												</div>

												<div class="col-md-2">
												<div class="form-group">
												<label>ECC:</label>
												<select class="form-control" name="level">
								            <option value="L"'.(($errorCorrectionLevel=='L')?' selected':'').'>L - smallest</option>
								            <option value="M"'.(($errorCorrectionLevel=='M')?' selected':'').'>M</option>
								            <option value="Q"'.(($errorCorrectionLevel=='Q')?' selected':'').'>Q</option>
								            <option value="H"'.(($errorCorrectionLevel=='H')?' selected':'').'>H - best</option>
								        </select>
												</div>
												</div>

												<div class="col-md-2">
												<div class="form-group">
												<label>Tamanho:</label>
								        <select class="form-control" name="size">
												';

								    for($i=1;$i<=10;$i++)
								        echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';

								    echo '
												</select>
												</div>
												</div>

											</div>

											<div class="modal-footer">
												<input class="btn btn-success" type="submit" value="Gerar QR Code">
											</div>

								      </form>';

								    // benchmark
								    //QRtools::timeBenchmark();

									?>

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
