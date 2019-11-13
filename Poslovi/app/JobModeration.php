<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobModeration extends Model
{
    protected $fillable = [
        'email', 'posted_before'
    ];
    public $timestamps = false;
}
