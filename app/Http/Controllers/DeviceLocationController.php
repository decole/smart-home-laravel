<?php

namespace App\Http\Controllers;

use App\DeviceLocation;
use App\Services\DeviceService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DeviceLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $locationDevices = DeviceLocation::all()->sortBy('id');
        return view('crud.location.index', compact('locationDevices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.location.create');
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
            'location'=>'required',
        ]);

        $sensor = new DeviceLocation([
            'name'=>$request->get('name'),
            'location'=>$request->get('location'),
        ]);
        $sensor->save();

        (new DeviceService)->refresh();

        return redirect('/locations')->with('success', 'Место расположения сохранено!');
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
        $location = DeviceLocation::find($id);
        $error = null;

        return view('crud.location.edit', compact('location'))->with('error');
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
            'location'=>'required',
        ]);

        $sensor = DeviceLocation::find($id);
        $sensor->name = $request->get('name');
        $sensor->location = $request->get('location');
        $sensor->save();

        (new DeviceService)->refresh();

        return redirect('/locations')->with([
            'success' => 'Место расположения обновлено!',
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
        $contact = DeviceLocation::find($id);
        $contact->delete();

        (new DeviceService)->refresh();

        return redirect('/locations')->with([
            'success' => 'Место расположения удалено!',
        ]);
    }
}
