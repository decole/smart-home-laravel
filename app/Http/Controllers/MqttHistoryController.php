<?php

namespace App\Http\Controllers;

use App\MqttHistory;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MqttHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $sensors = MqttHistory::where('topic', '=', 'greenhouse/temperature')
            ->orderBy('id', 'desc')
            ->paginate(50);



        return view('crud.payload_history.index', compact(['sensors']));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get()
    {
        $now = Carbon::today();
        $nameDB = MqttHistory::where('topic', '=', 'greenhouse/temperature')
            ->whereDay('created_at', $now)->get();
        $name = [];
        foreach ($nameDB as $valuen) {
            $name[] = $valuen['created_at']->format('d-m-Y');
        }

        $datasetDB = MqttHistory::where('topic', '=', 'greenhouse/temperature')
            ->whereDay('created_at', $now)->get();
        $dataset = [];
        foreach ($datasetDB as $valued) {
            $dataset[] = intval($valued['payload']);
        }

        return response()->json([
            'label' => $name,
            'data' => $dataset
        ]);


    }

}
