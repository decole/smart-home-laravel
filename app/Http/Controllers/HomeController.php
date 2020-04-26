<?php

namespace App\Http\Controllers;


use App\MqttRelay;
use App\MqttSensor;
use App\Notifications\UserNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $comment = 'Это сообщение отправлено из формы обратной связи';
        //Notification::send(Auth::user(), new UserNotify($comment));

        return view('index', [
            'success' => Auth::user()->email,
        ]);
    }

    /**
     * Show margulis room
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function margulis()
    {
        return view('page.margulis', [
            'relays' => MqttRelay::where('topic', 'margulis/lamp01')->first(),
            'sensors' => MqttSensor::where('topic', 'margulis/temperature')
                ->orWhere('topic', 'margulis/humidity')
                ->orderBy('id')
                ->get(),
        ]);
    }

    /**
     * Show all data sensors and relays
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allData()
    {
        return view('page.all_data', [
            'relays' => MqttRelay::where('active', 'true')->get(),//MqttRelay::all(),
            'sensors' => MqttSensor::all(),
        ]);
    }

    public function secure()
    {
        return view('page.secure');
    }

    public function firesecure()
    {
        return view('page.firesecure');
    }

    public function watering()
    {
        return view('page.autowattering');
    }

    public function settings()
    {
        return view('page.settings');
    }

    public function contacts()
    {
        return view('page.contacts');
    }

    public function notifications()
    {
        return view('page.notifications');
    }

    public function messages()
    {
        return view('page.messages');
    }

}
