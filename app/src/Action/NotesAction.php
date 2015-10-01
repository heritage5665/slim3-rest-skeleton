<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use App\Factory\NoteFactory;
use App\Repository\NoteRepository;

final class NotesAction
{
    private $logger;
    private $factory;
    private $repository;

    public function __construct(LoggerInterface $logger, NoteFactory $factory, NoteRepository $repository)
    {
        $this->logger = $logger;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function addNote($request, $response, $args)
    {
        $this->logger->info('NotesAction: add note');

        $new_id = $this->factory->create($request->getBody());
        $response = $response->withStatus(201)->withHeader('Location', '/notes/'.$new_id);

        return $response;
    }

    public function getAllNotes($request, $response, $args)
    {
        $this->logger->info('NotesAction: get all notes');

        $response = $response->withHeader('Content-Type', 'application/json')->write(json_encode($this->repository->getAllNotes()));

        return $response;
    }

    public function getNote($request, $response, $args)
    {
        $this->logger->info('NotesAction: get note');

        $note = $this->repository->getNote($args['id']);
        if ($note !== false) {
            $response = $response->withHeader('Content-Type', 'application/json')->write(json_encode($note));
        } else {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json')->write(json_encode('404 Not Found'));
        }

        return $response;
    }

    public function deleteNote($request, $response, $args)
    {
        $this->logger->info('NotesAction: note deleted');

        $this->repository->deleteNote($args['id']);
        $response->write(json_encode('ok'));

        return $response;
    }
}
