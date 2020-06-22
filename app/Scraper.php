<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scraper extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'website',
        'started_at',
        'ended_at',
        'failed_at',
        'errors'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
