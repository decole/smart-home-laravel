<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttSecure
 *
 * @property int $id
 * @property string $name
 * @property string $topic
 * @property bool|null $trigger
 * @property string|null $current_command
 * @property string|null $message_info
 * @property string|null $message_ok
 * @property string|null $message_warn
 * @property int|null $type
 * @property int|null $location
 * @property bool|null $notifying
 * @property bool|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\DeviceLocation|null $devicelocation
 * @property-read \App\DeviceType|null $devicetype
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereCurrentCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereMessageInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereMessageOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereMessageWarn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereNotifying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereTrigger($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttSecure whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MqttSecure extends Model
{
    protected $table = 'mqtt_secure';

    protected $fillable = [
        'name',
        'topic',
        'trigger',
        'current_command',
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
}
