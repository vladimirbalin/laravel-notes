<?php

namespace Tests\Feature\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Tests\TestCase;

class NoteControllerTests extends TestCase
{
    private Authenticatable|Model $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function create_note_successfully()
    {
        $payload = [
            'title' => 'New title',
            'content' => 'New content',
            'created_by' => $this->user->id
        ];
        $this->json('post', 'api/notes', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => [
                    'content',
                    'created_at',
                    'id',
                    'title'
                ]
            ]);
    }

    /** @test */
    public function retrieve_notes_successfully()
    {
        $this->json('get', 'api/notes')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'content',
                        'created_at',
                        'id',
                        'title'
                    ]
                ]
            ]);
    }

    /** @test */
    public function update_note_successfully()
    {
        $payload = [
            'title' => 'Update title',
            'content' => 'Updated content',
            'created_by' => $this->user->id,
        ];
        $note = Note::create($payload);
        $this->json('put', 'api/notes/' . $note->id, $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'content',
                    'created_at',
                    'id',
                    'title'
                ]
            ]);
    }

    /** @test */
    public function remove_note_successfully()
    {
        $payload = [
            'title' => 'Title',
            'content' => 'Content',
            'created_by' => $this->user->id,
        ];
        $note = Note::create($payload);
        $this->json('delete', 'api/notes/' . $note->id, $payload)
            ->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }
}
