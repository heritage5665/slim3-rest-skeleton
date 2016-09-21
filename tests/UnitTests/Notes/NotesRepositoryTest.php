<?php

namespace UnitTests\Notes;

use UnitTests\BaseUnitTestCase;
use Mockery as m;
use App\Repository\NoteRepository;

class NotesRepositoryTest extends BaseUnitTestCase
{
    public function testGetAllNotes()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $db = m::mock('\Illuminate\Database\Capsule\Manager');

        $note_repository = new NoteRepository($logger, $db);

        $notes = $note_repository->getAllNotes();

        $this->assertEquals(1, $notes[0]->id);
        $this->assertEquals('Hello Testing!', $notes[0]->text);
        $this->assertEquals(2, $notes[1]->id);
        $this->assertEquals('Hello Testing2!', $notes[1]->text);
        $this->assertEquals(2, count($notes));
    }

    public function testGetNote()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $db = m::mock('\Illuminate\Database\Capsule\Manager');

        $note_repository = new NoteRepository($logger, $db);

        $note = $note_repository->getNote(1);

        $this->assertEquals(1, $note->id);
        $this->assertEquals('Hello Testing!', $note->text);
    }

    public function testDeleteNote()
    {
        $logger = m::mock('Psr\Log\LoggerInterface');
        $logger->shouldReceive('info');

        $db = m::mock('\Illuminate\Database\Capsule\Manager');

        $note_repository = new NoteRepository($logger, $db);

        $count = $note_repository->deleteNote(1);

        $this->assertEquals(1, $count);
    }
}
