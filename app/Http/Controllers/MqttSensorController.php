<?php

namespace App\Http\Controllers;

use App\MqttSensor;
use Illuminate\Http\Request;

class MqttSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sensors = MqttSensor::all();
        $error = null;
        return view('sensor.index', compact('sensors'))->with('error');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sensor.create', [
            'error'=>null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'topic'=>'required',
            'payload'=>'required',
            'message_info'=>'required',
            'message_ok'=>'required',
            'message_warn'=>'required',
            'type'=>'required',
            'location'=>'required',
        ]);

        $sensor = new MqttSensor([
            'name'=>$request->get('name'),
            'topic'=>$request->get('topic'),
            'payload'=>$request->get('payload'),
            'message_info'=>$request->get('message_info'),
            'message_ok'=>$request->get('message_ok'),
            'message_warn'=>$request->get('message_warn'),
            'type'=>$request->get('type'),
            'location'=>$request->get('location'),

        ]);
        $sensor->save();

        return redirect('/sensors')->with('success', 'Sensor saved!');

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $sensor = MqttSensor::find($id);
        $error = null;
        return view('sensor.edit', compact('sensor'))->with('error');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'topic'=>'required',
            'payload'=>'required',
            'message_info'=>'required',
            'message_ok'=>'required',
            'message_warn'=>'required',
            'type'=>'required',
            'location'=>'required',
        ]);

        $sensor = MqttSensor::find($id);
        $sensor->name = $request->get('name');
        $sensor->topic=$request->get('topic');
        $sensor->payload=$request->get('payload');
        $sensor->message_info=$request->get('message_info');
        $sensor->message_ok=$request->get('message_ok');
        $sensor->message_warn=$request->get('message_warn');
        $sensor->type=$request->get('type');
        $sensor->location=$request->get('location');
        $sensor->save();

        return redirect('/sensors')->with([
            'success' => 'Sensor updated!',
            'error' => null,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact = MqttSensor::find($id);
        $contact->delete();

        return redirect('/sensors')->with('success', 'Sensor deleted!');
    }
}
