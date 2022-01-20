<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generations extends Model
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
    protected $fillable = ['generations','generationKey'];

    function gens() {
        return $this->hasMany('App\Models\Profiles', 'generations_id');
    }
}
