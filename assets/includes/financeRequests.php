<?php

$dateFilter = $_GET['dateFilter'];
$dateMonth  = $_GET['dateMonth'];

?>

<div class="card mb-3 animated fadeIn">
  <div class="card-body">

    <h5 class="card-title">Pedidos</h5>

    <div class="row" style="display: inline-flex; width: 90%;">
      <div class="col-lg-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
          </div>
          <input type="date" class="form-control" onchange="filterRequest()" style="width: 80%; border-left: 0;" value="<?php echo $dateFilter; ?>" id="dateFilter">
        </div>
      </div>

      <div class="col-lg-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
          </div>
          <input type="month" class="form-control" onchange="monthRequest()" style="width: 10%; border-left: 0;" value="<?php echo $dateMonth; ?>" id="dateMonth">
        </div>
      </div>

      <?php if ($dateFilter != "" || $dateMonth) {?>
      <button class="btn btn-outline-secondary" onclick="clearFilter()" style="border: solid 3px #ced4da;" type="button"><i class="fa fa-times"></i></button>
      <?php } ?>

    </div>

    <div class="row" style="display: inline-flex; width: 10%; float: right;">
      <button class="btn btn-primary right" style="border: 1px solid #ced4da;" onclick="window.open('assets/functions/report.php?typeReport=financeRequest&<?php if ($dateFilter != '') { echo "dateFilter=".$dateFilter; } else if ($dateMonth != '') { echo "dateMonth=".$dateMonth."-01"; } else { echo "dateFilter="; } ?>', '_blank')" type="button">
        <i class="fa fa-print"></i>&nbsp; Imprimir
      </button>
    </div>

    <script>
    function filterRequest() {
      var navSelected = document.getElementById("navSelected").value;
      var dateFilter  = document.getElementById("dateFilter").value;

      window.location.href='ui-finances.php?dateFilter=' + dateFilter;
    }

    function monthRequest() {
      var navSelected = document.getElementById("navSelected").value;
      var dateMonth   = document.getElementById("dateMonth").value;

      window.location.href='ui-finances.php?dateMonth=' + dateMonth;
    }

    function clearFilter() {
      var navSelected = document.getElementById("navSelected").value;

      window.location.href='ui-finances.php';
    }
    </script>

    <table class="table table-striped" id="tb1" style="margin-top: 20px">
      <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Data</th>
        <th scope="col">Cliente</th>
        <th scope="col">Valor Total</th>
        <th scope="col">Valor Cobrado</th>
        <th scope="col">Pagamento</th>
      </tr>
      </thead>
      <tbody>
      <?php

      if ($dateFilter != "") {

        // Select para paginação
        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente,
                    endereco_cliente.rua, endereco_cliente.numero, endereco_cliente.bairro, endereco_cliente.complemento, endereco_cliente.descricao, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateFilter') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateFilter')
                   ORDER BY pedidos.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 50;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgPedidos']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   WHERE DAY(caixa.dataHoraAbertura) = DAY('$dateFilter') AND MONTH(caixa.dataHoraAbertura) = MONTH('$dateFilter') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateFilter')
                   ORDER BY pedidos.id ASC LIMIT $quatidade_itens, $itens_por_pagina";

        $result = $conexao -> prepare($select);
        $result -> execute();
        $count = $result->rowCount();
      } else if ($dateMonth != "") {
        $dateMonth.="-01";
        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   WHERE MONTH(caixa.dataHoraAbertura) = MONTH('$dateMonth') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateMonth')
                   ORDER BY pedidos.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 50;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgPedidos']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   WHERE MONTH(caixa.dataHoraAbertura) = MONTH('$dateMonth') AND YEAR(caixa.dataHoraAbertura) = YEAR('$dateMonth')
                   ORDER BY pedidos.id ASC LIMIT $quatidade_itens, $itens_por_pagina";

      } else {

        // Select para paginação
        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN endereco_cliente ON pedidos.idEndereco = endereco_cliente.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   ORDER BY pedidos.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 50;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgPedidos']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    pedidos.id, pedidos.nome, pedidos.celular, pedidos.status, pedidos.formaPagamento, pedidos.valorTotal, pedidos.valorCobrado, pedidos.data_hora_cadastro,
                    usuarios.id as idCliente, usuarios.nome as nomeCliente, caixa.id as idCaixa
                   FROM pedidos
                   LEFT JOIN usuarios ON pedidos.idCliente = usuarios.id
                   LEFT JOIN caixa ON pedidos.idCaixa = caixa.id
                   ORDER BY pedidos.id ASC LIMIT $quatidade_itens, $itens_por_pagina";
      }

      $result = $conexao -> prepare($select);
      $result -> execute();
      $count = $result->rowCount();

        if ($data = $result -> fetch()) {
          do {

            $viewIdCliente  = $data['idCliente'];

            $viewIdPedido   = "#".$data['id'];
            $idPedido       = $data['id'];
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

            $dataPedido     = $data['data_hora_cadastro'];
            $dataPedido     = date("d/m/Y H:i", strtotime($dataPedido));

            $valorTotal     = $data['valorTotal'];
            $valorCobrado   = $data['valorCobrado'];

            $valorCobrado   = preg_replace('/[^0-9]+/','.',$valorCobrado);

            $total          += $valorCobrado;

            $valorCobrado   = number_format($valorCobrado, 2, ',', '.');

            $nomeCliente    = $data['nomeCliente'];
            $rua            = $data['rua'];
            $numero         = $data['numero'];
            $bairro         = $data['bairro'];
            $complemento    = $data['complemento'];
            $descricao      = $data['descricao'];

            $style = "style='cursor: pointer;' onclick=loading();window.location.href='ui-new-request.php?idPedido=$idPedido&idCliente=$viewIdCliente'";

            if ($status == 6) {
              $styleBtnReload = "display: none;";
            }

            $newStatus = $status + 1;

            $changeStatus = "onclick=loading();window.location.href='assets/functions/statusRequest.php?idPedido=$idPedido&status=$newStatus'";

            echo "
              <tr>
                <td $style>$idPedido</td>
                <td $style>$dataPedido</td>
                <td $style>$nomeCliente</td>
                <td $style>$valorTotal</td>
                <td $style>$valorCobrado</td>
                <td $style>$viewFormaPagamento</td>
              </tr>
            ";

          } while ($data = $result->fetch());
        }

        $total = number_format($total, 2, ',', '.');

        echo "
          <tr>
            <td>Registros: $count</td>
            <td></td>
            <td></td>
            <td></td>
            <td>$total</td>
            <td></td>
            <td></td>
          </tr>
          ";

      ?>
      </tbody>
    </table>

    <nav aria-label="...">
      <ul class="pagination pagination-sm">
      <?php
        for ($i = 0; $i < $num_paginas; $i++) {
          $estilo = "";
          if ($pagina == $i) {
            $estilo ="class=\"page-item active\"";
      ?>
            <li <?php echo $estilo; ?> ><a style="border-radius:0;" class="page-link" href="ui-finances.php?pgPedidos=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
      <?php } else { ?>
            <li class="page-item" ><a style="border-radius:0;" class="page-link" href="ui-finances.php?pgPedidos=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
      <?php
            }
          }
      ?>
      </ul>
    </nav>

  </div>
</div> <!-- end card -->
