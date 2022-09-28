<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
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
     * @param  \App\Models\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function show(Payout $payout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function edit(Payout $payout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payout $payout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payout  $payout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payout $payout)
    {
        //
    }

    public function markAsRequested(Request $request)
    {
        $payout = Payout::where('user_id', $request->uid)->first();

        $payout->requested = 1;

        if($payout->save()) {
            return response()->json([
                "success" => true,
                "message" => "Cererea de payout va fi procesată curând!",
            ], 200);
        }else  {
            return response()->json([
                "success" => false,
                "message" => "Cererea de payout nu a putut fi procesată!",
            ], 200);
        }
    }

    public function getByUserId(Request $request)
    {
        $payout = Payout::where('user_id', $request->user_id)->get();

        return response()->json([
            "success" => true,
            "message" => "Payout found for user!",
            "data"    => $payout,
        ], 200);
    }
}
