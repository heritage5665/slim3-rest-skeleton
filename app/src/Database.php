<?php

namespace App;

class Database
{
    private $pdo;

    public function __construct($settings)
    {
        $this->pdo = new \PDO($settings['dsn'], $settings['username'], $settings['password']);
    }

    public function getAllNotes()
    {
        $stmt = $this->pdo->prepare('SELECT * FROM notes ORDER BY id ASC');
        $stmt->execute();
        $result = array();
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    public function getNote($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $id = (int) $id;
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $row;
        }

        return false;
    }

    public function addNote($text)
    {
        $stmt = $this->pdo->prepare('INSERT INTO notes (text) VALUES (:text)');
        $stmt->bindParam(':text', $text);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function deleteNote($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $id = (int) $id;
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }
}
