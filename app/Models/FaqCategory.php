<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faq_category';

    protected $fillable = ['name','status','sort_cat'];
}
