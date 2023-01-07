<?php

namespace NoteCrud;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Tests\TestCase;

class NoteTests extends TestCase
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

        $response = $this->json('post', 'api/notes', $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
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
        $response = $this->json('get', 'api/notes');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
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

        $response = $this->json('put', 'api/notes/' . $note->id, $payload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
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

        $response = $this->json('delete', 'api/notes/' . $note->id, $payload);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }
}
