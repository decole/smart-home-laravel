<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DeviceType
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeviceType extends Model
{
    protected $table = 'type_devices';

    protected $fillable = [
        'name',
        'type',
    ];
}
