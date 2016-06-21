<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
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
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: add note');

        $new_note = $this->factory->createNewNote($request->getParsedBody());
        if (!empty($new_note)) {
            $response = $response->withStatus(201)
                                 ->withHeader('Location', '/notes/'.$new_note->id)
                                 ->withJson(array('info' => '201 Created'));
        } else {
            $response = $response->withStatus(400)
                                 ->withJson(array('info' => '400 Bad Request'));
        }

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getAllNotes(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: get all notes');

        $notes = $this->repository->getAllNotes();
        if (!empty($notes) && $notes->count() > 0) {
            $response = $response->withJson(array('data' => $notes));
        } else {
            $response = $response->withStatus(404)
                                 ->withJson(array('info' => '404 Not Found'));
        }

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: get note');

        $note = $this->repository->getNote($args['id']);
        if (!empty($note)) {
            $response = $response->withJson(array('data' => $note));
        } else {
            $response = $response->withStatus(404)
                                 ->withJson(array('info' => '404 Not Found'));
        }

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteNote(Request $request, Response $response, $args)
    {
        $this->logger->info('NotesAction: note deleted');

        $count = $this->repository->deleteNote($args['id']);
        if ($count > 0) {
            $response = $response->withJson(array('info' => 'ok'));
        } else {
            $response = $response->withStatus(404)
                                 ->withJson(array('info' => '404 Not Found'));
        }

        return $response;
    }
}
