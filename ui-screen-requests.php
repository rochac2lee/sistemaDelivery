<?php

include('assets/includes/conexao.php');

date_default_timezone_set('America/Brasilia');
$dateTime = date('d/m/Y H:i');
$day      = date('d');
$year     = date('Y');
$month    = date('m');

	switch ($month) {
		case 1:
			$monthname = "Janeiro";
			break;
		case 2:
			$monthname = "Fevereiro";
			break;
		case 3:
			$monthname = "Março";
			break;
		case 4:
			$monthname = "Abril";
			break;
		case 5:
			$monthname = "Maio";
			break;
		case 6:
			$monthname = "Junho";
			break;
		case 7:
			$monthname = "Julho";
			break;
		case 8:
			$monthname = "Agosto";
			break;
		case 9:
			$monthname = "Setembro";
			break;
		case 10:
			$monthname = "Outubro";
			break;
		case 11:
			$monthname = "Novembro";
			break;
		case 12:
			$monthname = "Dezembro";
	}

require('assets/includes/logout.php');

	$selectConfigActual = "SELECT
							titulo_site,
							SEO_meta_titulo,
							SEO_meta_descricao,
							SEO_meta_keywords,
							SEO_meta_autor,
							conteudo_pagina,
							conteudo_rodape,
							endereco_site,
							analytics_codigo,
							logo_sistema,
							logo_login,
							nome_empresa,
							cnpj,
							telefone,
							linkedin,
							endereco_completo,
							descricao_sistema,
							versao_sistema,
							data_criacao,
							data_atualizacao
						FROM
							configs
						ORDER BY id_config DESC LIMIT 1
						";
	$result = $conexao -> prepare($selectConfigActual);
	$result -> execute();
	$countUsersActual = $result->rowCount();

	if ($data_configActual = $result->fetch()) {
		do {

			$titulo_site        = $data_configActual['titulo_site'];
			$SEO_meta_titulo    = $data_configActual['SEO_meta_titulo'];
			$SEO_meta_descricao = $data_configActual['SEO_meta_descricao'];
			$SEO_meta_keywords  = $data_configActual['SEO_meta_keywords'];
			$SEO_meta_autor     = $data_configActual['SEO_meta_autor'];
			$conteudo_pagina    = $data_configActual['conteudo_pagina'];
			$conteudo_rodape    = $data_configActual['conteudo_rodape'];
			$endereco_site      = $data_configActual['endereco_site'];
			$analytics_codigo   = $data_configActual['analytics_codigo'];
			$logo_sistema       = $data_configActual['logo_sistema'];
			$logo_login         = $data_configActual['logo_login'];
			$nome_empresa       = $data_configActual['nome_empresa'];
			$cnpj_empresa       = $data_configActual['cnpj'];
			$telefone_empresa   = $data_configActual['telefone'];
			$linkedin_empresa   = $data_configActual['linkedin'];
			$endereco_completo  = $data_configActual['endereco_completo'];
			$descricao_sistema  = $data_configActual['descricao_sistema'];
			$versao_sistema     = $data_configActual['versao_sistema'];
			$data_criacao       = $data_configActual['data_criacao'];
			$data_atualizacao   = $data_configActual['data_atualizacao'];

		} while ($data_configActual = $result->fetch());
	}

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody" onload="searchRequests()" style="background: url(assets/images/pattern.png); background-size: contain">

<script type="text/javascript">

	function CriaRequest() {
	 try{
		 request = new XMLHttpRequest();
	 }catch (IEAtual){

		 try{
			 request = new ActiveXObject("Msxml2.XMLHTTP");
		 }catch(IEAntigo){

			 try{
				 request = new ActiveXObject("Microsoft.XMLHTTP");
			 }catch(falha){
				 request = false;
			 }
		 }
	 }

	 if (!request)
		 alert("Seu Navegador não suporta Ajax!");
	 else
		 return request;
	}

	</script>

<style>
.content-page {
    margin-left: 0px;
    overflow: hidden;
}
</style>

<div id="main">

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

					<script>
					function searchRequests() {

					 var result = document.getElementById("viewRequests");
					 var xmlreq = CriaRequest();

					 // Iniciar uma requisição
					 xmlreq.open("GET", "assets/functions/requests.php", true);
					 setTimeout(searchRequests, 1000);

					 // Atribui uma função para ser executada sempre que houver uma mudança de ado
					 xmlreq.onreadystatechange = function(){

						 // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
						 if (xmlreq.readyState == 4) {

							 // Verifica se o arquivo foi encontrado com sucesso
							 if (xmlreq.status == 200) {

								 result.innerHTML = xmlreq.responseText;
								 document.getElementById("viewRequests").value = result.innerHTML;
							 }else{
								 result.innerHTML = "Erro: " + xmlreq.statusText;
							 }
						 }
					 };
					 xmlreq.send(null);
					}

					</script>

					<div id="viewRequests" style="margin-left: 2%; max-width: 100%"></div>

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

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
