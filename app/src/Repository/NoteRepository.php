<?php

namespace App\Repository;

use Psr\Log\LoggerInterface;
use PDO;

class NoteRepository
{
    private $logger;
    private $pdo;

    public function __construct(LoggerInterface $logger, PDO $pdo)
    {
        $this->logger = $logger;
        $this->pdo = $pdo;
    }

    public function getAllNotes()
    {
        $this->logger->info('NoteRpository: get all notes');

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
        $this->logger->info('NoteRepository: get note');

        $stmt = $this->pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $id = (int) $id;
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $row;
        }

        return false;
    }

    public function deleteNote($id)
    {
        $this->logger->info('NoteRepository: delete note');

        $stmt = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $id = (int) $id;
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return true;
    }
}
