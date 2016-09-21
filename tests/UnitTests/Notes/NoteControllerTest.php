<?php

namespace UnitTests\Notes;

use UnitTests\BaseUnitTestCase;
use Slim\Http\Response;
use Mockery as m;
use App\Controller\NoteController;

class NoteControllerTest extends BaseUnitTestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAddNote()
    {
        $request = $this->createRequest('POST', '/notes');
        $response = new Response();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $model = m::mock('App\Model\Note');
        $model->id = 1;

        $factory = m::mock('App\Factory\NoteFactory');
        $factory->shouldReceive('createNewNote')->andReturn($model);

        $repository = m::mock('App\Repository\NoteRepository');

        $note_controller = new NoteController($logger, $factory, $repository);

        $response = $note_controller->addNote($request, $response, null);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('/notes/1', $response->getHeaderLine('Location'));
        $this->assertContains('Created', (string) $response->getBody());

        // negative test
        $bad_factory = m::mock('App\Factory\NoteFactory');
        $bad_factory->shouldReceive('createNewNote')->andReturn(false);

        $note_controller = new NoteController($logger, $bad_factory, $repository);

        $response = $note_controller->addNote($request, $response, null);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertContains('Bad Request', (string) $response->getBody());
    }

    public function testGetAllNotes()
    {
        $request = $this->createRequest('GET', '/notes');
        $response = new Response();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $factory = m::mock('App\Factory\NoteFactory');

        $repository = m::mock('App\Repository\NoteRepository');
        $repository->shouldReceive('getAllNotes')->andReturn('return_value');

        $note_controller = new NoteController($logger, $factory, $repository);

        $response = $note_controller->getAllNotes($request, $response, null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('return_value', (string) $response->getBody());
    }

    public function testGetNote()
    {
        $request = $this->createRequest('GET', '/note/1');
        $response = new Response();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $factory = m::mock('App\Factory\NoteFactory');

        $repository = m::mock('App\Repository\NoteRepository');
        $repository->shouldReceive('getNote')->andReturn('return_value');

        $note_controller = new NoteController($logger, $factory, $repository);

        $response = $note_controller->getNote($request, $response, null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('return_value', (string) $response->getBody());

        // negative test
        $bad_repository = m::mock('App\Repository\NoteRepository');
        $bad_repository->shouldReceive('getNote')->andReturn(null);

        $note_controller = new NoteController($logger, $factory, $bad_repository);

        $response = $note_controller->getNote($request, $response, null);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('Not Found', (string) $response->getBody());
    }

    public function testDeleteNote()
    {
        $request = $this->createRequest('GET', '/notes');
        $response = new Response();

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $factory = m::mock('App\Factory\NoteFactory');

        $repository = m::mock('App\Repository\NoteRepository');
        $repository->shouldReceive('deleteNote')->andReturn(1);

        $note_controller = new NoteController($logger, $factory, $repository);

        $response = $note_controller->deleteNote($request, $response, null);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('ok', (string) $response->getBody());

        // negative test
        $bad_repository = m::mock('App\Repository\NoteRepository');
        $bad_repository->shouldReceive('deleteNote')->andReturn(0);

        $note_controller = new NoteController($logger, $factory, $bad_repository);

        $response = $note_controller->deleteNote($request, $response, null);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('Not Found', (string) $response->getBody());
    }
}
