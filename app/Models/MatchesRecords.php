<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchesRecords extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['stream_id', 'game', 'type', 'rule', 'participants', 'winner','result'];

    function records() {
        return $this->belongsTo('App\Models\Matches', 'stream_id','stream_number');
    }
}
