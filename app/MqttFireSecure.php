<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttFireSecure
 *
 * @property int $id
 * @property string $name
 * @property string $topic
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
}
