<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roll extends Model
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
    protected $fillable = ['rare' , 'img', 'name', 'intro'];

    protected $table = 'roll';
}
