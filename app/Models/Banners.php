<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
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
    protected $fillable = ['img', 'alt', 'sort'];

    protected $table = 'banners';
}
