<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Host;
use App\Models\Landing;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function getBySlug(Request $request)
    {
            $landing = Landing::where('slug', $request->slug)->first();

            if($landing === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acest landing page nu exista, veti fi redirectionat'
                ], 404);
            }

            $course = Course::select('name','host','id')->where('id', $landing->course_id)->first();

            $host = Host::where('id', $course->host)->first();

            $lessons = Lesson::select('name')->where('course_id', $course->id)->where('is_sample', 0)->get();

            $resp = new \stdClass();
            $resp->landing = $landing;
            $resp->host    = $host;
            $resp->lessons = $lessons;

            return response()->json([
                'success' => true,
                'message' => 'Landing gasit cu succes',
                'data'    => $resp,
            ], 200);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function show(Landing $landing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function edit(Landing $landing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Landing $landing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Landing $landing)
    {
        //
    }
}
