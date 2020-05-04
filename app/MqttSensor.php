<?php

namespace App;

use App\Services\DataService;
use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttSensor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $topic
 * @property string $message_info
 * @property string $message_ok
 * @property string $message_warn
 * @property int $type
 * @property int $location
 * @property int $to_condition
 * @property int $from_condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereMessageInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereMessageOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereMessageWarn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereUpdatedAt($value)
 * @property-read \App\DeviceLocation|null $devicelocation
 * @property-read \App\DeviceType|null $devicetype
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereFromCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSensor whereToCondition($value)
 */
class MqttSensor extends Model
{
    protected $table = 'mqtt_sensors';

    protected $fillable = [
        'name',
        'topic',
        'message_info',
        'message_ok',
        'message_warn',
        'type',
        'location',
    ];

    public function devicetype()
    {
        return $this->belongsTo(DeviceType::class, 'type');
    }

    public function devicelocation()
    {
        return $this->belongsTo(DeviceLocation::class, 'location');
    }

    public static function storeSensor(\Illuminate\Http\Request $request)
    {
        $sensor = new self();
        $sensor->collecting($sensor, $request);
        $sensor->save();
    }

    public static function updateSensor(int $id, \Illuminate\Http\Request $request)
    {
        $sensor = self::find($id);
        $sensor->collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * Вынос похожих рудиментов в отдельную функцию
     *
     * @param MqttFireSecure $sensor
     * @param \Illuminate\Http\Request $request
     * @return MqttSensor
     */
    protected function collecting(MqttSensor $sensor, \Illuminate\Http\Request $request)
    {
        /** @var MqttSensor $sensor */
        $sensor->name         = $request->get('name');
        $sensor->topic        = $request->get('topic');
        $sensor->message_info = $request->get('message_info');
        $sensor->message_ok   = $request->get('message_ok');
        $sensor->message_warn = $request->get('message_warn');
        $sensor->type         = $request->get('type');
        $sensor->location     = $request->get('location');
        $sensor->from_condition = $request->get('from_condition');
        $sensor->to_condition   = $request->get('to_condition');
        //$sensor->notifying    = DataService::getCheckboxValue('notifying', $request);
        //$sensor->active       = DataService::getCheckboxValue('active', $request);
        return $sensor;
    }

}
