<?php

require('assets/includes/session.php');

?>
<!DOCTYPE html>
<html lang="en">
<?php require('assets/includes/head.php')?>

<body class="adminbody">

<div id="main">

<?php require('assets/includes/menu.php')?>

    <div class="content-page">

		<!-- Start content -->
        <div class="content">

			<div class="container-fluid">


							<div class="row">
								<div class="col-xl-12">
									<div class="breadcrumb-holder">
										<h1 class="main-title float-left">Configurações</h1>
										<ol class="breadcrumb float-right">
										<li class="breadcrumb-item">Home</li>
										<li class="breadcrumb-item active">Configurações</li>
										</ol>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							<!-- end row -->

							<form action="assets/functions/updateInfoConfigs.php?nome=<?php echo $singleNome ?>" method="post" enctype="multipart/form-data">

							<div class="row">

								<div class="col-md-6">

									<div class="card mb-3 animated fadeIn">
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

												<div class="form-group display-none">
												<label>Mensagem da Tela Inicial</label>
												<textarea rows="3" class="form-control editor" name="conteudo_pagina"><?php echo $conteudo_pagina ?></textarea>
												</div>

												<div class="form-group display-none">
												<label>Rodapé do Sistema</label>
												<textarea rows="3" class="form-control editor" name="conteudo_rodape"><?php echo $conteudo_rodape ?></textarea>
												</div>

												<div class="form-group display-none">
												<label>Analytics</label>
												<textarea rows="4" class="form-control" name="analytics_codigo"><?php echo $analytics_codigo ?></textarea>
												</div>

										</div>
										<!-- end card-body -->

									</div>
									<!-- end card -->

                  <div class="card mb-3 animated fadeIn" style="margin-top: 8%">
										<div class="card-materialIcon" style="font-size: 18px;">
											<i class="materialIconGreen fa fa-cog"></i> <span class="float-right">Dados do Sistema</span>
										</div>
										<!-- end card-header -->

										<div class="card-body">

												<div class="row">

                          <div class="col-md-6">
													<div class="form-group">
													<label>Nome do Sistema</label>
													<input class="form-control" name="titulo_site" type="text" value="<?php echo $titulo_site ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>Versão</label>
													<input type="text" class="form-control" name="versao_sistema" value="<?php echo $versao_sistema ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>SEO meta título</label>
													<input type="text" class="form-control" name="SEO_meta_titulo" value="<?php echo $SEO_meta_titulo ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>SEO meta descrição</label>
													<input type="text" class="form-control" name="SEO_meta_descricao" value="<?php echo $SEO_meta_descricao ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>SEO meta keywords</label>
													<input type="text" class="form-control" name="SEO_meta_keywords" value="<?php echo $SEO_meta_keywords ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>SEO meta autor</label>
													<input type="text" class="form-control" name="SEO_meta_autor" value="<?php echo $SEO_meta_autor ?>">
													</div>
													</div>

                          <div class="col-md-6">
													<div class="form-group">
													<label>Data de Criação</label>
													<input type="datetime-local" class="form-control" name="data_criacao" value="<?php echo $data_criacao ?>">
													</div>
													</div>

													<div class="col-md-6">
													<div class="form-group">
													<label>Data da Última Atualização</label>
													<input type="datetime-local" class="form-control" name="data_atualizacao" value="<?php echo $data_atualizacao ?>">
													</div>
													</div>

                          <div class="col-md-12">
													<div class="form-group">
													<label>Sobre</label>
													<textarea class="form-control" name="descricao_sistema"><?php echo $descricao_sistema ?></textarea>
													</div>
													</div>

											</div>

										</div>
										<!-- end card-body -->

									</div>
									<!-- end card -->

								</div>
								<!-- end col -->

                <div class="col-md-6">

                  <div class="card mb-3 animated fadeIn">
										<div class="card-materialIcon" style="font-size: 18px;">
											<i class="materialIconGreen fa fa-paint-brush"></i> <span class="float-right">Layout</span>
										</div>
										<!-- end card-header -->

										<div class="card-body">

												<div class="row">

                          <div class="col-md-12" style="margin-bottom: 40px; background-color: var(--corSecundaria)">

    												<div id="banner_image">
    													<center>
    													<label for="upload">
    																<img src="assets/uploads/sistema/<? echo $logo_sistema ?>" class="animated fadeIn" id="banner" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;">
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

                          <?


                          $viewTema = $_GET['tema'];
                          if($viewTema != "") {
                            $select = "SELECT * FROM cores WHERE id = '$viewTema'";
                            $result = $conexaoDelivery -> prepare($select);
                            $result -> execute();

                            if ($data = $result -> fetch()) {
                              do {

                                $id       		  		= $data['id'];
                                $tema       				= $data['tema'];
                                $temaPrincipal			= $data['corPrincipal'];
                          			$temaTexto   				= $data['corTexto'];
                          			$temaSecundaria			= $data['corSecundaria'];
                          			$temaSidebarMenu		= $data['corSidebarMenu'];
                          			$temaSidebarSubMenu = $data['corSidebarSubMenu'];

                                if ($viewTema != "") {
                                  $corPrincipal      = $temaPrincipal;
                                  $corTexto          = $temaTexto;
                                  $corSecundaria     = $temaSecundaria;
                                  $corSidebarMenu    = $temaSidebarMenu;
                                  $corSidebarSubMenu = $temaSidebarSubMenu;

                                  echo "

                                  <style>
                                  	:root {
                                  		--corPrincipal: $corPrincipal;
                                  		--corTexto: $corTexto;
                                  		--corSecundaria: $corSecundaria;
                                  		--corSidebarMenu: $corSidebarMenu;
                                  		--corSidebarSubMenu: $corSidebarSubMenu;
                                  	}
                                  </style>

                                  ";
                                }

                              } while ($data = $result -> fetch());
                        		}

                            $select = "SELECT * FROM cores ORDER BY tema ASC";
                            $result = $conexaoDelivery -> prepare($select);
                            $result -> execute();

                            echo '
                            <div class="form-group col-md-3">
  														<label>Temas</label>
                              <select name="tema" id="tema" class="form-control" />
                              <option value="">Selecione...</option>
                            ';

                              if ($data = $result -> fetch()) {
                                do {

                                  $id       		  		= $data['id'];
                                  $tema       				= $data['tema'];

                                  if($viewTema == $id) {
                                    echo "
                                      <option selected value='$id'>$tema</option>
                                    ";
                                  } else {
                                    echo "
                                      <option value='$id'>$tema</option>
                                    ";
                                  }

                                } while ($data = $result -> fetch());
                          		}

                          echo '
  									          </select>
  													</div>
                          ';

                        } else {
                          $select = "SELECT * FROM cores ORDER BY tema ASC";
                          $result = $conexaoDelivery -> prepare($select);
                          $result -> execute();

                          echo '
                          <div class="form-group col-md-3">
														<label>Temas</label>
                            <select name="tema" id="tema" class="form-control" />
                            <option value="">Selecione...</option>
                          ';

                            if ($data = $result -> fetch()) {
                              do {

                                $id       		  		= $data['id'];
                                $tema       				= $data['tema'];

                                if($temaAtual == $id) {
                                  echo "
                                    <option selected value='$id'>$tema</option>
                                  ";
                                } else {
                                  echo "
                                    <option value='$id'>$tema</option>
                                  ";
                                }

                              } while ($data = $result -> fetch());
                        		}

                        echo '
									          </select>
													</div>
                        ';
                        }



                        ?>

                        <script>
                        $(document).ready(function() {
                          $("#tema").change(function() {

                            var tema = $("#tema");
                            var temaPost = tema.val();

                            window.location.href = "ui-settings.php?tema=" + temaPost;

                          });
                        });
                        </script>

													<div class="form-group col-md-3">
														<label>Cor Principal</label>
														  <input class="form-control display-none" name="corPrincipal" id="corPrincipal" value="<? echo $corPrincipal ?>" type="text">
														  <input class="form-control" name="viewCorPrincipal" id="viewCorPrincipal" type="text">
													</div>

                          <div class="form-group col-md-3">
														<label>Cor Texto Primário</label>
														  <input class="form-control display-none" name="corTexto" id="corTexto" value="<? echo $corTexto ?>" type="text">
														  <input class="form-control" name="viewCorTexto" id="viewCorTexto" type="text">
													</div>

                          <div class="form-group col-md-3">
														<label>Cor Texto Secundário</label>
														  <input class="form-control display-none" name="corTexto2" id="corTexto2" value="<? echo $corTexto2 ?>" type="text">
														  <input class="form-control" name="viewCorTexto2" id="viewCorTexto2" type="text">
													</div>

													<div class="form-group col-md-3">
														<label>Cor Secundária</label>
														  <input class="form-control display-none" name="corSecundaria" id="corSecundaria" value="<? echo $corSecundaria ?>" type="text">
														  <input class="form-control" name="viewCorSecundaria" id="viewCorSecundaria" type="text">
													</div>

													<div class="form-group col-md-3">
														<label>Cor Sidebar Menu</label>
														  <input class="form-control display-none" name="corSidebarMenu" id="corSidebarMenu" value="<? echo $corSidebarMenu ?>" type="text">
														  <input class="form-control" name="viewCorSidebarMenu" id="viewCorSidebarMenu" type="text">
													</div>

													<div class="form-group col-md-3">
														<label>Cor Sidebar Submenu</label>
														  <input class="form-control display-none" name="corSidebarSubMenu" value="<? echo $corSidebarSubMenu ?>" id="corSidebarSubMenu" type="text">
														  <input class="form-control" name="viewCorSidebarMenu" id="viewCorSidebarSubMenu" type="text">
													</div>

												</div>

                        <div class="form-group right">
												  <button type="button" onclick="deleteOldConfig()" class="btn btn-danger"><i class="fa fa-sync-alt"></i>&nbsp; Reverter</button>
												  <button type="submit" id="saveSettings" class="btn btn-success"><i class="fa fa-check"></i>&nbsp; Atualizar Informações</button>
												</div>

										</div>
										<!-- end card-body -->

									</div>
									<!-- end card -->

								</div>

							</div>
							<!-- end row -->

							</form>

            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

    </div>
	<!-- END content-page -->

