<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\DeviceType;
use App\MqttSecure;
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
            ->with(['devicetype','devicelocation'])
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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        return view('crud.secure.create', [
            'locations' => $locations,
            'types' => $types,
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
        ]);

        $notifying = ($request->get('notifying') == 'state') ? true : false;
        $active    = ($request->get('active')    == 'state') ? true : false;
        $trigger   = ($request->get('trigger')    == 'state') ? true : false;
        $sensor = new MqttSecure([
            'name'=>$request->get('name'),
            'topic'=>$request->get('topic'),
            'trigger'=>$trigger,
            'current_command'=>$request->get('current_command'),
            'message_info'=>$request->get('message_info'),
            'message_ok'=>$request->get('message_ok'),
            'message_warn'=>$request->get('message_warn'),
            'type'=>$request->get('type'),
            'location'=>$request->get('location'),
            'notifying'=>$notifying,
            'active'=>$active,
        ]);

        $sensor->save();

        return redirect('/secure')->with('success', 'Датчик системы безопасности добавлен!');

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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        $sensor = MqttSecure::find($id);

        return view('crud.secure.edit', [
            'sensor' => $sensor,
            'locations' => $locations,
            'types' => $types,
        ]);

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
        ]);

        $notifying = ($request->get('notifying') == 'state') ? true : false;
        $active    = ($request->get('active')    == 'state') ? true : false;
        $trigger   = ($request->get('trigger')   == 'state') ? true : false;

        $sensor = MqttSecure::find($id);
        $sensor->name=$request->get('name');
        $sensor->topic=$request->get('topic');
        $sensor->trigger=$trigger;
        $sensor->current_command=$request->get('current_command');
        $sensor->message_info=$request->get('message_info');
        $sensor->message_ok=$request->get('message_ok');
        $sensor->message_warn=$request->get('message_warn');
        $sensor->type=$request->get('type');
        $sensor->location=$request->get('location');
        $sensor->notifying=$notifying;
        $sensor->active=$active;
        $sensor->save();

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

        return redirect('/secure')->with([
            'success' => 'Датчик системы безопасности удален!',
        ]);

    }
}
