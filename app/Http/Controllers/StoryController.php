<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use http\Env\Response;

class StoryController extends Controller
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
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
    }

    public function getHomePageStories()
    {
        $stories =  Story::orderBy('id', 'desc')->take(5)->get();

        return response()->json([
            "success" => true,
            "message" => "Stories for home page found",
            "data" => $stories,
        ], 200);

    }

    public function getAll()
    {
        $stories =  Story::all();

        return response()->json([
            "success" => true,
            "message" => "Stories found",
            "data" => $stories,
        ], 200);
    }

    public function getStoryById(Request $request)
    {
        $story =  Story::where('id', $request->id_story)->first();

        if($story) {
            return response()->json([
                "success" => true,
                "message" => "Story details found",
                "data" => $story
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Story does not exist"
            ], 200);
        }
    }
}
