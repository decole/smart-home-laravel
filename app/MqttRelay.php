<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttRelay
 *
 * @property int $id
 * @property string $name
 * @property string $topic
 * @property string|null $check_topic
 * @property string|null $command_on
 * @property string|null $command_off
 * @property string|null $check_command_on
 * @property string|null $check_command_off
 * @property string|null $last_command
 * @property string|null $message_info
 * @property string|null $message_ok
 * @property string|null $message_warn
 * @property int|null $type
 * @property int|null $location
 * @property bool $notifying
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCheckCommandOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCheckCommandOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCheckTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCommandOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCommandOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereLastCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereMessageInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereMessageOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereMessageWarn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereNotifying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttRelay whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\DeviceLocation|null $devicelocation
 * @property-read \App\DeviceType|null $devicetype
 */
class MqttRelay extends Model
{
    protected $fillable = [
        'name',
        'topic',
        'check_topic',
        'command_on',
        'command_off',
        'check_command_on',
        'check_command_off',
        'last_command',
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
