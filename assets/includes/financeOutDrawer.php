<?php

$dateFilter = $_GET['dateFilter'];
$dateMonth  = $_GET['dateMonth'];

?>
<div class="card mb-3 animated fadeIn">
  <div class="card-body">

    <h5 class="card-title">Saídas</h5>

    <div class="row" style="display: inline-flex; width: 90%;">
      <div class="col-lg-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
          </div>
          <input type="date" class="form-control" onchange="filterSangria()" style="width: 80%; border-left: 0;" value="<?php echo $dateFilter; ?>" id="dateFilterSangria">
        </div>
      </div>

      <div class="col-lg-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" style="border: 1px solid #ced4da;" disabled type="button"><i class="fa fa-filter"></i></button>
          </div>
          <input type="month" class="form-control" onchange="monthSangria()" style="width: 10%; border-left: 0;" value="<?php echo $dateMonth; ?>" id="dateMonthSangria">
        </div>
      </div>

      <?php if ($dateFilter != "" || $dateMonth != "") {?>
      <button class="btn btn-outline-secondary" onclick="clearFilter()" style="border: solid 3px #ced4da;" type="button"><i class="fa fa-times"></i></button>
      <?php } ?>

    </div>
    <div class="row" style="display: inline-flex; width: 10%; float: right;">
      <button class="btn btn-primary right" style="border: 1px solid #ced4da;" onclick="window.open('assets/functions/report.php?typeReport=financeOutDrawer&<?php if ($dateFilter != '') { echo "dateFilter=".$dateFilter; } else if ($dateMonth != '') { echo "dateMonth=".$dateMonth."-01"; } else { echo "dateFilter="; } ?>', '_blank')" type="button">
        <i class="fa fa-print"></i>&nbsp; Imprimir
      </button>
    </div>

    <script>
    function filterSangria() {
      var dateFilter  = document.getElementById("dateFilterSangria").value;

      window.location.href='ui-finances.php?dateFilter=' + dateFilter;
    }

    function monthSangria() {
      var dateMonth   = document.getElementById("dateMonthSangria").value;

      window.location.href='ui-finances.php?dateMonth=' + dateMonth;
    }

    function clearFilter() {

      window.location.href='ui-finances.php';
    }
    </script>

    <table class="table table-striped" id="tb1" style="margin-top: 20px">
      <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Tipo</th>
        <th scope="col">Categoria</th>
        <th scope="col">Pessoa</th>
        <th scope="col">Data Venc.</th>
        <th scope="col">Data Ref.</th>
        <th scope="col">Valor</th>
        <th scope="col">Tipo Doc.</th>
      </tr>
      </thead>
      <tbody>
      <?php

      if ($dateFilter != "") {
        // Select para paginação
        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   WHERE DAY(contas_san.dataRef) = DAY('$dateFilter') AND MONTH(contas_san.dataRef) = MONTH('$dateFilter') AND YEAR(contas_san.dataRef) = YEAR('$dateFilter')
                   ORDER BY contas_san.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 10;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgSaidas']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   WHERE DAY(contas_san.dataRef) = DAY('$dateFilter') AND MONTH(contas_san.dataRef) = MONTH('$dateFilter') AND YEAR(contas_san.dataRef) = YEAR('$dateFilter')
                   ORDER BY contas_san.id ASC LIMIT $quatidade_itens, $itens_por_pagina";
      } else if ($dateMonth != "") {
        $dateMonth.="-01";
        // Select para paginação
        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   WHERE MONTH(contas_san.dataRef) = MONTH('$dateMonth') AND YEAR(contas_san.dataRef) = YEAR('$dateMonth')
                   ORDER BY contas_san.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 10;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgSaidas']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   WHERE MONTH(contas_san.dataRef) = MONTH('$dateMonth') AND YEAR(contas_san.dataRef) = YEAR('$dateMonth')
                   ORDER BY contas_san.id ASC LIMIT $quatidade_itens, $itens_por_pagina";
      } else {

        // Select para paginação
        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   ORDER BY contas_san.id ASC";
        $result = $conexao -> prepare($select);
        $result -> execute();
        $num_total = $result->rowCount();
        $itens_por_pagina = 10;
        $num_paginas = ceil($num_total/$itens_por_pagina);
        $pagina = intval($_GET['pgSaidas']);
        $quatidade_itens = $pagina * $itens_por_pagina;

        $select = "SELECT
                    contas_san.id, contas_san.tipo, contas_san.categoria, contas_san.dataVenc, contas_san.dataRef, contas_san.descricao, contas_san.valor, contas_san.nDoc, contas_san.codTipoDoc, contas_san.observacoes, contas_san.data_hora_cadastro, contas_san.baixa,
                    usuarios.id as idUsuario, usuarios.nome as nomeUsuario,
                    categoria_contas_pag.nome
                   FROM contas_san
                   LEFT JOIN usuarios ON contas_san.idUsuario = usuarios.id
                   INNER JOIN categoria_contas_pag ON contas_san.categoria = categoria_contas_pag.id
                   ORDER BY contas_san.id ASC LIMIT $quatidade_itens, $itens_por_pagina";

      }
      $result = $conexao -> prepare($select);
      $result -> execute();
      $count = $result->rowCount();

      $total = 0;

        if ($data = $result -> fetch()) {
          do {

            $idPag       = $data['id'];
            $tipo        = $data['tipo'];
            $categoria   = $data['categoria'];
            $dataVenc    = $data['dataVenc'];
            $dataRef     = $data['dataRef'];
            $pessoa      = $data['nomeUsuario'];
            $valor       = $data['valor'];
            $codTipoDoc  = $data['codTipoDoc'];
            $observacoes = $data['observacoes'];
            $baixa       = $data['baixa'];

            switch ($tipo) {
              case 1:
                $viewTipo = "Recebimentos";
                break;

              case 2:
                $viewTipo = "Despesa Fixa";
                break;

              case 3:
                $viewTipo = "Despesa Variável";
                break;

              case 4:
                $viewTipo = "Sangria";
                break;
            }

            switch ($baixa) {
              case 0:
                $viewBaixa = "Não";
                break;

              case 1:
                $viewBaixa = "Sim";
                break;
            }

            switch ($codTipoDoc) {
              case 1:
                $viewTipoDoc = "Dinheiro";
                break;

              case 2:
                $viewTipoDoc = "Cartão Crédito";
                break;

              case 3:
                $viewTipoDoc = "Cartão Débito";
                break;

              case 4:
                $viewTipoDoc = "Débito em Conta";
                break;

              case 5:
                $viewTipoDoc = "Vale";
                break;

              case 6:
                $viewTipoDoc = "Bonificação";
                break;

              case 7:
                $viewTipoDoc = "Transferência Bancária (TED)";
                break;
            }

            $valor = preg_replace('/[^0-9]+/','.',$valor);
            $total = preg_replace('/[^0-9]+/','.',$total);

            if ($categoria == 37) {
              if ($baixa == 1) {
                $viewLucro += $valor;
              }
            } else {
              if ($baixa == 1) {
                $viewSangria += $valor;
              }
            }

            $total += $valor;

            $valor       = number_format($valor, 2, ',', '.');

            $dataVenc = date("d/m/Y", strtotime($dataVenc));
            $dataRef  = date("d/m/Y", strtotime($dataRef));

            $style = "style='cursor: pointer;' onclick=loading();window.location.href='ui-finances-details.php?id=$idPag&categoria=sangria'";

            echo "
              <tr>
                <td $style>$idPag</td>
                <td $style>$viewTipo</td>
                <td $style>$categoria</td>
                <td $style>$pessoa</td>
                <td $style>$dataVenc</td>
                <td $style>$dataRef</td>
                <td $style>$valor</td>
                <td $style>$viewTipoDoc</td>
              </tr>
            ";

          } while ($data = $result -> fetch());
        }

        $total       = number_format($total, 2, ',', '.');
        echo "
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>$total</td>
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
            <li <?php echo $estilo; ?> ><a style="border-radius:0;" class="page-link" href="ui-finances.php?nav=<?php echo $nav; ?>&pgSaidas=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
      <?php } else { ?>
            <li class="page-item" ><a style="border-radius:0;" class="page-link" href="ui-finances.php?nav=<?php echo $nav; ?>&pgSaidas=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
      <?php
            }
          }
      ?>
      </ul>
    </nav>

  </div>
</div> <!-- end card -->
