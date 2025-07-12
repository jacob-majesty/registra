<?php

namespace Ixcsoft\Registra\Model;

use Ixcsoft\Registra\Core\Crud;

class Tarefa extends Crud
{
    public function __construct()
    {
        parent::__construct('tarefas'); // O modelo Tarefa manipula a tabela 'tarefas'
    }

    // Métodos específicos para Tarefa podem ser adicionados aqui se necessário,
    // mas os métodos CRUD básicos (create, find, all, update, delete)
    // já são herdados da classe Crud.
}