<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Weather
 *
 * @property int $id
 * @property int $temperature
 * @property string $spec
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather whereSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Weather whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Weather extends Model
{
    protected $table = 'weathers';
}
