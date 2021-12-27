<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
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
    protected $fillable = ['stream_number', 'context1', 'context2', 'context3', 'link', 'background_image', 'date'];

    function records() {
        return $this->hasMany('App\MatchesRecords','stream_id','stream_number');
    }

    function songlist() {
        return $this->hasMany('App\SongsLists', 'stream_id','stream_number');
    }
}
