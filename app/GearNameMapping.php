<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GearNameMapping extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gear_id', 'name'
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
