<?php

namespace App\Factory;

use Psr\Log\LoggerInterface;
use PDO;

class NoteFactory
{
    private $logger;
    private $pdo;

    public function __construct(LoggerInterface $logger, PDO $pdo)
    {
        $this->logger = $logger;
        $this->pdo = $pdo;
    }

    public function create($text)
    {
        $this->logger->info('NoteFactory: create note');

        $stmt = $this->pdo->prepare('INSERT INTO notes (text) VALUES (:text)');
        $stmt->bindParam(':text', $text);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }
}
