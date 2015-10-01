<?php

namespace App\Action;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Factory\NoteFactory;
use App\Repository\NoteRepository;

/**
 * Class NotesAction
 *
 * @package App\Action
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addNote(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info('NotesAction: add note');

        $new_id = $this->factory->create($request->getBody());
        $response = $response->withStatus(201)->withHeader('Location', '/notes/'.$new_id);

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getAllNotes(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info('NotesAction: get all notes');

        $response = $response->withHeader('Content-Type', 'application/json')->write(json_encode($this->repository->getAllNotes()));

        return $response;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getNote(ServerRequestInterface $request, ResponseInterface $response, $args)
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

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param array                                    $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteNote(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->logger->info('NotesAction: note deleted');

        $this->repository->deleteNote($args['id']);
        $response->write(json_encode('ok'));

        return $response;
    }
}
