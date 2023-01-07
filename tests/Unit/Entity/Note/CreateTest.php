<?php

namespace Entity\Note;

use App\Models\Note;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function note_has_created()
    {
        $note = new Note([
            'title' => 'New title',
            'content' => 'New content',
            'created_by' => 1
        ]);

        $this->assertEquals('New title', $note->title);
        $this->assertEquals('New content', $note->content);
        $this->assertEquals(1, $note->created_by);
    }
}
