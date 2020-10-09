<?php

		include('assets/includes/conexao.php');

		//definimos uma constante com o nome da pasta
		define('MPDF_PATH', 'assets/plugins/pdf/MPDF57/');
		//incluimos o arquivo
		include(MPDF_PATH.'mpdf.php');
		//definimos o timezone para pegar a hora local
		date_default_timezone_set('America/Sao_Paulo');
		//criamos uma variavel e colocamos nela tudo que desejamos que nosso pdf contenha
		$html = "Ol&aacute; mundo";
		//instanciamos nossa classe mPDF
		$mpdf=new mPDF();
		//definimos o tipo de exibicao
		$mpdf->SetDisplayMode('fullpage');
		//definimos estilos de fonts
		$mpdf->useOnlyCoreFonts = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		//definimos se vamos exibir a marca d'agua
		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('');
		//colocamos um icone de logo tipo no pdf
		$mpdf->SetWatermarkImage('../../uploads/sistema/encode.png', 1, '', array(140,10));
		//definimos se sera exibido ou nao o logo no pdf
		$mpdf->showWatermarkImage = true;
		//escrve o titulo de nosso pdf
		$mpdf->WriteHTML('<br/><h1>Relatório</h1><hr/>');
		//definimos oque vai conter no rodape do pdf
		$mpdf->SetFooter('{DATE j/m/Y  H:i}||Pagina {PAGENO}/{nb}');
		//e finalmente escrevemos todo nosso conteudo no pdf para exibir
		$mpdf->WriteHTML($html);
		//fechamos nossa instancia ao pdf
		$mpdf->Output();
		//pausamos a tela para exibir oque foi feito
		exit();
?>
