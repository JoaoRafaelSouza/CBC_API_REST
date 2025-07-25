<?php
require 'autoload.php';

use Controllers\Clube_Controller;
use Controllers\Recursos_Controller;

$clubeCtrl = new Clube_Controller();
$recursoCtrl = new Recursos_Controller();

switch ("$method $uri") {
    case 'GET /clubes':
        $clubeCtrl->listar();
        break;
    case 'POST /clubes':
        $clubeCtrl->cadastrar($input);
        break;
    case 'POST /consumir':
        $recursoCtrl->consumir($input);
        break;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/complementos.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="js/complementos.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <title>CBC_API</title>
</head>

<body>
    <div class="row">
        <div class="col-12">
            <h2>CBC - API Rest</h2>
        </div>
        <div class="form-row mt-2">
            <div class="col-md-12">
                <a type="button" class="btn btn-primary ml-2" target='_blank' href="#">
                    <i class='material-icons mi-secondary pointer ajuste_i'>add</i>
                    <span class="ajuste_span"> Cadastrar Novo</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>