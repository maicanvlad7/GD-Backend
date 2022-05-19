<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    //
    public function getAllByCourseId(Request $request)
    {

        $sql = "SELECT
                  questions.content AS intrebare,
                  questions.id AS id_intrebare,
                  users.id AS id_utilizator,
                  users.name AS nume_utilizator,
                  answers.content AS raspuns,
                  answers.id AS id_raspuns
                FROM
                  questions
                  LEFT JOIN answers ON questions.id = answers.question_id
                  INNER JOIN users ON questions.user_id = users.id
                WHERE
                  questions.course_id = $request->course_id";

        $result = DB::select($sql);

        return response()->json([
            'success' => true,
            'message' => 'Questions found',
            'data' => $result
        ], Response::HTTP_OK);

    }

    public function addQuestionToCourse(Request $request)
    {
        $question = new Question();

        $question->content   = $request->content_details;
        $question->course_id = $request->course_id;
        $question->user_id   = $request->user_id;

        if($question->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Question added succesffully',
            ], Response::HTTP_OK);
        }

    }
}
