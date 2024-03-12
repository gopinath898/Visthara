<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RadiologyCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'radiology_category';

    protected $fillable = ['name','status','description','category_id','sort'];

    public function category()
    {
        return $this->belongsTo('App\Models\FaqCategory','category_id','id');
    }
}
