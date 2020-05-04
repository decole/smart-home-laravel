<?php

namespace App\Http\Controllers;

use App\HistoryWeight;
use Illuminate\Http\Request;

class HistoryWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weights = HistoryWeight::orderBy('created_at', 'desc')->paginate(15);
        return view('crud.weight.index', compact('weights'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.weight.create');
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
            'weight'=>'required',
        ]);

        $model = new HistoryWeight();
        $model->weight = str_replace(',','.',$request->get('weight'));
        $model->save();

        return redirect('/weight')->with('success', 'Вес добавлен!');
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
        $weight = HistoryWeight::find($id);

        return view('crud.weight.edit', [
            'weight' => $weight,
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
            'weight'=>'required',
        ]);

        /** @var HistoryWeight $model */
        $model = HistoryWeight::find($id);
        $model->weight = str_replace(',','.',$request->get('weight'));
        $model->save();

        return redirect('/weight')->with([
            'success' => 'Вес обновлен!',
        ]);
    }

    public function destroy($id)
    {
        $contact = HistoryWeight::find($id);
        $contact->delete();

        return redirect('/weight')->with([
            'success' => 'Показание веса удалено!',
        ]);
    }
}
