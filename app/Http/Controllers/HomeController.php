<?php

namespace App\Http\Controllers;


use App\MqttFireSecure;
use App\MqttHistoryFireSecure;
use App\MqttHistorySecure;
use App\MqttHistoryWatering;
use App\MqttRelay;
use App\MqttSecure;
use App\MqttSensor;
use App\Notifications\UserNotify;
use App\Services\WateringService;
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
            'relays' => MqttRelay::where('active', 'true')->get(),
            'sensors' => MqttSensor::all(),
        ]);
    }

    public function secure()
    {
        $secSensors = MqttSecure::all();
        $history = MqttHistorySecure::orderBy('created_at', 'desc')->paginate(7);

        return view('page.secure', [
            'sensors' => $secSensors,
            'history' => $history,
        ]);
    }

    public function firesecure()
    {
        $fireSensors = MqttFireSecure::all();
        $history = MqttHistoryFireSecure::orderBy('created_at', 'desc')->paginate(7);
        return view('page.firesecure', [
            'sensors' => $fireSensors,
            'history' => $history,
        ]);
    }

    public function watering()
    {
        $state = (new WateringService)->getStateOnSite();
        $history = MqttHistoryWatering::orderBy('created_at', 'desc')->paginate(7);

        return view('page.autowattering', [
            'state'  => $state,
            'history' => $history,
        ]);
    }

    public function settings()
    {
        return view('page.settings', [
            'relays' => MqttRelay::where('topic', 'margulis/lamp01')->first(),
        ]);
    }

    public function contacts()
    {
        $model1 = new MqttHistoryWatering();
        $model2 = new MqttHistorySecure();
        $model3 = new MqttHistoryFireSecure();
        $model3->value = $model2->value = $model1->value = 'lol';
        $model3->topic = $model2->topic = $model1->topic = 'test';
        $model1->save(); $model2->save(); $model3->save();
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
