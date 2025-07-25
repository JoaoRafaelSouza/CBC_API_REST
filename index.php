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
} elseif ($uri === 'recursos' && $method === 'GET') {
    $recursoCtrl->listar();
    exit;
} elseif ($uri === 'recursos' && $method === 'POST') {
    $recursoCtrl->cadastrar($input);
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
            <button class="btn btn-primary mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#modalCadastrarClube">
                <i class="material-icons">add</i> Cadastrar Clube
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRecursos">
                <i class="material-icons">add</i> Cadastrar Recurso
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalConsumo">
                <i class="material-icons">shopping_cart</i> Consumir Recurso
            </button>
        </div>
    </div>


    <!-- Modal da lista de clubes -->
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
                                <th>ID</th>
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

    <!-- Modal Cadastrar Clube -->
    <div class="modal fade" id="modalCadastrarClube" tabindex="-1" aria-labelledby="modalCadastrarClubeLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCadastrarClubeLabel">Cadastrar Novo Clube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formClube" onsubmit="cadastrarClube(event)">
                        <div class="form-group mb-3">
                            <label for="clube">Nome do Clube:</label>
                            <input type="text" id="clube" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="saldo">Saldo Inicial:</label>
                            <input type="number" step="0.01" id="saldo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </form>
                    <div id="mensagemCadastro" class="mt-3"></div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de Cadastro de Recursos -->
    <div class="modal fade" id="modalRecursos" tabindex="-1" aria-labelledby="modalRecursosLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalRecursosLabel">Cadastrar Novo Recurso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formRecurso" onsubmit="cadastrarRecurso(event)">
                        <div class="form-group">
                            <label for="recurso">Nome do Recurso:</label>
                            <input type="text" id="recurso" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="saldoRecurso">Saldo Inicial:</label>
                            <input type="number" step="0.01" id="saldoRecurso" class="form-control" required>
                        </div>
                        <div id="mensagemCadastroRecurso" class="mt-3"></div>
                        <button type="submit" class="btn btn-success mt-3">Cadastrar Recurso</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal de Consumo de Recursos -->
    <div class="modal fade" id="modalConsumo" tabindex="-1" aria-labelledby="modalConsumoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalConsumoLabel">Consumir Recurso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formConsumo" onsubmit="consumirRecurso(event)">
                        <div class="form-group">
                            <label for="clubeSelect">Clube:</label>
                            <select id="clubeSelect" class="form-control" required></select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="recursoSelect">Recurso:</label>
                            <select id="recursoSelect" class="form-control" required></select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="valorConsumo">Valor do Consumo:</label>
                            <input type="number" step="0.01" id="valorConsumo" class="form-control" required>
                        </div>
                        <div id="mensagemConsumo" class="mt-3"></div>
                        <button type="submit" class="btn btn-warning mt-3">Consumir</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>

</body>

</html>