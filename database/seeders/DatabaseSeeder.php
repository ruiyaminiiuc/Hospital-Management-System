<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo HMS data.
     */
    public function run(): void
    {
        // ─── Departments ─────────────────────────────────────────────────
        $cardiology  = Department::create(['name' => 'Cardiology',  'description' => 'Heart and cardiovascular care']);
        $neurology   = Department::create(['name' => 'Neurology',   'description' => 'Brain and nervous system treatment']);
        $orthopedics = Department::create(['name' => 'Orthopedics', 'description' => 'Bone, joint and muscle care']);
        $general     = Department::create(['name' => 'General',     'description' => 'General medical care']);

        // ─── Admin ───────────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hms.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '+880 1700000001',
        ]);

        // ─── Doctors ─────────────────────────────────────────────────────
        $doc1 = User::create([
            'name'          => 'Dr. John Smith',
            'email'         => 'doctor@hms.com',
            'password'      => Hash::make('password'),
            'role'          => 'doctor',
            'phone'         => '+880 1700000002',
            'department_id' => $cardiology->id,
        ]);

        $doc2 = User::create([
            'name'          => 'Dr. Sarah Khan',
            'email'         => 'sarah@hms.com',
            'password'      => Hash::make('password'),
            'role'          => 'doctor',
            'phone'         => '+880 1700000003',
            'department_id' => $neurology->id,
        ]);

        $doc3 = User::create([
            'name'          => 'Dr. Rafiq Ahmed',
            'email'         => 'rafiq@hms.com',
            'password'      => Hash::make('password'),
            'role'          => 'doctor',
            'phone'         => '+880 1700000004',
            'department_id' => $orthopedics->id,
        ]);

        // ─── Patients ────────────────────────────────────────────────────
        $pat1 = User::create([
            'name'     => 'Rahim Miah',
            'email'    => 'patient@hms.com',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'phone'    => '+880 1711111111',
        ]);

        $pat2 = User::create([
            'name'     => 'Karim Hossain',
            'email'    => 'karim@hms.com',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'phone'    => '+880 1722222222',
        ]);

        $pat3 = User::create([
            'name'     => 'Nasrin Begum',
            'email'    => 'nasrin@hms.com',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'phone'    => '+880 1733333333',
        ]);

        $pat4 = User::create([
            'name'     => 'Arif Islam',
            'email'    => 'arif@hms.com',
            'password' => Hash::make('password'),
            'role'     => 'patient',
            'phone'    => '+880 1744444444',
        ]);

        // ─── Appointments ─────────────────────────────────────────────────
        Appointment::create([
            'patient_id'       => $pat1->id,
            'doctor_id'        => $doc1->id,
            'appointment_date' => '2026-07-01',
            'appointment_time' => '10:00',
            'status'           => 'pending',
            'notes'            => 'Chest pain and shortness of breath',
        ]);

        Appointment::create([
            'patient_id'       => $pat2->id,
            'doctor_id'        => $doc2->id,
            'appointment_date' => '2026-07-02',
            'appointment_time' => '11:30',
            'status'           => 'approved',
            'notes'            => 'Severe headaches and dizziness',
        ]);

        Appointment::create([
            'patient_id'       => $pat3->id,
            'doctor_id'        => $doc3->id,
            'appointment_date' => '2026-07-03',
            'appointment_time' => '09:00',
            'status'           => 'pending',
            'notes'            => 'Knee joint pain',
        ]);

        Appointment::create([
            'patient_id'       => $pat4->id,
            'doctor_id'        => $doc1->id,
            'appointment_date' => '2026-07-04',
            'appointment_time' => '14:00',
            'status'           => 'cancelled',
            'notes'            => 'Follow-up checkup',
        ]);

        Appointment::create([
            'patient_id'       => $pat1->id,
            'doctor_id'        => $doc2->id,
            'appointment_date' => '2026-07-05',
            'appointment_time' => '15:30',
            'status'           => 'approved',
            'notes'            => 'Migraine treatment follow-up',
        ]);
    }
}