</div>
<!-- END main -->

<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>
<script>

const viewCorPrincipal = Pickr.create({
  el: '#viewCorPrincipal',
  theme: 'classic',
  defaultRepresentation: 'HEX',
  default: '<? echo $corPrincipal ?>',

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: true,
          save: true
      }
  },
  // Translations, these are the default values.
      i18n: {

          // Strings visible in the UI
         'ui:dialog': 'color picker dialog',
         'btn:toggle': 'toggle color picker dialog',
         'btn:swatch': 'color swatch',
         'btn:last-color': 'use previous color',
         'btn:save': 'Salvar',
         'btn:cancel': 'Cancel',
         'btn:clear': 'Limpar',

         // Strings used for aria-labels
         'aria:btn:save': 'save and close',
         'aria:btn:cancel': 'cancel and close',
         'aria:btn:clear': 'clear and close',
         'aria:input': 'color input field',
         'aria:palette': 'color selection area',
         'aria:hue': 'hue selection slider',
         'aria:opacity': 'selection slider'
      }
});

viewCorPrincipal.on('change', (color) => {
    document.getElementById('corPrincipal').value = color.toHEXA();
});

/* ------------------------------------- */

const viewCorTexto = Pickr.create({
  el: '#viewCorTexto',
  theme: 'classic',
  defaultRepresentation: 'HEX',
  default: '<? echo $corTexto ?>',

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: true,
          save: true
      }
  },
  // Translations, these are the default values.
      i18n: {

          // Strings visible in the UI
         'ui:dialog': 'color picker dialog',
         'btn:toggle': 'toggle color picker dialog',
         'btn:swatch': 'color swatch',
         'btn:last-color': 'use previous color',
         'btn:save': 'Salvar',
         'btn:cancel': 'Cancel',
         'btn:clear': 'Limpar',

         // Strings used for aria-labels
         'aria:btn:save': 'save and close',
         'aria:btn:cancel': 'cancel and close',
         'aria:btn:clear': 'clear and close',
         'aria:input': 'color input field',
         'aria:palette': 'color selection area',
         'aria:hue': 'hue selection slider',
         'aria:opacity': 'selection slider'
      }
});

