<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getByCourseId(Request $request)
    {
        $sql = "SELECT * FROM lessons LEFT JOIN notes ON lessons.id = notes.lesson_id
                WHERE lessons.course_id = $request->course_id AND notes.user_id = $request->user_id";

        $query = DB::select($sql);

        return response()->json([
            'success' => true,
            'message' => 'Notes found',
            'data' => $query
        ], Response::HTTP_OK);

    }

    public function getByLessonId(Request $request)
    {
        $notes = Note::where('user_id', $request->user_id)
                     ->where('lesson_id', $request->lesson_id)
                     ->first();

        return response()->json([
            'success' => true,
            'message' => 'Note found',
            'data' => $notes
        ], Response::HTTP_OK);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('user_id','lesson_id','note');

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'lesson_id' => 'required',
            'note' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

       $note = Note::updateOrCreate(
           ['user_id' => $request->user_id, 'lesson_id' => $request->lesson_id],
           ['content' => $request->note]
       );

        return response()->json([
            'success' => true,
            'message' => 'Note added!',
            'data' => $note
        ], Response::HTTP_OK);


        //Product created, return success response

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Note $note)
    {
        //
        $note = Note::find($request->note_id);

        if($note->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted',
            ], Response::HTTP_OK);
        }
    }
}
