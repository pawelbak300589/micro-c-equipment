<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GearImages extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gear_id', 'src', 'alt', 'main'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function gear()
    {
        return $this->belongsTo(Gear::class);
    }
}
