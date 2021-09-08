<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
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
        return NoteResource::collection(Note::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return NoteResource
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
        ])->validate();

        return new NoteResource(Note::create($validated));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Note $note
     * @return NoteResource|Response
     */
    public function update(Request $request, Note $note)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response(
                ['errors' => $validator->getMessageBag()->all()], 201);
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
        $note->delete();
    }
}
