<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id', 'name', 'url'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
