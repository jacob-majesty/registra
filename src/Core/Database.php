<?php

namespace Ixcsoft\Registra\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;
    private $dbFile;

    private function __construct()
    {
        $this->dbFile = __DIR__ . '/../../data/database.sqlite';

        try {
            $this->pdo = new PDO("sqlite:" . $this->dbFile);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->initializeSchema();

        } catch (PDOException $e) {
            die("Falha na conexão com o banco de dados SQLite: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    private function __clone() {}
    public function __wakeup() {}

    private function initializeSchema()
    {
        // Tabela para Tarefas
        $sqlTarefas = "
            CREATE TABLE IF NOT EXISTS tarefas (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                titulo TEXT NOT NULL,
                descricao TEXT,
                prioridade TEXT NOT NULL CHECK(prioridade IN ('baixa', 'media', 'alta')),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $this->pdo->exec($sqlTarefas);

        // A tabela 'users' não será mais usada para login, mas pode ser mantida ou removida
        // Se você quiser remover completamente, apague o bloco abaixo
        $sqlUsers = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL UNIQUE,
                password TEXT NOT NULL
            );
        ";
        $this->pdo->exec($sqlUsers);
        // Exemplo de inserção de usuário, que não será mais usada para autenticação real
        // mas garante que a tabela não fique vazia se você mantê-la.
        $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT OR IGNORE INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute([
            ':email' => 'admin@roomly.com',
            ':password' => $hashedPassword
        ]);
    }
}