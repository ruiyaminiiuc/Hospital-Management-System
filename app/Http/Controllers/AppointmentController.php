<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Department;

class AppointmentController extends Controller
{
    /**
     * Show appointment booking form.
     */
    public function book()
    {
        $doctors     = User::where('role', 'doctor')->with('department')->get();
        $departments = Department::all();
        return view('appointment.book', compact('doctors', 'departments'));
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'       => 'required|exists:users,id',
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'nullable|string',
            'notes'            => 'nullable|string|max:500',
        ]);

        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()->route('patients.dashboard')
            ->with('success', '✅ Appointment booked successfully! Awaiting approval.');
    }

    /**
     * List all appointments (admin/doctor view).
     */
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderByDesc('appointment_date')
            ->paginate(15);

        return view('appointment.index', compact('appointments'));
    }

    /**
     * Update appointment status (approve/cancel).
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled',
        ]);

        $appointment->update(['status' => $request->status]);

        return back()->with('success', '✅ Appointment status updated.');
    }
}
