<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Users — Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            background: #f4f7fc;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #198754;
            position: fixed;
            color: white;
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            display: block;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 14px 20px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: .3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
        }

        .main {
            margin-left: 260px;
            padding: 40px;
            min-height: 100vh;
        }

        .register-container {
            max-width: 700px;
            margin: 0 auto;
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            background: #ffffff;
            padding: 40px;
        }

        .card-title-custom {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .card-subtitle-custom {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-size: .85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e5e7eb;
            padding: 12px 14px 12px 42px;
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .12);
            outline: none;
        }

        .form-select {
            padding-left: 14px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .bi {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 4px;
        }

        .role-option {
            display: none;
        }

        .role-label {
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px 12px;
            cursor: pointer;
            text-align: center;
            transition: .25s;
            background: #f9fafb;
            color: #4b5563;
        }

        .role-label:hover {
            border-color: #198754;
            background: #f3f4f6;
        }

        .role-option:checked + .role-label {
            border-color: #198754;
            background: #e8f5e9;
            color: #198754;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.08);
        }

        .role-label i {
            display: block;
            font-size: 1.8rem;
            margin-bottom: 6px;
        }

        .role-label span {
            font-size: .85rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #198754, #146c43);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            width: 100%;
            transition: opacity .2s, transform .15s;
            box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2);
        }

        .btn-register:hover {
            opacity: .95;
            transform: translateY(-1px);
            color: #fff;
        }

        .section-divider {
            border: none;
            border-top: 1.5px solid #f3f4f6;
            margin: 25px 0;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.register') }}" class="active">Register Users</a>
        <a href="{{ route('patients.index') }}">All Patients</a>
        <a href="{{ route('appointments.book') }}">Book Appointment</a>
        <a href="{{ route('admin.dashboard') }}#department">Departments</a>
        <a href="{{ route('admin.dashboard') }}#doctorassign">Assign Doctor</a>
        <a href="{{ route('admin.dashboard') }}#activity">Activity Logs</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="register-container">
            <div class="card card-custom">
                <h3 class="card-title-custom">Register New User</h3>
                <p class="card-subtitle-custom">Create a new Admin, Doctor, or Patient profile within the system.</p>

                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4 d-flex align-items-center" style="border-left: 4px solid #198754;">
                        <i class="bi bi-check-circle-fill me-3 fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4" style="border-left: 4px solid #dc3545; font-size: .88rem;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <span class="fw-bold">Please fix the following validation errors:</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.register.store') }}" method="POST">
                    @csrf

                    <!-- Role Selection -->
                    <div class="mb-4">
                        <label class="form-label">User Account Role <span class="text-danger">*</span></label>
                        <div class="role-grid">
                            <div>
                                <input type="radio" name="role" id="role_admin" value="admin" class="role-option"
                                    {{ old('role') === 'admin' ? 'checked' : '' }}>
                                <label for="role_admin" class="role-label">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    <span>Admin</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="role" id="role_doctor" value="doctor" class="role-option"
                                    {{ old('role') === 'doctor' ? 'checked' : '' }}>
                                <label for="role_doctor" class="role-label">
                                    <i class="bi bi-person-badge-fill"></i>
                                    <span>Doctor</span>
                                </label>
                            </div>
                            <div>
                                <input type="radio" name="role" id="role_patient" value="patient" class="role-option"
                                    {{ old('role', 'patient') === 'patient' ? 'checked' : '' }}>
                                <label for="role_patient" class="role-label">
                                    <i class="bi bi-person-heart"></i>
                                    <span>Patient</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Department Field for Doctor -->
                    <div class="mb-3" id="department-select-container" style="display: none;">
                        <label class="form-label" for="department_id">Department Assignment <span class="text-danger">*</span></label>
                        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
                            <option value="" selected disabled>Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="section-divider">

                    <!-- Personal Information -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="reg_name">Full Name <span class="text-danger">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-person"></i>
                                <input type="text" name="name" id="reg_name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="John Doe" required>
                            </div>
                            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="reg_phone">Phone Number</label>
                            <div class="input-wrap">
                                <i class="bi bi-phone"></i>
                                <input type="text" name="phone" id="reg_phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="+880 17XXXXXXXX">
                            </div>
                            @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="reg_email">Email Address <span class="text-danger">*</span></label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" id="reg_email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="user@hospital.com" required>
                        </div>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="reg_pass">Password <span class="text-danger">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" id="reg_pass"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Min. 6 characters" required>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="reg_pass_conf">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-wrap">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password_confirmation" id="reg_pass_conf"
                                    class="form-control" placeholder="Repeat password" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register">
                        <i class="bi bi-person-plus-fill me-2"></i> Register Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleOptions = document.querySelectorAll('input[name="role"]');
            const deptContainer = document.getElementById('department-select-container');
            const deptSelect = document.getElementById('department_id');

            function toggleDepartment() {
                const selectedRole = document.querySelector('input[name="role"]:checked')?.value;
                if (selectedRole === 'doctor') {
                    deptContainer.style.display = 'block';
                    deptSelect.setAttribute('required', 'required');
                } else {
                    deptContainer.style.display = 'none';
                    deptSelect.removeAttribute('required');
                    deptSelect.value = ''; // Reset value when hidden
                }
            }

            roleOptions.forEach(radio => {
                radio.addEventListener('change', toggleDepartment);
            });

            // Run on load to set correct initial state
            toggleDepartment();
        });
    </script>
</body>

</html>
