<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    //
    public function updateUserProgress(Request $request)
    {
        $lesson = $request->lesson;

        $progress  = Progress::where(
            [
                'user_id' => $request->user_id,
                'lesson_id' => $lesson['id']
            ]
        )->first();

        if(isset($progress->percent)) {
            $progress->percent   = $lesson['progress']['percent'];
            $progress->completed = $lesson['progress']['completed'];
            $progress->save();
        } else {
            $newProgress = new Progress();

            $newProgress->lesson_id = $lesson['id'];
            $newProgress->user_id   = $request->user_id;
            $newProgress->course_id = $lesson['course_id'];
            $newProgress->percent   = $lesson['progress']['percent'];
            $newProgress->completed = $lesson['progress']['completed'];

            $newProgress->save();

        }

    }

    public function getWatching(Request $request)
    {

        $sql = "SELECT courses.*,
                hosts.name
                FROM courses
                INNER JOIN hosts ON courses.host = hosts.id
                 WHERE courses.id 
                IN(
                    SELECT course_id FROM progress WHERE user_id = $request->user_id
                    GROUP BY course_id
                )";

        $result = DB::select($sql);

        return response()->json([
            "success" => true,
            "message" => "Continue watching found",
            "data" => $result
        ], 200);

    }

}
