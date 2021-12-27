<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WrestlerData extends Model
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
    protected $fillable = ['wrestler_id','birth_day','debut','weight','fan_name','signature','finisher','tag_with','team_name'];

    function data() {
        return $this->belongsTo('App\Profiles', 'wrestler_id');
    }
}
