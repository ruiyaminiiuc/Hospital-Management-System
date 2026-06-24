<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display Appointment Page
     */
    public function index()
    {
        $appointments = Appointment::all();

        $totalAppointments = Appointment::count();

        $pendingAppointments = Appointment::where(
            'status',
            'Pending'
        )->count();

        $approvedAppointments = Appointment::where(
            'status',
            'Approved'
        )->count();

        return view(
            'appointments',
            compact(
                'appointments',
                'totalAppointments',
                'pendingAppointments',
                'approvedAppointments'
            )
        );
    }

    /**
     * Store Appointment
     */
    public function store(Request $request)
    {
        Appointment::create([
            'patient_name' => $request->patient_name,
            'doctor_name' => $request->doctor_name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'Pending'
        ]);

        return back();
    }

    /**
     * Approve Appointment
     */
    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->status = 'Approved';

        $appointment->save();

        return back();
    }

    /**
     * Cancel Appointment
     */
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->status = 'Cancelled';

        $appointment->save();

        return back();
    }

    public function create()
    {
        //
    }

    public function show(Appointment $appointment)
    {
        //
    }

    public function edit(Appointment $appointment)
    {
        //
    }

    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    public function destroy(Appointment $appointment)
    {
        //
    }
}