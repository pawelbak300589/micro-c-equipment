<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandImages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id', 'src', 'alt', 'main'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
