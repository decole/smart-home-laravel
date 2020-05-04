<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HistoryWeight
 *
 * @property int $id
 * @property string $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HistoryWeight whereWeight($value)
 * @mixin \Eloquent
 */
class HistoryWeight extends Model
{
    protected $table = 'history_weights';

    protected $fillable = [
        'created_at',
        'weight',
    ];
}
