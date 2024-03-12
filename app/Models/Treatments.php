<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Treatments extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'treatments';

    protected $fillable = ['name','image','status','order_by'];

    protected $appends = ['fullImage'];

    protected function getFullImageAttribute()
    {
        return url('images/upload').'/'.$this->image;
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category');
    }

    public function doctor()
    {
        return $this->hasMany('App\Models\Doctor');
    }
}
