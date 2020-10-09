<?

$landscape = "A4-L";

$html = '

<table class="table table-striped" id="tb1" style="margin-top: 15px">
  <thead>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Caixa</th>
    <th scope="col">Data</th>
    <th scope="col">Cliente</th>
    <th scope="col">Status</th>
    <th scope="col">Valor Total</th>
    <th scope="col">Valor Cobrado</th>
    <th scope="col">Pagamento</th>
  </tr>
  </thead>
  <tbody>

  ';

  $total = 0;

    if ($monthFilter != "") {
      $select = "SELECT
                  pedidos.id, pedidos.idCaixa, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                  usuarios.id as idCliente, usuarios.nome as nomeCliente,
                  endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
                 FROM pedidos
                 LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
                 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                 WHERE MONTH(caixa.dataHoraAbertura) = MONTH('$monthFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$monthFilter')
                 ORDER BY pedidos.id ASC";

                 $title = "Relatório de Pedidos - ".$monthFilterName."/".$monthFilterYear;

    } else if ($dateFilter != "") {
      $select = "SELECT
                  pedidos.id, pedidos.idCaixa, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                  usuarios.id as idCliente, usuarios.nome as nomeCliente,
                  endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
                 FROM pedidos
                 LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
                 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                 WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateFilter') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateFilter')
                 ORDER BY pedidos.id ASC";

                 $dateFilterPT = date("d/m/Y", strtotime($dateFilter));

                 $title = "Relatório de Pedidos - ".$dateFilterPT;
    } else {
      $select = "SELECT
                  pedidos.id, pedidos.idCaixa, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                  usuarios.id as idCliente, usuarios.nome as nomeCliente,
                  endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao
                 FROM pedidos
                 LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                 LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
                 LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                 ORDER BY pedidos.id ASC";

                 $title = "Relatório de Pedidos - Todo o Período";
    }
  $result = $conexao -> prepare($select);
  $result -> execute();
  $count = $result->rowCount();

    if ($data = $result -> fetch()) {
      do {

        $viewIdCliente  = $data['idCliente'];

        $idPedido       = $data['id'];
        $viewIdCaixa    = $data['idCaixa'];
        if ($viewIdCaixa == "") {
          $viewIdCaixa = 0;
        }
        $formaPagamento = $data['formaPagamento'];

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
            $class="badge badge-primary";
            break;

          case 2:
            $viewStatus = "Pedido confirmado";
            $class="badge badge-info";
            break;

          case 3:
            $viewStatus = "Em produção";
            $class="badge badge-info";
            break;

          case 4:
            $viewStatus = "Pronto para entrega";
            $class="badge badge-info";
            break;

          case 5:
            $viewStatus = "Pedido à caminho";
            $class="badge badge-info";
            break;

          case 6:
            $viewStatus = "Pedido Entregue";
            $class="badge badge-success";
            break;

        }

        $dataPedido     = $data['data_hora_cadastro'];
        $dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

        $valorTotal     = $data['valorTotal'];
        $valorCobrado   = $data['valorCobrado'];

        $valorCobrado = preg_replace('/[^0-9]+/','.',$valorCobrado);

        $total += $valorCobrado;

        $valorCobrado   = number_format($valorCobrado, 2, ',', '.');

        $nomeCliente    = $data['nomeCliente'];
        $rua            = $data['rua'];
        $numero         = $data['numero'];
        $bairro         = $data['bairro'];
        $complemento    = $data['complemento'];
        $descricao      = $data['descricao'];

        if ($status == 6) {
          $styleBtnReload = "display: none;";
        } else {
          $styleBtnReload = "display: block;";
        }

        $newStatus = $status + 1;

        $html.= "
          <tr>
            <td>$idPedido</td>
            <td>$viewIdCaixa</td>
            <td>$dataPedido</td>
            <td>$nomeCliente</td>
            <td>$viewStatus</td>
            <td>R$ $valorTotal</td>
            <td>R$ $valorCobrado</td>
            <td>$viewFormaPagamento</td>
          </tr>
        ";

      } while ($data = $result->fetch());
    }

    $total          = number_format($total, 2, ',', '.');

    $html.= "
      <tr>
        <td>Registros: $count</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>R$ $total</td>
        <td></td>
      </tr>
      ";

$html.= "
  </tbody>
</table>
";