viewCorTexto.on('change', (color) => {
    document.getElementById('corTexto').value = color.toHEXA();
});

/* ------------------------------------- */

const viewCorTexto2 = Pickr.create({
  el: '#viewCorTexto2',
  theme: 'classic',
  defaultRepresentation: 'HEX',
  default: '<? echo $corTexto2 ?>',

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: true,
          save: true
      }
  },
  // Translations, these are the default values.
      i18n: {

          // Strings visible in the UI
         'ui:dialog': 'color picker dialog',
         'btn:toggle': 'toggle color picker dialog',
         'btn:swatch': 'color swatch',
         'btn:last-color': 'use previous color',
         'btn:save': 'Salvar',
         'btn:cancel': 'Cancel',
         'btn:clear': 'Limpar',

         // Strings used for aria-labels
         'aria:btn:save': 'save and close',
         'aria:btn:cancel': 'cancel and close',
         'aria:btn:clear': 'clear and close',
         'aria:input': 'color input field',
         'aria:palette': 'color selection area',
         'aria:hue': 'hue selection slider',
         'aria:opacity': 'selection slider'
      }
});

viewCorTexto2.on('change', (color) => {
    document.getElementById('corTexto2').value = color.toHEXA();
});

/* ------------------------------------- */

const viewCorSecundaria = Pickr.create({
  el: '#viewCorSecundaria',
  theme: 'classic',
  defaultRepresentation: 'HEX',
  default: '<? echo $corSecundaria ?>',

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: true,
          save: true
      }
  },
  // Translations, these are the default values.
      i18n: {

          // Strings visible in the UI
         'ui:dialog': 'color picker dialog',
         'btn:toggle': 'toggle color picker dialog',
         'btn:swatch': 'color swatch',
         'btn:last-color': 'use previous color',
         'btn:save': 'Salvar',
         'btn:cancel': 'Cancel',
         'btn:clear': 'Limpar',

         // Strings used for aria-labels
         'aria:btn:save': 'save and close',
         'aria:btn:cancel': 'cancel and close',
         'aria:btn:clear': 'clear and close',
         'aria:input': 'color input field',
         'aria:palette': 'color selection area',
         'aria:hue': 'hue selection slider',
         'aria:opacity': 'selection slider'
      }
});

