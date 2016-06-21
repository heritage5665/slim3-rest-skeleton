<?php

namespace App\Factory;

use App\Models\Note;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

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
     * @var \Illuminate\Database\Capsule\Manager
     */
    private $db;

    /**
     * @param \Psr\Log\LoggerInterface             $logger
     * @param \Illuminate\Database\Capsule\Manager $db
     */
    public function __construct(LoggerInterface $logger, Capsule $db)
    {
        $this->logger = $logger;
        $this->db = $db;
    }

    /**
     * @param array $request_data
     *
     * @return bool|\App\Models\Note
     */
    public function createNewNote($request_data)
    {
        $this->logger->info('NoteFactory: create new note');

        if ($request_data == null || !isset($request_data['text'])) {
            return false;
        }

        $note = new Note();
        $note->text = $request_data['text'];
        $note->save();

        return $note;
    }
}
