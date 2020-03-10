<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function gears()
    {
        return $this->hasMany(Gear::class);
    }
}
