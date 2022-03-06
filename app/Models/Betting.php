<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Betting extends Model
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
    protected $fillable = ['match_id', 'betting_data', 'total_bet', 'users', 'visible', 'open'];

    protected $table = 'betting';

    function match_detail() {
        return $this->belongsTo('App\Models\MatchesRecords', 'match_id', 'id');
    }
}
