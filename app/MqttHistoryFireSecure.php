<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttHistoryFireSecure
 *
 * @property int $id
 * @property string $topic
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryFireSecure whereValue($value)
 * @mixin \Eloquent
 */
class MqttHistoryFireSecure extends Model
{
    protected $table = 'mqtt_history_fire_secures';

    protected $fillable = [
        'id',
        'topic',
        'value',
        'created_at',
    ];

}
