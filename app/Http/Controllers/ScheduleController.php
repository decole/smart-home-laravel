<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $scheduler = Schedule::where('id', '>', 0)
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('crud.scheduler.index', compact('scheduler'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('crud.scheduler.create');
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
            'command'=>'required',
            'interval'=>'required',
            'last_run'=>'nullable|date',
            'next_run'=>'nullable|date',
        ]);

        Schedule::storeSchedule($request);

        return redirect('/scheduler')->with('success', 'Задача успешно создана!');
    }

    /**
     * Display the specified resource.
     *
     * @param Schedule $schedule
     * @return Response
     */
    public function show(Schedule $schedule)
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
        $scheduler = Schedule::find($id);

        return view('crud.scheduler.edit', [
            'schedule' => $scheduler,
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
            'command'=>'required',
            'interval'=>'required',
            'last_run'=>'nullable|date',
            'next_run'=>'nullable|date',
        ]);

        Schedule::updateSchedule($request, $id);

        return redirect('/scheduler')->with([
            'success' => 'Задача обновлена!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contact = Schedule::find($id);
        $contact->delete();

        return redirect('/scheduler')->with([
            'success' => 'Задача удалена!',
        ]);
    }
}
