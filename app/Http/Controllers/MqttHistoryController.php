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
        $topic = 'greenhouse/temperature';
        $sensors = MqttHistory::where('topic', '=', $topic)
            ->orderBy('id', 'desc')
            ->paginate(50);

        return view('crud.payload_history.index', compact(['sensors', 'topic']));
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

    public function get(Request $request)
    {
        $now = $request->get('date');
        if (!$now){
            $now = Carbon::today();
        }
        if ($now) {
            $now = Carbon::createFromFormat('d-m-Y', $now);
        }

        $nameDB = MqttHistory::where('topic', '=', 'greenhouse/temperature')
            ->whereDay('created_at', $now)->get();
        $name = [];
        foreach ($nameDB as $valuen) {
            $name[] = $valuen['created_at']->format('H:i:s');
        }
        $dataset = [];
        foreach ($nameDB as $valued) {
            $dataset[] = intval($valued['payload']);
        }

        return response()->json([
            'label' => $name,
            'data' => $dataset
        ]);
    }

}
