<?php

namespace Tests\Models;

use App\Models\Note;
use Tests\TestCase;

class NoteTests extends TestCase
{
    private Note $note;

    public function setUp(): void
    {
        parent::setUp();
        $this->note = new Note([
            'title' => 'New title',
            'content' => 'New content',
            'created_by' => 1
        ]);
    }

    /** @test */
    public function note_has_title()
    {
        $this->assertEquals('New title', $this->note->title);
    }

    /** @test */
    public function note_has_content()
    {
        $this->assertEquals('New content', $this->note->content);
    }

    /** @test */
    public function note_has_created_by()
    {
        $this->assertEquals(1, $this->note->created_by);
    }
}
