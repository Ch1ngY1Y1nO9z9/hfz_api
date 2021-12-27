<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
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
    protected $fillable = ['type' , 'name_ch', 'name_en', 'content_ch', 'content_en', 'sort', 'img', 'created_at', 'updated_at'];

    public function ProductType()
    {
        return $this->belongsTo('App\ProductType', 'id');
    }

    protected $table = 'products';
}
