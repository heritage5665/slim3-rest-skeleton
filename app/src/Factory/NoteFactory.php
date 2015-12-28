<?php

namespace App\Factory;

use App\Object\Note;
use Psr\Log\LoggerInterface;
use PDO;

/**
 * Class NoteFactory
 *
 * @package App\Factory
 */
class NoteFactory
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \PDO                     $pdo
     */
    public function __construct(LoggerInterface $logger, PDO $pdo)
    {
        $this->logger = $logger;
        $this->pdo = $pdo;
    }

    /**
     * @param $text
     * @return \App\Object\Note
     */
    public function createNewNote($text)
    {
        $this->logger->info('NoteFactory: create new note');

        $stmt = $this->pdo->prepare('INSERT INTO notes (text) VALUES (:text)');
        $stmt->bindParam(':text', $text);
        $stmt->execute();

        return new Note($this->pdo->lastInsertId(), $text);
    }
}
