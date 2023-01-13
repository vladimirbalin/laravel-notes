<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/notes",
     *     tags={"Notes"},
     *     @OA\MediaType(
     *          mediaType="application/json",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Getting all notes of the current authorized user",
     *         @OA\JsonContent (
     *              @OA\AdditionalProperties(ref="#/components/schemas/note-resource")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *     ),
     *     security={
     *          {"xsrf":{}, "session-id":{}}
     *     }
     * )
     */
    public function index(Request $request): ResourceCollection
    {
        $notesForCurrentUser = Note
            ::query()
            ->where([
                'created_by' => $request->user()->id
            ])->get();

        return NoteResource::collection($notesForCurrentUser);
    }

    /**
     * @OA\Post(
     *     path="/notes",
     *     tags={"Notes"},
     *     @OA\RequestBody (
     *         required=true,
     *         description="Note object that needs to be added",
     *         @OA\JsonContent(ref="#/components/schemas/note")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Creating note",
     *         @OA\JsonContent (ref="#/components/schemas/note-resource"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *     ),
     *     security={
     *          {"xsrf":{}, "session-id":{}}
     *     },
     * )
     */
    public function store(NoteRequest $request): NoteResource
    {
        $createdNote = Note::create($request->validated());

        return new NoteResource($createdNote);
    }

    /**
     * @OA\Put(
     *     path="/notes/{noteId}",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="noteId",
     *         in="path",
     *         description="Note id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         ),
     *     ),
     *     @OA\RequestBody (
     *         description="Note object that needs to be updated",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/note"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Creating note",
     *         @OA\JsonContent (ref="#/components/schemas/note-resource"),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation errors",
     *     ),
     *     security={
     *          {"xsrf":{}, "session-id":{}}
     *     }
     * )
     */
    public function update(NoteRequest $request, $id): NoteResource
    {
        $note = Note::findOrFail($id);
        $note->update($request->validated());

        return new NoteResource($note);
    }

    /**
     * @OA\Delete(
     *     path="/notes/{noteId}",
     *     tags={"Notes"},
     *     @OA\Parameter(
     *         name="noteId",
     *         in="path",
     *         description="Note id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Note successfully removed",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *     ),
     *     security={
     *          {"xsrf":{}, "session-id":{}}
     *     }
     * )
     */
    public function destroy(Note $note): ?bool
    {
        return $note->deleteOrFail();
    }
}
