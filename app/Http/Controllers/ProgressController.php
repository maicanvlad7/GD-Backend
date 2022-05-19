<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Lesson;

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

}
