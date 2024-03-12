<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistExpertise extends Model
{
    use HasFactory;

    protected $table = 'therapist_expertise';

    protected $fillable = ['expertise_id','doctor_user_id'];
}