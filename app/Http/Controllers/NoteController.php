<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return NoteResource::collection(Note::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return NoteResource|JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Note was not created',
                'errors' => $validator->getMessageBag()->all()
            ], 422);
        }

        return new NoteResource(Note::create($validator->validated()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Note $note
     * @return NoteResource|JsonResponse
     */
    public function update(Request $request, Note $note)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Note was not updated',
                    'errors' => $validator->getMessageBag()->all()
                ],
                422
            );
        }
        $note->update($validator->validated());

        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     */
    public function destroy(Note $note)
    {
        if ($note->delete()) {
            return response()->json(['message' => 'Note was successfully removed'], 202);
        } else {
            return response()->json(['message' => 'Note was not removed'], 404);
        }
    }
}
