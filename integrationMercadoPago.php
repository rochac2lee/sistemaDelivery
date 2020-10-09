<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no">

<title>Integração Mercado Pago</title>

<script src="assets/js/jquery.min.js"></script>

<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>



</head>

<body onload="loadData()">

<script>

function loadData() {

// Declaração de Variáveis
var id = "1350489018722479";
var key = "APP_USR-7ec3c362-db13-49ac-96d3-2f56636bce10";

Mercadopago.setPublishableKey(key);

Mercadopago.getIdentificationTypes(identificationHandler);


}

</script>

<div id="dados"></div>

</body>

</html>
