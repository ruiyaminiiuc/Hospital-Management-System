<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Appointment;

class PatientController extends Controller
{
    // ─── Patient Dashboard ──────────────────────────────────────────

    /**
     * Show the logged-in patient's personal dashboard.
     */
    public function dashboard(Request $request)
    {
        // Use the authenticated user
        $patient = \Illuminate\Support\Facades\Auth::user();

        $appointments = Appointment::where('patient_id', optional($patient)->id)
            ->with('doctor')
            ->orderByDesc('appointment_date')
            ->get();

        $doctors     = User::where('role', 'doctor')->with('department')->get();
        $departments = Department::all();

        return view('patient.dashboard', compact('patient', 'appointments', 'doctors', 'departments'));
    }

    // ─── CRUD: Patient List ─────────────────────────────────────────

    /**
     * List all patients.
     */
    public function index(Request $request)
    {
        $search   = $request->get('search', '');
        $patients = User::where('role', 'patient')
            ->when($search, fn ($q) => $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%"))
            ->orderBy('name')
            ->paginate(10);

        $totalPatients      = User::where('role', 'patient')->count();
        $totalAppointments  = Appointment::count();

        return view('patient.index', compact('patients', 'search', 'totalPatients', 'totalAppointments'));
    }

    /**
     * List my patients for doctor.
     */
    public function myPatients(Request $request)
    {
        $search = $request->get('search', '');

        $query = User::where('role', 'patient')
            ->when($search, fn ($q) => $q->where(function($sq) use ($search) {
                $sq->where('name', 'like', "%$search%")
                   ->orWhere('email', 'like', "%$search%");
            }));

        // Filter by doctor's appointments
        $query->whereIn('id', function($q) {
            $q->select('patient_id')
              ->from('appointments')
              ->where('doctor_id', auth()->id());
        });

        $patients = $query->orderBy('name')->paginate(10);

        // Count for stats
        $totalPatients = User::where('role', 'patient')
            ->whereIn('id', function($q) {
                $q->select('patient_id')->from('appointments')->where('doctor_id', auth()->id());
            })->count();

        $totalAppointments = Appointment::where('doctor_id', auth()->id())->count();

        return view('doctor.my_patients', compact('patients', 'search', 'totalPatients', 'totalAppointments'));
    }

    // ─── CRUD: Create Patient ───────────────────────────────────────

    /**
     * Show the create-patient form.
     */
    public function create()
    {
        $departments = Department::all();
        $doctors     = User::where('role', 'doctor')->with('department')->get();
        return view('patient.create', compact('departments', 'doctors'));
    }

    /**
     * Store a new patient record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['role']     = 'patient';
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('patients.index')
            ->with('success', '✅ Patient registered successfully!');
    }

    // ─── CRUD: Edit Patient ─────────────────────────────────────────

    /**
     * Show the edit-patient form.
     */
    public function edit(User $patient)
    {
        $departments = Department::all();
        return view('patient.edit', compact('patient', 'departments'));
    }

    /**
     * Update patient record.
     */
    public function update(Request $request, User $patient)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', '✅ Patient updated successfully!');
    }

    // ─── CRUD: Delete Patient ───────────────────────────────────────

    /**
     * Delete a patient record.
     */
    public function destroy(User $patient)
    {
        // Also delete their appointments
        Appointment::where('patient_id', $patient->id)->delete();
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', '🗑️ Patient deleted successfully!');
    }
}
