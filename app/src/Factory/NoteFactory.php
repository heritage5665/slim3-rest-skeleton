<?php

namespace App\Factory;

use App\Object\Note;
use Psr\Log\LoggerInterface;
use PDO;

/**
 * Class NoteFactory.
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
     * @param array $request_data
     *
     * @return bool|\App\Object\Note
     */
    public function createNewNote($request_data)
    {
        $this->logger->info('NoteFactory: create new note');

        if ($request_data == null || !isset($request_data['text'])) {
            return false;
        }

        $stmt = $this->pdo->prepare('INSERT INTO notes (text) VALUES (:text)');
        $stmt->bindParam(':text', $request_data['text']);
        $stmt->execute();

        return new Note($this->pdo->lastInsertId(), $request_data['text']);
    }
}
