<?php

		include('../includes/conexao.php');

		date_default_timezone_set('America/Brasilia');
		$dateTime = date('d/m/Y H:i');
		$date     = date('Y-m-d H:i');
		$time     = date('H:i');
		$day      = date('d');
		$year     = date('Y');
		$month    = date('m');

		$typeReport  = $_GET['typeReport'];
		$dateFilter  = $_GET['dateFilter'];
		$monthFilter = $_GET['dateMonth'];

		$singleMonthFilter = date("m", strtotime($monthFilter));
		$monthFilterYear   = date("Y", strtotime($monthFilter));

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

		switch ($singleMonthFilter) {
			case 1:
				$monthFilterName = "Janeiro";
				break;
			case 2:
				$monthFilterName = "Fevereiro";
				break;
			case 3:
				$monthFilterName = "Março";
				break;
			case 4:
				$monthFilterName = "Abril";
				break;
			case 5:
				$monthFilterName = "Maio";
				break;
			case 6:
				$monthFilterName = "Junho";
				break;
			case 7:
				$monthFilterName = "Julho";
				break;
			case 8:
				$monthFilterName = "Agosto";
				break;
			case 9:
				$monthFilterName = "Setembro";
				break;
			case 10:
				$monthFilterName = "Outubro";
				break;
			case 11:
				$monthFilterName = "Novembro";
				break;
			case 12:
				$monthFilterName = "Dezembro";
		}

		$stylesheet = "

		.table {
		padding-top: 4%;
		}

		table {
    width: 100%;
    margin-bottom: 1rem;
		}
		thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
		}
		tbody {
		    display: table-row-group;
		    vertical-align: middle;
		    border-color: inherit;
		}
		.table-striped tbody tr:nth-of-type(odd) {
		    background-color: rgba(0,0,0,.05);
		}
		td {
    display: table-cell;
    vertical-align: inherit;
		}
		.table td, .table th {
			text-align: left;
    padding: .75rem;
    vertical-align: center;
    border-top: 1px solid #dee2e6;
		}
		.id {
			width: 10px;
		}
		";


		//definimos uma constante com o nome da pasta
		define('MPDF_PATH', '../plugins/pdf/MPDF57/');
		//incluimos o arquivo
		include(MPDF_PATH.'mpdf.php');

		switch ($typeReport) {

			case 'request':
				require('searchReportRequest.php');
				break;

			case 'financeRequest':
				require('searchReportRequest.php');
				break;

			case 'financeInput':
				require('searchReportInput.php');
				break;

			case 'financeOutput':
				require('searchReportOutput.php');
				break;

			case 'financeOutDrawer':
				require('searchReportOutDrawer.php');
				break;

			case 'motoboy':
				require('searchReportMotoboy.php');
				break;
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

		date_default_timezone_set('America/Sao_Paulo');
		//criamos uma variavel e colocamos nela tudo que desejamos que nosso pdf contenha
		//instanciamos nossa classe mPDF
		$mpdf=new mPDF('UTF-8',$landscape,9, 'roboto', '15','15','30','18');
		//definimos o tipo de exibicao
		$mpdf->setTitle($title);
		$mpdf->SetDisplayMode('fullpage');
		//definimos estilos de fonts
		$mpdf->useOnlyCoreFonts = false;
		$mpdf->watermark_font = 'Roboto';
		//definimos se vamos exibir a marca d'agua
		$mpdf->showWatermarkText = false;
		$mpdf->SetWatermarkText('');
		$mpdf->SetHTMLHeader('<h2 style="float: left; display: inline-flex; width: 80%; padding-top: 3%">'.$title.'<br><p style="font-size: 12px">{PAGENO}/{nb}</p></h2><img src="../uploads/sistema/'.$logo_sistema.'" width="90px" style="float: right; display: inline-flex">', 200);
		//colocamos um icone de logo tipo no pdf
		//$mpdf->SetWatermarkImage('../uploads/sistema/'.$logo_sistema, 1, array(22, 22), array(175,10));
		//definimos se sera exibido ou nao o logo no pdf
		$mpdf->showWatermarkImage = true;
		//escrve o titulo de nosso pdf
		//definimos oque vai conter no rodape do pdf
		$mpdf->SetFooter($day.'/'.$monthname.'/'.$year.' '.$time.'||Pagina {PAGENO}/{nb}');
		//e finalmente escrevemos todo nosso conteudo no pdf para exibir
		$mpdf->WriteHTML($stylesheet, 1);
		$mpdf->WriteHTML($html, 2);
		//fechamos nossa instancia ao pdf
		$mpdf->Output($title.'.pdf', 'I');
		//pausamos a tela para exibir oque foi feito
		exit();
?>
