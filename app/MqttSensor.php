<?php

namespace App;

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

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'type');
    }

    public function deviceLocation()
    {
        return $this->belongsTo(DeviceLocation::class, 'location');
    }

}
