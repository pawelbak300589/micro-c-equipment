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
        'name'
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

    public function images()
    {
        return $this->hasMany(BrandImages::class);
    }

    public function urls()
    {
        return $this->hasMany(BrandUrls::class);
    }

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }
}
