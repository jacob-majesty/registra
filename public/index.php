<?php

require __DIR__ . '/../vendor/autoload.php';

use Ixcsoft\Registra\Controller\TarefaController;
use Ixcsoft\Registra\Core\Helper;

$tarefaController = new TarefaController();

$prioridade = $_GET['prioridade'] ?? null;
$busca = $_GET['busca'] ?? null;

$tarefas = $tarefaController->index($prioridade, $busca);

include __DIR__ . '/../templates/header.php';
include __DIR__ . '/../templates/messages.php';
?>

<div class="container mt-5">
    <h2>Minhas Tarefas</h2>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <form class="d-flex" action="index.php" method="GET">
            <select class="form-select me-2" name="prioridade" onchange="this.form.submit()">
                <option value="">Todas as Prioridades</option>
                <option value="baixa" <?= ($prioridade == 'baixa') ? 'selected' : '' ?>>Baixa</option>
                <option value="media" <?= ($prioridade == 'media') ? 'selected' : '' ?>>Média</option>
                <option value="alta" <?= ($prioridade == 'alta') ? 'selected' : '' ?>>Alta</option>
            </select>
        </form>
        <form class="d-flex" action="index.php" method="GET">
            <input type="text" class="form-control me-2" name="busca" placeholder="Buscar por título..." value="<?= htmlspecialchars($busca ?? '') ?>">
            <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            <?php if (!empty($prioridade) || !empty($busca)) : ?>
                <a href="index.php" class="btn btn-outline-danger ms-2">Limpar Filtros</a>
            <?php endif; ?>
        </form>
        <a href="add.php" class="btn btn-primary ms-3">Adicionar Nova Tarefa</a>
    </div>

    <?php if (empty($tarefas)) : ?>
        <div class="alert alert-info" role="alert">
            Nenhuma tarefa encontrada.
        </div>
    <?php else : ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Prioridade</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $tarefa) : ?>
                    <tr>
                        <td><?= htmlspecialchars($tarefa['titulo']) ?></td>
                        <td><?= htmlspecialchars($tarefa['descricao']) ?></td>
                        <td>
                            <span class="badge bg-<?= ($tarefa['prioridade'] == 'alta') ? 'danger' : (($tarefa['prioridade'] == 'media') ? 'warning' : 'info') ?>">
                                <?= ucfirst($tarefa['prioridade']) ?>
                            </span>
                        </td>
                        <td><?= (new DateTime($tarefa['created_at']))->format('d/m/Y H:i') ?></td>
                        <td>
                            <a href="edit.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
include __DIR__ . '/../templates/footer.php';
?>