<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title', 'email', 'description', 'user_id', 'active', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
