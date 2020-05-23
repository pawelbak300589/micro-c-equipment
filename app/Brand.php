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
        'name', 'url', 'img'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function nameMappings()
    {
        return $this->hasMany(BrandNameMapping::class);
    }

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }
}
