<?php

namespace Ixcsoft\Registra\Core;

use PDO;
use PDOException;

class Crud
{
    protected $pdo;
    protected $tableName;

    public function __construct(string $tableName)
    {
        $this->pdo = Database::getInstance()->getConnection();
        $this->tableName = $tableName;
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})";

        try {
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute($data)) {
                return $this->pdo->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro ao criar registro na tabela {$this->tableName}: " . $e->getMessage());
            return false;
        }
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = :id LIMIT 1";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar registro na tabela {$this->tableName} (ID: {$id}): " . $e->getMessage());
            return false;
        }
    }

    public function all(string $whereClause = '', array $params = [], string $orderBy = '')
    {
        $sql = "SELECT * FROM {$this->tableName} {$whereClause} {$orderBy}";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os registros na tabela {$this->tableName}: " . $e->getMessage());
            return [];
        }
    }

    public function update(int $id, array $data): bool
    {
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "{$column} = :{$column}";
        }
        $setClause = implode(', ', $setParts);

        $sql = "UPDATE {$this->tableName} SET {$setClause} WHERE id = :id";

        $data[':id'] = $id;

        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar registro na tabela {$this->tableName} (ID: {$id}): " . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir registro na tabela {$this->tableName} (ID: {$id}): " . $e->getMessage());
            return false;
        }
    }
}