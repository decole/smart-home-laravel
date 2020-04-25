<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Notification
 *
 * @property int $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    protected $table = 'notifications';
}
