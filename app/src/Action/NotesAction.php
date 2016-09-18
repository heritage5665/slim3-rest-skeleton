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
        if ($new_note !== false) {
            $response = $response->withHeader('Location', '/notes/'.$new_note->getId())
                                 ->withJson(array('info' => 'Created'), 201);
        } else {
            $response = $response->withJson(array('info' => '400 Bad Request'), 400);
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

        $notes = $this->repository->getAllNotes();
        $response = $response->withJson(array('data' => $notes));

        return $response;
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
        if ($note !== false) {
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

        $this->repository->deleteNote($args['id']);
        $response->withJson(array('info' => 'ok'));

        return $response;
    }
}
