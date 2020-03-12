<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DeviceLocation
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeviceLocation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeviceLocation extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'name',
        'location',
    ];
}
