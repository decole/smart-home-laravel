<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttHistoryWatering
 *
 * @property int $id
 * @property string $topic
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistoryWatering whereValue($value)
 * @mixin \Eloquent
 */
class MqttHistoryWatering extends Model
{
    protected $table = 'mqtt_history_waterings';

    protected $fillable = [
        'id',
        'topic',
        'value',
        'created_at',
    ];

}
