<?php
include("../includes/conexao.php");

$selectConfigActual = "SELECT
            titulo_site,
            status,
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
            tema,
            corPrincipal,
            corTexto,
            corSecundaria,
            corSidebarMenu,
            corSidebarSubMenu,
            nome_empresa,
            idTipoNegocio,
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
    $statusSistema      = $data_configActual['status'];
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
    $temaAtual  				= $data_configActual['tema'];
    $corPrincipal				= $data_configActual['corPrincipal'];
    $corTexto   				= $data_configActual['corTexto'];
    $corSecundaria			= $data_configActual['corSecundaria'];
    $corSidebarMenu			= $data_configActual['corSidebarMenu'];
    $corSidebarSubMenu  = $data_configActual['corSidebarSubMenu'];
    $nome_empresa       = $data_configActual['nome_empresa'];
    $empresaTipoNegocio = $data_configActual['idTipoNegocio'];
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
<html>

<head>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&amp;display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js">
	</script>
</head>

<style>

.background {
  background-color: <?php echo $corPrincipal ?>;
  color: <?php echo $corTexto ?>;
  font-family: Inter;
  padding: 15px;
}
.col-md-6 {
  width: 48%;
  display: inline-block;
}

.row {
  margin-right: -10px;
  margin-left: -10px;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}

.qrCode {
  float: right;
  width: 50%;
}

.logo {
  width: 50%;
}

</style>

<body>

	<div id="html-content-holder" class="background" style="width: 400px;">

		<strong>
			<? echo $empresaAtual ?>
		</strong>

		<hr/>

    <div class="row">
      <div class="col-md-6">
    		<h3 style="color: #3e4b51;">
    			ABOUT US
    		</h3>
        <img class="logo" src="../uploads/sistema/<?php echo $logo_sistema; ?>">
      </div>

      <div class="col-md-6">
    		<img class="qrCode" src="../../qrCode/temp/<?php echo $qrCodeEmpresa; ?>">
      </div>
	   </div>
	</div>

	<input id="btn-Preview-Image" type="button"
				value="Preview" />

	<a id="btn-Convert-Html2Image" href="#">
		Download
	</a>

	<br/>

	<h3>Preview :</h3>

	<div id="previewImage"></div>

	<script>
		$(document).ready(function() {

			// Global variable
			var element = $("#html-content-holder");

			// Global variable
			var getCanvas;

			$("#btn-Preview-Image").on('click', function() {
				html2canvas(element, {
					onrendered: function(canvas) {
						$("#previewImage").append(canvas);
						getCanvas = canvas;
					}
				});
			});

			$("#btn-Convert-Html2Image").on('click', function() {
				var imgageData =
					getCanvas.toDataURL("image/png");

				// Now browser starts downloading
				// it instead of just showing it
				var newData = imgageData.replace(
				/^data:image\/png/, "data:application/octet-stream");

				$("#btn-Convert-Html2Image").attr(
				"download", "GeeksForGeeks.png").attr(
				"href", newData);
			});
		});
	</script>
</body>

</html>
