<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $notesForCurrentUser = Note::where(['created_by' => $request->user()->id])->get();
        return NoteResource::collection($notesForCurrentUser);
    }

    /**
     * Store a newly created note in storage.
     *
     * @param NoteRequest $request
     * @return NoteResource
     */
    public function store(NoteRequest $request)
    {
        $createdNote = Note::create($request->validated());

        return new NoteResource($createdNote);
    }

    /**
     * Update the specified note in storage.
     *
     * @param NoteRequest $request
     * @param $id
     * @return NoteResource|JsonResponse
     */
    public function update(NoteRequest $request, $id)
    {
        $note = Note::find($id);

        if (! isset($note)) {
            return response()->json(['message' => 'Note was not found'], 404);
        }

        $note->update($request->validated());

        return new NoteResource($note);
    }

    /**
     * Remove the specified note from storage.
     *
     * @param Note $note
     * @return JsonResponse
     */
    public function destroy(Note $note)
    {
        return $note->delete() ?
            response()->json(['message' => 'Note was successfully removed'], 202) :
            response()->json(['message' => 'Note was not removed'], 404);
    }
}
