<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistSpecializations extends Model
{
    use HasFactory;

    protected $table = 'therapist_specialization';

    protected $fillable = ['specialisation_id','doctor_user_id'];
}