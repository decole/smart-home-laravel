<?php

namespace App;

use App\Services\DataService;
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

    /**
     * Store relay
     *
     * @param \Illuminate\Http\Request $request
     */
    public static function storeRelay(\Illuminate\Http\Request $request)
    {
        $sensor = new self();
        $sensor->collecting($sensor, $request);
        $sensor->save();
    }

    /**
     * Update relay
     *
     * @param $id
     * @param \Illuminate\Http\Request $request
     */
    public static function updateRelay($id, \Illuminate\Http\Request $request)
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
     * @return MqttRelay
     */
    protected function collecting(MqttRelay $sensor, \Illuminate\Http\Request $request)
    {
        $sensor->name              = $request->get('name');
        $sensor->check_topic       = $request->get('check_topic');
        $sensor->command_on        = $request->get('command_on');
        $sensor->command_off       = $request->get('command_off');
        $sensor->check_command_on  = $request->get('check_command_on');
        $sensor->check_command_off = $request->get('check_command_off');
        $sensor->last_command      = $request->get('last_command');
        $sensor->topic             = $request->get('topic');
        $sensor->message_info      = $request->get('message_info');
        $sensor->message_ok        = $request->get('message_ok');
        $sensor->message_warn      = $request->get('message_warn');
        $sensor->type              = $request->get('type');
        $sensor->location          = $request->get('location');
        $sensor->notifying         = DataService::getCheckboxValue('notifying', $request);
        $sensor->active            = DataService::getCheckboxValue('active', $request);

        return $sensor;
    }

    public static function logChangeState($topic, $value)
    {
        $model = new MqttHistoryWatering();
        $model->topic = $topic;
        $model->value = $value;
        $model->save();
    }

}
