<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDocument extends Model
{
    use HasFactory;

    protected $table = 'appointment_document';

    protected $fillable = ['appointment_id','document_name'];
    protected $appends = ['document'];

    protected function getdocumentAttribute()
    {
        return url('images/upload/appointmentDocuments').'/'.$this->document_name;
    }

}