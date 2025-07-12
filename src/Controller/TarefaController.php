<?php

namespace Ixcsoft\Registra\Controller;

use Ixcsoft\Registra\Model\Tarefa;
use Ixcsoft\Registra\Core\Helper;

class TarefaController
{
    private $tarefaModel;

    public function __construct()
    {
        $this->tarefaModel = new Tarefa();
    }

    public function index($prioridade = null, $busca = null)
    {
        $conditions = [];
        $params = [];

        if ($prioridade && in_array($prioridade, ['baixa', 'media', 'alta'])) {
            $conditions[] = "prioridade = :prioridade";
            $params[':prioridade'] = $prioridade;
        }

        if ($busca) {
            $conditions[] = "titulo LIKE :busca";
            $params[':busca'] = '%' . $busca . '%';
        }

        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
        $orderBy = "ORDER BY CASE prioridade WHEN 'alta' THEN 1 WHEN 'media' THEN 2 WHEN 'baixa' THEN 3 ELSE 4 END, created_at DESC";

        return $this->tarefaModel->all($whereClause, $params, $orderBy);
    }

    public function store()
    {
        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? '';

        if (empty($titulo) || empty($prioridade) || !in_array($prioridade, ['baixa', 'media', 'alta'])) {
            Helper::redirectWithError('Por favor, preencha todos os campos obrigatórios corretamente.', 'add.php');
            return;
        }

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'prioridade' => $prioridade,
        ];

        if ($this->tarefaModel->create($data)) {
            Helper::redirectWithSuccess('Tarefa adicionada com sucesso!', 'index.php');
        } else {
            Helper::redirectWithError('Erro ao adicionar tarefa.', 'add.php');
        }
    }

    public function show($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Helper::redirectWithError('ID de tarefa inválido.', 'index.php');
            return false;
        }
        return $this->tarefaModel->find($id);
    }

    public function update($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Helper::redirectWithError('ID de tarefa inválido.', 'index.php');
            return;
        }

        $titulo = $_POST['titulo'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $prioridade = $_POST['prioridade'] ?? '';

        if (empty($titulo) || empty($prioridade) || !in_array($prioridade, ['baixa', 'media', 'alta'])) {
            Helper::redirectWithError('Por favor, preencha todos os campos obrigatórios corretamente.', 'edit.php?id=' . $id);
            return;
        }

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'prioridade' => $prioridade,
        ];

        if ($this->tarefaModel->update($id, $data)) {
            Helper::redirectWithSuccess('Tarefa atualizada com sucesso!', 'index.php');
        } else {
            Helper::redirectWithError('Erro ao atualizar tarefa.', 'edit.php?id=' . $id);
        }
    }

    public function destroy($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Helper::redirectWithError('ID de tarefa inválido.', 'index.php');
            return;
        }

        if ($this->tarefaModel->delete($id)) {
            Helper::redirectWithSuccess('Tarefa excluída com sucesso!', 'index.php');
        } else {
            Helper::redirectWithError('Erro ao excluir tarefa.', 'index.php');
        }
    }
}