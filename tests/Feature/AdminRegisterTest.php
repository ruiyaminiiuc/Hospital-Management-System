<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guest users are redirected to login.
     */
    public function test_guest_cannot_access_admin_register(): void
    {
        $response = $this->get('/admin/register');

        $response->assertRedirect('/login');
    }

    /**
     * Non-admin users receive a 403 Forbidden status.
     */
    public function test_non_admin_cannot_access_admin_register(): void
    {
        $patient = User::factory()->create([
            'role' => 'patient',
        ]);

        $response = $this->actingAs($patient)->get('/admin/register');

        $response->assertStatus(403);
    }

    /**
     * Admins can load the register page successfully.
     */
    public function test_admin_can_access_admin_register(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/register');

        $response->assertStatus(200);
        $response->assertSee('Register New User');
    }

    /**
     * Admin can successfully register a new patient.
     */
    public function test_admin_can_register_new_patient(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'phone' => '01712345678',
            'role' => 'patient',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'role' => 'patient',
        ]);
    }

    /**
     * Admin can successfully register a new doctor with a department.
     */
    public function test_admin_can_register_new_doctor_with_department(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $department = Department::create([
            'name' => 'Cardiology',
            'description' => 'Heart division',
        ]);

        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Test Doctor',
            'email' => 'doctor@test.com',
            'phone' => '01712345679',
            'role' => 'doctor',
            'department_id' => $department->id,
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Test Doctor',
            'email' => 'doctor@test.com',
            'role' => 'doctor',
            'department_id' => $department->id,
        ]);
    }

    /**
     * Admin registration for a doctor fails if no department is specified.
     */
    public function test_admin_registration_for_doctor_fails_without_department(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Test Doctor Fail',
            'email' => 'doctorfail@test.com',
            'phone' => '01712345670',
            'role' => 'doctor',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertSessionHasErrors(['department_id']);
        $this->assertDatabaseMissing('users', [
            'email' => 'doctorfail@test.com',
        ]);
    }
}
