<?php

namespace UnitTests\Notes;

use UnitTests\BaseUnitTestCase;
use Mockery as m;
use App\Factory\NoteFactory;

class NotesFactoryTest extends BaseUnitTestCase
{
    public function testCreateNewNote()
    {
        $request_data = [
            'text' => 'Test note!',
        ];

        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $db = m::mock('\Illuminate\Database\Capsule\Manager');

        $note_factory = new NoteFactory($logger, $db);

        $note = $note_factory->createNewNote($request_data);

        $this->assertEquals(3, $note->id);
        $this->assertEquals('Test note!', $note->text);

        // negative test

        $bad_request_data = [
            'foo' => 'Test note!',
        ];

        $note = $note_factory->createNewNote($bad_request_data);

        $this->assertEquals(false, $note);
    }
}
