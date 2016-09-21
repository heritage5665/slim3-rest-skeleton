<?php

namespace Tests\Notes;

use Tests\BaseTestCase;
use App\Models\Note;

class NotesTest extends BaseTestCase
{
    public function testGetNotes()
    {
        $response = $this->runApp('GET', '/notes');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals(1, $data['data'][0]['id']);
        $this->assertEquals('Hello Testing!', $data['data'][0]['text']);
    }

    public function testGetNote()
    {
        $response = $this->runApp('GET', '/notes/1');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals(1, $data['data']['id']);
        $this->assertEquals('Hello Testing!', $data['data']['text']);
    }

    public function testGetNoteNotFound()
    {
        $response = $this->runApp('GET', '/notes/10000');

        $this->assertEquals(404, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('info', $data);
        $this->assertContains('Not Found', $data['info']);
    }

    public function testPostNote()
    {
        $response = $this->runApp('POST', '/notes', ['text' => 'hello']);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('info', $data);
        $this->assertContains('Created', $data['info']);

        // test data seed contains 2 notes, so the new note should have id 3
        $note = Note::find(3);
        $this->assertEquals('hello', $note->text);
    }

    public function testPostErrorNote()
    {
        $response = $this->runApp('POST', '/notes', ['foo' => 'bar']);

        $this->assertEquals(400, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('info', $data);
        $this->assertContains('Bad Request', $data['info']);
    }

    public function testDeleteNote()
    {
        $response = $this->runApp('DELETE', '/notes/1');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('info', $data);
        $this->assertContains('ok', $data['info']);
    }

    public function testDeleteNoteNotFound()
    {
        $response = $this->runApp('DELETE', '/notes/10000');

        $this->assertEquals(404, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('info', $data);
        $this->assertContains('Not Found', $data['info']);
    }
}
