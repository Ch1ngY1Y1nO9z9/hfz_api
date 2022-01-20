<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongsLists extends Model
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
    protected $fillable = ['stream_id', 'played_at', 'link'];

    function songlist() {
        return $this->belongsTo('App\Models\Matches', 'stream_id','stream_number');
    }
}
