<?php

namespace App\Action;

use Psr\Log\LoggerInterface;

final class NotesAction
{
    private $db;
    private $logger;

    public function __construct(\App\Database $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function getAllNotes($request, $response, $args)
    {
        $this->logger->info('get all notes');

        $response = $response->withHeader('Content-Type', 'application/json')->write(json_encode($this->db->getAllNotes()));

        return $response;
    }

    public function getNote($request, $response, $args)
    {
        $this->logger->info('get one note');

        $note = $this->db->getNote($args['id']);
        if ($note !== false) {
            $response = $response->withHeader('Content-Type', 'application/json')->write(json_encode($note));
        } else {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json')->write(json_encode('404 Not Found'));
        }

        return $response;
    }

    public function addNote($request, $response, $args)
    {
        $this->logger->info('note added');

        $new_id = $this->db->addNote($request->getBody());
        $response = $response->withStatus(201)->withHeader('Location', '/notes/'.$new_id);

        return $response;
    }

    public function deleteNote($request, $response, $args)
    {
        $this->logger->info('note deleted');

        $this->db->deleteNote($args['id']);
        $response->write(json_encode('ok'));

        return $response;
    }
}
