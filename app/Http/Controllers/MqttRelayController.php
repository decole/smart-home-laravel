<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\DeviceType;
use App\MqttRelay;
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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        return view('crud.relay.create', [
            'locations' => $locations,
            'types' => $types,
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

        $notifying = ($request->get('notifying') == 'state') ? true : false;
        $active    = ($request->get('active')    == 'state') ? true : false;
        $sensor = new MqttRelay([
            'name'=>$request->get('name'),
            'topic'=>$request->get('topic'),
            'check_topic'=>$request->get('check_topic'),
            'command_on'=>$request->get('command_on'),
            'command_off'=>$request->get('command_off'),
            'check_command_on'=>$request->get('check_command_on'),
            'check_command_off'=>$request->get('check_command_off'),
            'last_command'=>$request->get('last_command'),
            'message_info'=>$request->get('message_info'),
            'message_ok'=>$request->get('message_ok'),
            'message_warn'=>$request->get('message_warn'),
            'type'=>$request->get('type'),
            'location'=>$request->get('location'),
            'notifying'=>$notifying,
            'active'=>$active,
        ]);

        $sensor->save();

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
        $types = DeviceType::all()->pluck('name', 'id');
        $locations = DeviceLocation::all()->pluck('name', 'id');
        $sensor = MqttRelay::find($id);

        return view('crud.relay.edit', [
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

        $sensor = MqttRelay::find($id);
        $sensor->name=$request->get('name');
        $sensor->topic=$request->get('topic');
        $sensor->check_topic=$request->get('check_topic');
        $sensor->command_on=$request->get('command_on');
        $sensor->command_off=$request->get('command_off');
        $sensor->check_command_on=$request->get('check_command_on');
        $sensor->check_command_off=$request->get('check_command_off');
        $sensor->last_command=$request->get('last_command');
        $sensor->message_info=$request->get('message_info');
        $sensor->message_ok=$request->get('message_ok');
        $sensor->message_warn=$request->get('message_warn');
        $sensor->type=$request->get('type');
        $sensor->location=$request->get('location');
        $sensor->notifying=$notifying;
        $sensor->active=$active;
        $sensor->save();

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

        return redirect('/relays')->with([
            'success' => 'Реле удалено!',
        ]);

    }
}
