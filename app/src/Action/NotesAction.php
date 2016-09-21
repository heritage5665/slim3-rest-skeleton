<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Factory\NoteFactory;
use App\Repository\NoteRepository;

/**
 * Class NotesAction.
 */
final class NotesAction
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \App\Factory\NoteFactory
     */
    private $factory;

    /**
     * @var \App\Repository\NoteRepository
     */
    private $repository;

    /**
     * @param \Psr\Log\LoggerInterface       $logger
     * @param \App\Factory\NoteFactory       $factory
     * @param \App\Repository\NoteRepository $repository
     */
    public function __construct(LoggerInterface $logger, NoteFactory $factory, NoteRepository $repository)
    {
        $this->logger = $logger;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function addNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: add note');

        $new_note = $this->factory->createNewNote($request->getParsedBody());
        if (!empty($new_note)) {
            $response = $response->withHeader('Location', '/notes/'.$new_note->id)
                                 ->withJson(array('info' => 'Created'), 201);
        } else {
            $response = $response->withJson(array('info' => 'Bad Request'), 400);
        }

        return $response;
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function getAllNotes(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: get all notes');

        // getAllNotes always returns a \Illuminate\Database\Eloquent\Collection
        // We do no further test if this collection is empty just return it.
        // This means if the Collection is empty we return an empty array as valid result, no 404.
        $notes = $this->repository->getAllNotes();

        return $response->withJson(array('data' => $notes));
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function getNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: get note');

        $note = $this->repository->getNote($args['id']);
        if (!empty($note)) {
            $response = $response->withJson(array('data' => $note));
        } else {
            $response = $response->withJson(array('info' => 'Not Found'), 404);
        }

        return $response;
    }

    /**
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     *
     * @return \Slim\Http\Response
     */
    public function deleteNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: note deleted');

        $count = $this->repository->deleteNote($args['id']);
        if ($count > 0) {
            $response = $response->withJson(array('info' => 'ok'));
        } else {
            $response = $response->withJson(array('info' => 'Not Found'), 404);
        }

        return $response;
    }
}
