<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MqttHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $topic
 * @property string $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MqttHistory whereUpdatedAt($value)
 */
class MqttHistory extends Model
{
    protected $table = 'mqtt_histories';

    protected $fillable = ['topic', 'payload'];
}
