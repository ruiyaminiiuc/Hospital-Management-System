<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index() {
        // Fetch counts for dashboard cards
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalDepts = Department::count();
        $totalAppointments = Appointment::count();

        // Fetch list for the tables
        $departments = Department::all();
        $doctors = User::where('role', 'doctor')->get();

        return view('admin.dashboard', compact('totalDoctors', 'totalPatients', 'totalDepts', 'totalAppointments', 'departments', 'doctors'));
    }

    public function storeDepartment(Request $request) {
        $dept = new Department();
        $dept->name = $request->name;
        $dept->description = $request->description;
        $dept->save();
        return back()->with('success', 'Department Created!');
    }
}