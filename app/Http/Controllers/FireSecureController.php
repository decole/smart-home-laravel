<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\DeviceType;
use App\MqttFireSecure;
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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        return view('crud.firesecure.create', [
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

        $notifying = ($request->get('notifying') == 'state') ? true : false;
        $active    = ($request->get('active')    == 'state') ? true : false;
        $sensor = new MqttFireSecure([
            'name'=>$request->get('name'),
            'topic'=>$request->get('topic'),
            'message_info'=>$request->get('message_info'),
            'message_ok'=>$request->get('message_ok'),
            'message_warn'=>$request->get('message_warn'),
            'type'=>$request->get('type'),
            'location'=>$request->get('location'),
            'notifying'=>$notifying,
            'active'=>$active,
        ]);

        $sensor->save();

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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        $sensor = MqttFireSecure::find($id);

        return view('crud.firesecure.edit', [
            'sensor' => $sensor,
            'locations' => $locations,
            'types' => $types,
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

        $notifying = ($request->get('notifying') == 'state') ? true : false;
        $active    = ($request->get('active')    == 'state') ? true : false;

        $sensor = MqttFireSecure::find($id);
        $sensor->name=$request->get('name');
        $sensor->topic=$request->get('topic');
        $sensor->message_info=$request->get('message_info');
        $sensor->message_ok=$request->get('message_ok');
        $sensor->message_warn=$request->get('message_warn');
        $sensor->type=$request->get('type');
        $sensor->location=$request->get('location');
        $sensor->notifying=$notifying;
        $sensor->active=$active;
        $sensor->save();

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

        return redirect('/fire_secure')->with([
            'success' => 'Датчик противопожарной системы безопасности удален!',
        ]);
    }
}
