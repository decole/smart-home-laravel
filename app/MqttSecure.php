<?php

namespace App;

use App\Services\DataService;
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

    /**
     * Store sensor
     *
     * @param \Illuminate\Http\Request $request
     */
    public function storeSecureSensor(\Illuminate\Http\Request $request)
    {
        $sensor = new self();
        $sensor = self::collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * Update sensor
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     */
    public function updateSecureSensor($id, \Illuminate\Http\Request $request)
    {
        $sensor = self::find($id);
        $sensor = self::collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * Вынос похожих рудиментов в отдельную функцию
     *
     * @param MqttFireSecure $sensor
     * @param \Illuminate\Http\Request $request
     * @return MqttSecure
     */
    protected function collecting(MqttSecure $sensor, \Illuminate\Http\Request $request)
    {
        $sensor->name            = $request->get('name');
        $sensor->topic           = $request->get('topic');
        $sensor->current_command = $request->get('current_command');
        $sensor->trigger         = DataService::getCheckboxValue('trigger', $request);
        $sensor->normal_condition= $request->get('normal_condition');
        $sensor->alarm_condition = $request->get('alarm_condition');
        $sensor->message_info    = $request->get('message_info');
        $sensor->message_ok      = $request->get('message_ok');
        $sensor->message_warn    = $request->get('message_warn');
        $sensor->type            = $request->get('type');
        $sensor->location        = $request->get('location');
        $sensor->notifying       = DataService::getCheckboxValue('notifying', $request);
        $sensor->active          = DataService::getCheckboxValue('active', $request);

        return $sensor;

    }
}
