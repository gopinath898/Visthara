<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscription';

    protected $fillable = ['name','plan','total_appointment','description','first_description','price','duration','discount'];
    protected $appends = ['finalAmount','discountPrice'];

    public function DoctorSubscription()
    {
        return $this->hasOne('App\Models\DoctorSubscription');
    }

    protected function getdiscountPriceAttribute()
    {
        return intval($this->price*($this->discount/100));
    }

    protected function getfinalAmountAttribute()
    {
        return $this->price - intval($this->price*($this->discount/100));
    }
}
