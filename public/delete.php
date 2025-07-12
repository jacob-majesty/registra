<?php

require __DIR__ . '/../vendor/autoload.php';

use Ixcsoft\Registra\Core\Helper;
use Ixcsoft\Registra\Controller\TarefaController;

$tarefaController = new TarefaController();
$id = $_GET['id'] ?? null;

if (!$id) {
    Helper::redirectWithError('ID da tarefa não especificado.');
}

$tarefaController->destroy($id);

exit();