<?php

namespace App;

use App\Services\DataService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

/**
 * App\MqttFireSecure
 *
 * @property int $id
 * @property string $name
 * @property string $topic
 * @property string|null $message_info
 * @property string|null $message_ok
 * @property string|null $message_warn
 * @property string|null $normal_condition
 * @property string|null $alarm_condition
 * @property int|null $type
 * @property int|null $location
 * @property bool|null $notifying
 * @property bool|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\DeviceLocation|null $devicelocation
 * @property-read \App\DeviceType|null $devicetype
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereMessageInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereMessageOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereMessageWarn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereNotifying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttFireSecure whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MqttFireSecure extends Model
{
    protected $table = 'mqtt_fire_secure';

    protected $fillable = [
        'name',
        'topic',
        'message_info',
        'message_ok',
        'message_warn',
        'type',
        'location',
        'notifying',
        'active',
    ];

    public function devicetype()
    {
        return $this->belongsTo(DeviceType::class, 'type');
    }

    public function devicelocation()
    {
        return $this->belongsTo(DeviceLocation::class, 'location');
    }

    /**
     * Update sensor
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     */
    public function updateFireSecureSensor($id, \Illuminate\Http\Request $request)
    {
        $sensor = self::find($id);
        $sensor = self::collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function storeFireSecureSensor(\Illuminate\Http\Request $request)
    {
        $sensor = new self();
        $sensor = self::collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * Вынос похожих рудиментов в отдельную функцию
     *
     * @param MqttFireSecure $sensor
     * @param \Illuminate\Http\Request $request
     * @return MqttFireSecure
     */
    protected function collecting(MqttFireSecure $sensor, \Illuminate\Http\Request $request)
    {
        $sensor->name         = $request->get('name');
        $sensor->topic        = $request->get('topic');
        $sensor->message_info = $request->get('message_info');
        $sensor->message_ok   = $request->get('message_ok');
        $sensor->message_warn = $request->get('message_warn');
        $sensor->type         = $request->get('type');
        $sensor->location     = $request->get('location');
        $sensor->normal_condition    = $request->get('normal_condition');
        $sensor->alarm_condition     = $request->get('alarm_condition');
        $sensor->notifying    = DataService::getCheckboxValue('notifying', $request);
        $sensor->active       = DataService::getCheckboxValue('active', $request);

        return $sensor;

    }

}
