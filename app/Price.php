<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id', 'gear_id', 'price'
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

    public function gear()
    {
        return $this->belongsTo(Gear::class);
    }
}
