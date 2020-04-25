<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\DeviceType;
use App\MqttRelay;
use App\Services\MqttService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class MqttRelayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $relays = MqttRelay::where('id', '>', 0)
            ->orderBy('id', 'asc')
            ->with(['devicetype','devicelocation'])
            ->paginate(15);

        return view('crud.relay.index', compact('relays'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.relay.create', [
            'locations' => self::locationsList(),
            'types' => self::typesList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'topic'=>'required',
        ]);

        MqttRelay::storeRelay($request);
        MqttService::createDataset('relays');

        return redirect('/relays')->with('success', 'Реле сохранено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
        $sensor = MqttRelay::find($id);

        return view('crud.relay.edit', [
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

        MqttRelay::updateRelay($id, $request);
        MqttService::createDataset('relays');

        return redirect('/relays')->with([
            'success' => 'Реле обновлено!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact = MqttRelay::find($id);
        $contact->delete();
        MqttService::createDataset('relays');

        return redirect('/relays')->with([
            'success' => 'Реле удалено!',
        ]);

    }
}
