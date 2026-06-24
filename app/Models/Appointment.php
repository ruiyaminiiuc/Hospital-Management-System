<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    /** The patient for this appointment */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /** The doctor for this appointment */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
