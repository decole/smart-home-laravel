<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttHistorySecure
 *
 * @property int $id
 * @property string $topic
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistorySecure whereValue($value)
 * @mixin \Eloquent
 */
class MqttHistorySecure extends Model
{
    protected $table = 'mqtt_history_secures';

    protected $fillable = [
        'id',
        'topic',
        'value',
        'created_at',
    ];

}
