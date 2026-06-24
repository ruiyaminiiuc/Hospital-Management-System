<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relationships ─────────────────────────────────────────────

    /** Appointments where this user is a patient */
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /** Appointments where this user is a doctor */
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /** Department the user (doctor) belongs to */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // ─── Helpers ───────────────────────────────────────────────────

    public function isAdmin():    bool { return $this->role === 'admin'; }
    public function isDoctor():   bool { return $this->role === 'doctor'; }
    public function isPatient():  bool { return $this->role === 'patient'; }
}
