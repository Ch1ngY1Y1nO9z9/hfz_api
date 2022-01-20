<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fanbases extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['fan_name','weight','height','signature','finisher'];

    function oshi() {
        return $this->belongsTo('App\Models\Profiles', 'fan_name');
    }
}
