<?php

namespace App\Http\Controllers;

use App\Models\favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
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
     * @param  \App\Models\favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function show(favorites $favorites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function edit(favorites $favorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, favorites $favorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\favorites  $favorites
     * @return \Illuminate\Http\Response
     */
    public function destroy(favorites $favorites)
    {
        //
    }

    public function controlFav(Request $request)
    {
        $favorite = favorites::where([
            ['course_id' ,'=', $request->course_id],
            ['user_id' ,'=', $request->user_id],
        ])->first();

        if($favorite === null) {

            $fav = new favorites();

            $fav->course_id = $request->course_id;
            $fav->user_id = $request->user_id;

            $fav->save();
            $message = 'Curs adăugat la favorite!';

        }else {

            $favorite = favorites::where([
                ['course_id' ,'=', $request->course_id],
                ['user_id' ,'=', $request->user_id],
            ])->delete();

            $message = 'Curs înlăturat de la favorite!';

        }

        return response()->json([
            "success" => true,
            "message" => $message,
        ], 200);

    }

    public function getFavorites(Request $request)
    {
        $favorite = favorites::select('course_id')->where('user_id', '=', $request->user_id)->get();

        return response()->json([
            "success" => true,
            "message" => 'Fav found',
            "data" => $favorite,
        ], 200);

    }
}
