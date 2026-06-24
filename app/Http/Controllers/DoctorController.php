<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function dashboard() {
        // This sends data to your dashboard boxes
        $totalPatients = Appointment::distinct('patient_name')->count();
        $todayApps = Appointment::whereDate('appointment_date', now())->count();
        return view('doctor.dashboard', compact('totalPatients', 'todayApps'));
    }

    public function appointments() {
        $appointments = Appointment::all();
        return view('doctor.appointments', compact('appointments'));
    }

    public function schedule() {
        $schedules = Schedule::all();
        return view('doctor.schedule', compact('schedules'));
    }
    
    public function profile() {
        $departments = Department::all();
        return view('doctor.profile', compact('departments'));
    }
}