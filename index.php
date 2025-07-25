<?php
require 'autoload.php';

use Controllers\Clube_Controller;
use Controllers\Recursos_Controller;

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_GET['rota'] ?? '/';

$input = json_decode(file_get_contents('php://input'), true);

$clubeCtrl = new Clube_Controller();
$recursoCtrl = new Recursos_Controller();

if ($uri === 'clubes' && $method === 'GET') {
    $clubeCtrl->listar();
    exit;
} elseif ($uri === 'clubes' && $method === 'POST') {
    $clubeCtrl->cadastrar($input);
    exit;
} elseif ($uri === 'consumir' && $method === 'POST') {
    $recursoCtrl->consumir($input);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estruturas de Css -->
    <link href="css/complementos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Estruturas de Javascript -->
    <script src="js/complementos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <title>CBC_API</title>
</head>

<body>
    <div class="row">
        <div class="col-12">
            <h2>CBC - API Rest</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-row mt-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalClubes"
                    onclick="listarClubes()">
                    <i class="material-icons">list</i> Ver Clubes
                </button>
            </div>
        </div>
        <div class="form-row mt-2"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4 class="mt-4">Cadastrar Novo Clube</h4>
            <form id="formClube" onsubmit="cadastrarClube(event)">
                <div class="form-group">
                    <label for="clube">Nome do Clube:</label>
                    <input type="text" id="clube" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="saldo">Saldo Inicial:</label>
                    <input type="number" step="0.01" id="saldo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Cadastrar</button>
            </form>

        </div>
        <div id="mensagemCadastro" class="mt-3"></div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalClubes" tabindex="-1" aria-labelledby="modalClubesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Lista de Clubes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Clube</th>
                                <th>Saldo Disponível</th>
                            </tr>
                        </thead>
                        <tbody id="tabela-clubes">
                            <!-- Conteúdo será preenchido via JS -->
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>

</body>

</html>