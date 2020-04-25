<?php

namespace App\Http\Controllers;

use App\MqttFireSecure;
use App\Services\MqttService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class FireSecureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $secures = MqttFireSecure::where('id', '>', 0)
            ->orderBy('id', 'asc')
            ->with(['devicetype','devicelocation'])
            ->paginate(15);

        return view('crud.firesecure.index', compact('secures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
         return view('crud.firesecure.create', [
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

        MqttFireSecure::storeFireSecureSensor($request);
        MqttService::createDataset('fire_secure');

        return redirect('/fire_secure')->with('success', 'Датчик противопожарной системы безопасности добавлен!');
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
     * @return Factory|View
     */
    public function edit($id)
    {
        $sensor = MqttFireSecure::find($id);

        return view('crud.firesecure.edit', [
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

        MqttFireSecure::updateFireSecureSensor($id, $request);
        MqttService::createDataset('fire_secure');

        return redirect('/fire_secure')->with([
            'success' => 'Датчик противопожарной системы безопасности обновлен!',
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
        $contact = MqttFireSecure::find($id);
        $contact->delete();
        MqttService::createDataset('fire_secure');

        return redirect('/fire_secure')->with([
            'success' => 'Датчик противопожарной системы безопасности удален!',
        ]);
    }
}
