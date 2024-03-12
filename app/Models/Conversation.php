<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $casts = [
        'user_id'    => 'integer',
        'checked'    => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
