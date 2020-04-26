<?php

namespace App\Http\Controllers;


use App\DeviceType;
use App\Services\DeviceService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $typeDevice = DeviceType::all()->sortBy('id');
        return view('crud.type.index', compact('typeDevice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.type.create');
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
            'type'=>'required',
        ]);

        $sensor = new DeviceType([
            'name'=>$request->get('name'),
            'type'=>$request->get('type'),
        ]);
        $sensor->save();

        (new DeviceService)->refresh();

        return redirect('/types')->with('success', 'Тип датчика сохранен!');
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
        $type = DeviceType::find($id);
        return view('crud.type.edit', compact('type'));
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
            'type'=>'required',
        ]);

        $sensor = DeviceType::find($id);
        $sensor->name = $request->get('name');
        $sensor->type = $request->get('type');
        $sensor->save();

        (new DeviceService)->refresh();

        return redirect('/types')->with([
            'success' => 'Тип датчика обновлен!',
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
        $contact = DeviceType::find($id);
        $contact->delete();

        (new DeviceService)->refresh();

        return redirect('/types')->with([
            'success' => 'Тип датчика удален!',
        ]);
    }
}
