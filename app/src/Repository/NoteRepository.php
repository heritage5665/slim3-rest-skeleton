<?php

namespace App\Repository;

use App\Models\Note;
use Psr\Log\LoggerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class NoteRepository.
 */
class NoteRepository
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
     * @return array (of \App\Models\Note)
     */
    public function getAllNotes()
    {
        $this->logger->info('NoteRpository: get all notes');

        return Note::orderBy('id')->get();
    }

    /**
     * @param int $id
     *
     * @return null|\App\Models\Note
     */
    public function getNote($id)
    {
        $this->logger->info('NoteRepository: get note');

        return Note::find($id);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function deleteNote($id)
    {
        $this->logger->info('NoteRepository: delete note');

        return Note::destroy($id);
    }
}
