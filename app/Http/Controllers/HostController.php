<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HostController extends Controller
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
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function show(Host $host)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function edit(Host $host)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Host $host)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function destroy(Host $host)
    {
        //
    }

    public function getDataById(Request $request)
    {
        $host = Host::find($request->host_id);

        return response()->json([
            "success" => true,
            "message" => "Host details founds",
            "data" => $host
        ], 200);
    }

    public function getRefByHost(Request $request)
    {
        $sqlTotal   = "SELECT COUNT(id) as total FROM users WHERE referred_by = $request->host_id";

        $sqlAbonati = "SELECT COUNT(id) as abonati FROM users WHERE referred_by = $request->host_id AND subscription != 0";

        $data = new \stdClass();

        $total = DB::select($sqlTotal);
        $abonati = DB::select($sqlAbonati);

        $data->total   = $total->total;
        $data->abonati = $abonati->abonati;

        return response()->json([
            "success" => true,
            "message" => "Host ref data",
            "data" => $data
        ], 200);
    }

}
