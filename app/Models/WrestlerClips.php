<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WrestlerClips extends Model
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
    protected $fillable = ['wrestler_id','clip_title','embed_code', 'sort'];

    function clips() {
        return $this->belongsTo('App\Profiles', 'wrestler_id');
    }
}
