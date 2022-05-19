<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function destroy(Request $request, Review $review)
    {
        //
        $review = Review::find($request->review_id);

        if($review->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Review deleted',
            ], Response::HTTP_OK);
        }
    }

    public function getByCourseId(Request $request)
    {
        $reviews = Review::rightJoin('users', 'reviews.user_id', '=', 'users.id')
                ->where('course_id', $request->course_id)
                ->select('reviews.*','users.name','users.email')
                ->get();

        foreach($reviews as $rev) {
            $rev->user = new \stdClass();
            $rev->user->name = $rev->name;
        }


        //in order to maintain same data structure
        $failProof = new \stdClass();

        $failProof->reviews = $reviews;



        return response()->json([
            'success' => true,
            'message' => 'Reviews refreshed',
            'data'    => $failProof,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->only('user_id','course_id','revcontent');

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'course_id' => 'required',
            'revcontent' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $review = new Review();

        $review->user_id = $request->user_id;
        $review->course_id = $request->course_id;
        $review->content = $request->revcontent;
        $review->rating  = 5;

        if($review->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Review added!',
                'data' => $review
            ], Response::HTTP_OK);
        };

        //Product created, return success response

    }
}
