<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $notesForExactUser = Note::where(['created_by' => $request->user()->id])->get();
        return NoteResource::collection($notesForExactUser);
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

        $note = $validator->validated();
        return new NoteResource(
            Note::create($note)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return NoteResource|JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note was not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Note was not updated',
                'errors' => $validator->getMessageBag()->all()
            ], 422);
        }
        $note->update($validator->validated());

        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return JsonResponse
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
