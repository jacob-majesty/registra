<?php

require __DIR__ . '/../vendor/autoload.php';

use Ixcsoft\Registra\Controller\TarefaController;
use Ixcsoft\Registra\Core\Helper;

$tarefaController = new TarefaController();

$id = $_GET['id'] ?? null;
$tarefa = false;

if ($id) {
    $tarefa = $tarefaController->show($id);
    if (!$tarefa) {
        Helper::redirectWithError('Tarefa não encontrada!', 'index.php');
    }
} else {
    Helper::redirectWithError('ID da tarefa não especificado para edição.', 'index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $tarefaController->update($id);
    exit();
}

include __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/messages.php';
?>

<div class="container mt-5">
    <h2>Editar Tarefa</h2>
    <?php if ($tarefa) : ?>
        <form action="edit.php?id=<?= htmlspecialchars($tarefa['id']) ?>" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição (Opcional)</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="prioridade" class="form-label">Prioridade</label>
                <select class="form-select" id="prioridade" name="prioridade" required>
                    <option value="baixa" <?= ($tarefa['prioridade'] == 'baixa') ? 'selected' : '' ?>>Baixa</option>
                    <option value="media" <?= ($tarefa['prioridade'] == 'media') ? 'selected' : '' ?>>Média</option>
                    <option value="alta" <?= ($tarefa['prioridade'] == 'alta') ? 'selected' : '' ?>>Alta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Tarefa</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php else : ?>
        <p>Não foi possível carregar a tarefa para edição.</p>
        <a href="index.php" class="btn btn-secondary">Voltar para a lista</a>
    <?php endif; ?>
</div>

<?php
include __DIR__ . '/../templates/footer.php';
?>