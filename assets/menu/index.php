<?php

ob_start();
session_start();
require('../../../config_sites.php');
if (!isset($_SESSION['usuario_pwcimbessul']) && (!isset($_SESSION['senha_pwcimbessul']))){
  header("Location: ../../"); exit;
}

try {
  $conexao = new PDO('mysql:host=localhost;dbname=SIG', 'root', 'cim123');
  $conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo 'Houve um Erro na conexao com o banco de dados: ' . $e -> getMessage();
}

$email = $_SESSION['usuario_pwcimbessul'];
$senha = $_SESSION['senha_pwcimbessul'];

include('../includes/logout.php');

// pega o IP do usuário
$ip = $_SERVER['REMOTE_ADDR'];

date_default_timezone_set('America/Brasilia');
$dateTime = date('d/m/Y H:i');
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
              tb_configs
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
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>SIG CIMBESSUL</title>

  <link rel='shortcut icon' type='image/x-icon' href='../images/favicon.ico' />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>

  <!-- Bootstrap CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <link rel="stylesheet" href="css/style.css">


  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

</head>

<body style="    height: -webkit-fill-available;
    background: url(http://backgroundcheckall.com/wp-content/uploads/2017/12/ppt-background-themes-hd-4.jpg);
    background-size: cover;
    min-height: 550px;" class="animated fadeIn adminbody" onload="">

<style>
.content-page {
    margin-left: 0px;
    overflow: hidden;
}
.col-xl-2 {
  margin: 0px 15px 0px 15px;
  color: #0d47a1;
  background: #fff;
  border: 0;
}

i {
  font-size: 36px;
  padding-top: 10px;
  padding-bottom: 10px;
}
.card-body {
  text-align: center!important;
}
</style>

<script>
$(document).ready(function() {
  $(".serv-0").click(function() {
    window.location.href = "../../index.php?mod=financial"; //Financeiro
  });
  $(".serv-1").click(function() {
    window.location.href = "../../index.php?mod=warehouse"; //Almoxarifado
  });
  $(".serv-2").click(function() {
    window.location.href = "../../index.php?mod=product_stock"; //Estoque
  });
  $(".serv-3").click(function() {
    window.location.href = "../../index.php?mod=hr"; //Recursos Humanos
  });
  $(".serv-4").click(function() {
    window.location.href = "../../index.php?mod=it"; //Seg. Pat.
  });
  $(".serv-5").click(function() {
    window.location.href = "../../index.php?mod=security"; //Seg. Pat.
  });
  $(".serv-6").click(function() {
    window.location.href = "../../index.php?mod=work_safety"; //Seguraça do Trabalho
  });
  $(".serv-7").click(function() {
    window.location.href = "../../index.php?mod=upkeep"; //Manutenção
  });
  $(".serv-8").click(function() {
    window.location.href = "../../index.php?mod=supervisor"; //Gestão
  });
  $(".serv-9").click(function() {
    window.location.href = "../../index.php?mod=manager"; //Gestão
  });
});
</script>

    <div id="main">

        <div class="content-page">
            <div class="content">
        			  <div class="container">

        								<div class="col-xl-12">

                          <img src="logo_sig.png" style="width: 35%; margin-top: 5%; margin-left: 10px;" />

                          <div class="row d-flex justify-content-center" style="margin-top: 30px">

          								   <div class="serv-0 btn btn-primary card mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-dollar-sign"></i>
                                 <h6>Financeiro</h6>
                               </div>
                             </div>
                             <div class="serv-1 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-archive"></i>
                                 <h6>Almoxarifado</h6>
                               </div>
                             </div>
                             <div class="serv-2 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-box-open"></i>
                                 <h6>Estoque</h6>
                               </div>
                             </div>
                             <div class="serv-3 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-users-cog"></i>
                                 <h6>RH</h6>
                               </div>
                             </div>
                             <div class="serv-4 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-laptop"></i>
                                 <h6>TI</h6>
                               </div>
                             </div>
                        </div>

                        <div class="row d-flex justify-content-center" style="margin-top: 15px">
          								   <div class="serv-5 btn btn-primary card mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-shield-alt"></i>
                                 <h6>Seg. Patrimonial</h6>
                               </div>
                             </div>
                             <div class="serv-6 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-hard-hat"></i>
                                 <h6>SESMT</h6>
                               </div>
                             </div>
                             <div class="serv-7 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-tools"></i>
                                 <h6>Manutenção</h6>
                               </div>
                             </div>
                             <div class="serv-8 btn btn-primary card  mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-file-invoice-dollar"></i>
                                 <h6>Fiscal</h6>
                               </div>
                             </div>
                             <div class="serv-9 btn btn-primary card mb-3 col-xl-2">
                               <div class="card-body">
                                 <i class="fa fa-toolbox"></i>
                                 <h6>Gestão</h6>
                               </div>
                             </div>

                             <div class="card-body" style="display: none; cursor: pointer; width: 10%; flex: 0;" onclick="window.location.href='?sairMenu'">
                               <i class="fa fa-door-open"></i>
                               <h6>Sair</h6>
                             </div>

                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>

<script src="../js/bootstrap.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js'></script>

</div>
<!-- END main -->

</body>

</html>

<?php

  if(isset($_REQUEST['sair'])){

date_default_timezone_set('America/Brasilia');
$dateTime = date('d/m/Y H:i');

  $usuario = $_SESSION['usuario_pwcimbessul'];
  $senha   = $_SESSION['senha_pwcimbessul'];

    $selectLogin = "SELECT nome_completo, id_usuario from tb_usuarios WHERE email='$usuario'";

    $resultLogin = $conexao -> prepare($selectLogin);
    $resultLogin -> execute();
    $countLogin = $resultLogin->rowCount();

    if ($data_login = $resultLogin->fetch()) {
      do {

        $allNomeLogin   = $data_login['nome_completo'];
        $idUsuarioLogin = $data_login['id_usuario'];
        $single         = explode(" ", $allNomeLogin);
        $nome           = $single[0];

        $conexao->beginTransaction();

        $conexao->exec("INSERT INTO tb_log (tipo_evento, id_usuario, evento, data_hora, id_log)
                VALUES('Logout', '$idUsuarioLogin', '$nome saiu do sistema', '$dateTime', '')" );

          $conexao->exec("DELETE FROM online WHERE ip = '$ip'");

        $conexao->commit();

      } while ($data_login = $resultLogin->fetch());
    }

    session_destroy();
    session_unset($_SESSION['usuario_pwcimbessul']);
    session_unset($_SESSION['senha_pwcimbessul']);
    header("Location: login");
  }

?>
