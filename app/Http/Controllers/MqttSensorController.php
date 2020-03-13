<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\DeviceType;
use App\MqttSensor;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MqttSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $sensors = MqttSensor::where('id', '>', 0)
            ->orderBy('id', 'asc')
            ->with(['devicetype','devicelocation'])
            ->paginate(15);

        return view('sensor.index', compact('sensors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        return view('sensor.create', [
            'locations' => $locations,
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'topic'=>'required',
        ]);

        $sensor = new MqttSensor([
            'name'=>$request->get('name'),
            'topic'=>$request->get('topic'),
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
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $sensor = MqttSensor::find($id);

        return view('sensor.edit', compact('sensor'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'topic'=>'required',
        ]);

        $sensor = MqttSensor::find($id);
        $sensor->name = $request->get('name');
        $sensor->topic=$request->get('topic');
        $sensor->message_info=$request->get('message_info');
        $sensor->message_ok=$request->get('message_ok');
        $sensor->message_warn=$request->get('message_warn');
        $sensor->type=$request->get('type');
        $sensor->location=$request->get('location');
        $sensor->save();

        return redirect('/sensors')->with([
            'success' => 'Sensor updated!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy($id)
    {
        $contact = MqttSensor::find($id);
        $contact->delete();

        return redirect('/sensors')->with([
            'success' => 'Sensor deleted!',
        ]);

    }
}
