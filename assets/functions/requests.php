<?php

include("../includes/conexao.php");

date_default_timezone_set('America/Brasilia');
$dateTime      = date('d/m/Y H:i:s');
$date          = date('Y-m-d H:i:s');

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

		$logo_sistema       = $data_configActual['logo_sistema'];

	} while ($data_configActual = $result->fetch());
}

$select = "SELECT * FROM caixa WHERE status = 1 ORDER BY id DESC LIMIT 1";
$result = $conexao -> prepare($select);
$result->execute();
$countCaixa = $result->rowCount();

if ($data = $result -> fetch()) {
	do {

		$idCaixa = $data['id'];

		setCookie('idCaixa', $idCaixa, time() + ( 60 * 60 * 24 * 30 ), '/sistemaDelivery');

	} while ($data = $result -> fetch());
}

echo "
  <div>
    <img src='assets/uploads/sistema/$logo_sistema' style='width: 5%; float: left'><h3 style='color: #fff; padding-top: 1.5%; margin-left: 5.5%'>$dateTime</h3>
  </div>
";

if ($countCaixa != "") {
$select = "SELECT
            pedidos.id, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.data_hora_cadastro, pedidos.data_hora_atualizacao,
            usuarios.id as idCliente, usuarios.nome as nomeCliente,
            endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
           FROM pedidos
           INNER JOIN usuarios ON pedidos.idCliente = usuarios.id
           INNER JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
           LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
           WHERE pedidos.idCaixa = '$idCaixa'
           ORDER BY pedidos.id DESC";
}
$result = $conexao -> prepare($select);
$result -> execute();
$count = $result->rowCount();

