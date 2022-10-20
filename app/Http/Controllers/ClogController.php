<?php

namespace App\Http\Controllers;

use App\Models\Clog;
use Illuminate\Http\Request;

class ClogController extends Controller
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
        $clog = new Clog();

        $clog->current     = $request->current;
        $clog->button_name = $request->button_name;
        $clog->user_id     = $request->user_id;

        $clog->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clog  $clog
     * @return \Illuminate\Http\Response
     */
    public function show(Clog $clog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clog  $clog
     * @return \Illuminate\Http\Response
     */
    public function edit(Clog $clog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clog  $clog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clog $clog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clog  $clog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clog $clog)
    {
        //
    }
}
