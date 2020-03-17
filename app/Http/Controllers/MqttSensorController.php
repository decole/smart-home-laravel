<?php

namespace App\Http\Controllers;

use App\MqttSensor;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        return view('crud.sensor.index', compact('sensors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.sensor.create', [
            'locations' => self::locationsList(),
            'types' => self::typesList(),
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

        $model = new MqttSensor;
        $model->storeSensor($request);

        return redirect('/sensors')->with('success', 'Датчик сохранен!');

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

        return view('crud.sensor.edit', [
            'sensor' => $sensor,
            'locations' => self::locationsList(),
            'types' => self::typesList(),
        ]);

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

        $model = new MqttSensor;
        $model->updateSensor($id, $request);

        return redirect('/sensors')->with([
            'success' => 'Датчик обновлен!',
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
            'success' => 'Датчик удален!',
        ]);

    }
}