viewCorSecundaria.on('change', (color) => {
    document.getElementById('corSecundaria').value = color.toHEXA();
});

/* ------------------------------------- */

const viewCorSidebarMenu = Pickr.create({
  el: '#viewCorSidebarMenu',
  theme: 'classic',
  defaultRepresentation: 'HEX',
  default: '<? echo $corSidebarMenu ?>',

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: false,
          hsla: false,
          hsva: false,
          cmyk: false,
          input: true,
          clear: true,
          save: true
      }
  },
  // Translations, these are the default values.
      i18n: {

          // Strings visible in the UI
         'ui:dialog': 'color picker dialog',
         'btn:toggle': 'toggle color picker dialog',
         'btn:swatch': 'color swatch',
         'btn:last-color': 'use previous color',
         'btn:save': 'Salvar',
         'btn:cancel': 'Cancel',
         'btn:clear': 'Limpar',

         // Strings used for aria-labels
         'aria:btn:save': 'save and close',
         'aria:btn:cancel': 'cancel and close',
         'aria:btn:clear': 'clear and close',
         'aria:input': 'color input field',
         'aria:palette': 'color selection area',
         'aria:hue': 'hue selection slider',
         'aria:opacity': 'selection slider'
      }
});

/* ------------------------------------- */

viewCorSidebarMenu.on('change', (color) => {
    document.getElementById('corSidebarMenu').value = color.toHEXA();
});

  const viewCorSidebarSubMenu = Pickr.create({
    el: '#viewCorSidebarSubMenu',
    theme: 'classic',
    defaultRepresentation: 'HEX',
    default: '<? echo $corSidebarSubMenu ?>',

    components: {

        // Main components
        preview: true,
        opacity: true,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: false,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: true,
            save: true
        }
    },
    // Translations, these are the default values.
        i18n: {

            // Strings visible in the UI
           'ui:dialog': 'color picker dialog',
           'btn:toggle': 'toggle color picker dialog',
           'btn:swatch': 'color swatch',
           'btn:last-color': 'use previous color',
           'btn:save': 'Salvar',
           'btn:cancel': 'Cancel',
           'btn:clear': 'Limpar',

           // Strings used for aria-labels
           'aria:btn:save': 'save and close',
           'aria:btn:cancel': 'cancel and close',
           'aria:btn:clear': 'clear and close',
           'aria:input': 'color input field',
           'aria:palette': 'color selection area',
           'aria:hue': 'hue selection slider',
           'aria:opacity': 'selection slider'
        }
});

viewCorSidebarSubMenu.on('change', (color) => {
    document.getElementById('corSidebarSubMenu').value = color.toHEXA();
});


</script>
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
<script>
$(document).ready(function () {
    'use strict';
	$('.editor').trumbowyg();
});
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

function deleteOldConfig() {
	swal({
			 title: "Configuração Anterior",
			 text: "Deseja realmente voltar a configuração anterior?",
			 icon: "warning",
			 buttons: true,
			 dangerMode: true
		 })
		 .then((willDelete) => {
			 if (willDelete) {
				 swal("Pronto!", {
					 icon: "success",
				 });
				 window.location.href = "assets/functions/deleteOldConfig.php";
			 }
		 });
}

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
