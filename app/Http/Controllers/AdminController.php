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

    public function showRegister() {
        $departments = Department::all();
        return view('admin.register', compact('departments'));
    }

    public function storeUser(Request $request) {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|string|max:20',
            'role'                  => 'required|in:admin,doctor,patient',
            'department_id'         => 'required_if:role,doctor|nullable|exists:departments,id',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $validated['role'];
        $user->department_id = ($validated['role'] === 'doctor') ? $validated['department_id'] : null;
        $user->password = bcrypt($validated['password']);
        $user->save();

        return redirect()->route('admin.register')->with('success', '🎉 User registered successfully as ' . ucfirst($validated['role']) . '!');
    }
}