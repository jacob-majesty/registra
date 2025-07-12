<?php

require __DIR__ . '/../vendor/autoload.php';

use Ixcsoft\Registra\Controller\TarefaController;
use Ixcsoft\Registra\Core\Helper;

$tarefaController = new TarefaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarefaController->store();
    exit();
}

include __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/messages.php';
?>

<div class="container mt-5">
    <h2>Adicionar Nova Tarefa</h2>
    <form action="add.php" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição (Opcional)</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="prioridade" class="form-label">Prioridade</label>
            <select class="form-select" id="prioridade" name="prioridade" required>
                <option value="">Selecione a Prioridade</option>
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php
include __DIR__ . '/../templates/footer.php';
?>