<?php

namespace App\Http\Controllers;


use App\MqttSecure;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class SecureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $secures = MqttSecure::where('id', '>', 0)
            ->orderBy('id', 'asc')
            ->with(['devicetype', 'devicelocation'])
            ->paginate(15);

        return view('crud.secure.index', compact('secures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('crud.secure.create', [
            'locations' => self::locationsList(),
            'types' => self::typesList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'topic' => 'required',
        ]);

        MqttSecure::storeSecureSensor($request);
        (new DeviceService)->refresh();

        return redirect('/secure')->with('success', 'Датчик системы безопасности добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $sensor = MqttSecure::find($id);

        return view('crud.secure.edit', [
            'sensor' => $sensor,
            'locations' => self::locationsList(),
            'types' => self::typesList(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'topic' => 'required',
        ]);

        MqttSecure::updateSecureSensor($id, $request);
        (new DeviceService)->refresh();

        return redirect('/secure')->with([
            'success' => 'Датчик системы безопасности обновлен!',
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
        $contact = MqttSecure::find($id);
        $contact->delete();
        (new DeviceService)->refresh();

        return redirect('/secure')->with([
            'success' => 'Датчик системы безопасности удален!',
        ]);
    }

}