$comanda = $count;

  if ($data = $result -> fetch()) {
    do {

      $viewIdPedido   = $data['id'];
      $idPedido       = $data['id'];
      $formaPagamento = $data['formaPagamento'];
      $celular        = $data['celular'];

      switch ($formaPagamento) {
        case 1:
          $viewFormaPagamento = "Dinheiro";
          break;

        case 2:
          $viewFormaPagamento = "Cartão";
          break;

        case 3:
          $viewFormaPagamento = "Dinheiro e Cartão";
          break;
      }

      $status         = $data['status'];

      switch ($status) {
        case 1:
          $viewStatus = "Pedido realizado";
          $style = "background-color: #03a9f4; color: #fff;";
          $titulo = "color: #fff;";
          break;

        case 2:
          $viewStatus = "Pedido confirmado";
          $style = "background-color: #03a9f4; color: #fff;";
          $titulo = "color: #fff;";
          break;

        case 3:
          $viewStatus = "Em produção";
          $style = "background-color: #03a9f4; color: #fff;";
          $titulo = "color: #fff;";
          break;

        case 4:
          $viewStatus = "Pronto para entrega";
          $style = "background-color: #03a9f4; color: #fff;";
          $titulo = "color: #fff;";
          break;

        case 5:
          $viewStatus = "Pedido à caminho";
          $style = "background-color: #03a9f4; color: #fff;";
          $titulo = "color: #fff;";
          break;

        case 6:
          $viewStatus = "Pedido Entregue";
          $style = "background-color: green; color: #fff;";
          $titulo = "color: #fff;";
          break;

      }

      $data1 = $data['data_hora_cadastro'];
      $data2 = $data['data_hora_atualizacao'];

      $dataPedido     = $data['data_hora_cadastro'];
      $dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

      $dataPedido = strtotime($data1);
      $agora = time();

      $calculo = $agora - $dataPedido;
      $duracao = (int)($calculo / 60);

      if (($status == 1 || $status == 2 || $status == 3) && $duracao > 30) {
        $style = "background-color: #ffd600; color: #fff;";
        $titulo = "color: #fff;";
      }

      if (($status == 1 || $status == 2 || $status == 3) && $duracao > 45) {
        $style = "background-color: #d50000; color: #fff;";
        $titulo = "color: #fff;";
      }


      if ($status == 4 || $status == 5 || $status == 6) {
        $dataAtualizacao = strtotime($data2);
        $calculo = $dataAtualizacao - $dataPedido;
        $duracao = (int)($calculo / 60);
      }

      $dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

      $valorTotal     = $data['valorTotal'];

      $nomeCliente    = $data['nomeCliente'];
      $primeiroNomeCliente = explode(" ", $nomeCliente);
      $nomeCliente = $primeiroNomeCliente[0];
      $rua            = $data['rua'];
      $numero         = $data['numero'];
      $bairro         = $data['bairro'];
      $complemento    = $data['complemento'];
      $descricao      = $data['descricao'];

      $enderecoCompleto = "Rua ".$rua.", n°. ".$numero.", bairro ".$bairro;

      if ($complemento != "") {
        $viewComplemento = $complemento;
      }
      if ($descricao != "") {
        $viewDescricao = "<br>Obs.: ".$descricao;
      }

?>
<div class="col-lg-3" style="display: inline-block; width: 24%; padding-right: 0">

  <div class="card mb-3" id="frmNewProduct" style="<?php echo $style; ?>">

    <div class="card-header">
      <h3 style="display: -webkit-inline-box; <?php echo $titulo; ?>"><?php echo $nomeCliente." - ".$viewStatus; ?></h3>
    </div>
    <div class="card-body">

      <form action="assets/functions/newProduct.php" name="newProduct" id="newProduct" method="post" enctype="multipart/form-data">

      <div class="row" id="info">

        <div class="col-lg-12">
        <div class="form-group" style="margin-bottom: 0;">

        <?php

          $selectProduto = "SELECT
                            produtos.id, produtos.nome, produtos.descricao, produtos.foto, produtos.preco,
                            pedido_itens.quantidade, pedido_itens.observacao
                            FROM produtos
                            INNER JOIN pedido_itens ON produtos.id = pedido_itens.idProduto
                            WHERE pedido_itens.idPedido = '$idPedido' and produtos.categoria != 999
                            ORDER BY produtos.id ASC";
          $resultProduto = $conexao -> prepare($selectProduto);
          $resultProduto -> execute();
          $countProduto = $resultProduto->rowCount();

            if ($dataProduto = $resultProduto -> fetch()) {
              do {

                $qtdProduto  = $dataProduto['quantidade'];
                $idProduto   = $dataProduto['id'];
                $observacao  = $dataProduto['observacao'];
                if ($observacao != "") {
                  $observacao = "Obs.: ".$observacao;
                }
                $nome        = $dataProduto['nome'];
                $descricao   = $dataProduto['descricao'];
                $banner      = $dataProduto['foto'];
                $preco       = $dataProduto['preco'];
                $precoPromo  = $dataProduto['precoPromo'];

                if ($preco == "") {
                  $preco = "Em Breve";
                }

                if ($precoPromo != "") {
                  $stylePreco = "text-decoration: line-through;";
                }

                echo "
                <div class='col-lg-9' style='float: left;  padding: 0'>
                  <h6 style='display: inline-block;'>".$qtdProduto."x ".$nome."</br>".$observacao."</h6>
                </div>
                ";

            } while ($dataProduto = $resultProduto->fetch());
          }
          echo "
          <div class='col-lg-3' style='float: right; text-align: right; padding: 0'>
            <h2>$comanda</h2>
            <h5 style='margin-bottom: 0;'>$duracao min</h5>
          </div>

          ";

        ?>
        </div>
        </div>

      </div>

    </form>


    </div>
    <!-- end card-body -->

  </div>
  <!-- end card -->

</div>
<?php

  $comanda--;

  } while ($data = $result->fetch());
} else {
  echo "
    <div style='width: 100%; text-align: center!important; margin-left: -13px; margin-top: 20%'>
      <h1 style='margin-top: 15px; color: #fff!important;'><i class='fas fa-spinner fa-pulse'></i> Aguardando Pedidos</h1>
    </div>
  ";
}
?>
