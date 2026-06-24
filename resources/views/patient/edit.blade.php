<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Patient — HMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
  * { font-family: 'Inter', sans-serif; }
  body { background: #f0f4ff; }

  .sidebar {
    width: 260px; height: 100vh; position: fixed; top: 0; left: 0;
    background: linear-gradient(160deg,#1a1aff 0%,#0066cc 100%);
    color: #fff; z-index: 100;
    box-shadow: 4px 0 20px rgba(0,0,0,.15);
  }
  .sidebar-brand { padding: 22px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.15); }
  .sidebar-brand h4 { margin: 0; font-weight: 700; font-size: 1rem; }
  .sidebar-brand small { font-size: .72rem; opacity: .75; }
  .sidebar a {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,.85); text-decoration: none;
    padding: 13px 22px; font-size: .875rem; transition: .2s;
    border-left: 3px solid transparent;
  }
  .sidebar a:hover, .sidebar a.active {
    background: rgba(255,255,255,.12); color: #fff; border-left-color: #fff;
  }
  .main { margin-left: 260px; padding: 28px 30px; }

  .form-card {
    background: #fff; border-radius: 16px; border: none;
    box-shadow: 0 2px 16px rgba(0,0,0,.07); padding: 32px 36px;
  }
  .form-card h4 { font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
  .form-label { font-size: .83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
  .form-control, .form-select {
    border-radius: 10px; border: 1.5px solid #e5e7eb;
    padding: 10px 14px; font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: #1a1aff; box-shadow: 0 0 0 3px rgba(26,26,255,.1); outline: none;
  }
  .form-control.is-invalid { border-color: #ef4444; }

  .section-divider { border: none; border-top: 1.5px solid #f0f0f0; margin: 24px 0; }
  .section-label {
    font-size: .75rem; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;
  }

  .btn-submit {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 10px; padding: 12px 32px; font-weight: 600;
    font-size: .9rem; transition: opacity .2s, transform .15s;
  }
  .btn-submit:hover { opacity: .88; transform: translateY(-1px); color: #fff; }

  .input-icon-wrap { position: relative; }
  .input-icon-wrap .bi {
    position: absolute; top: 50%; left: 13px; transform: translateY(-50%);
    color: #9ca3af; font-size: 1rem;
  }
  .input-icon-wrap .form-control { padding-left: 36px; }

  .avatar-large {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg,#1a1aff,#0066cc);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.9rem; font-weight: 700;
  }
  .badge-patient { background: #eff6ff; color: #1d4ed8; padding: 4px 12px; border-radius: 20px; font-size: .78rem; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" style="{{ auth()->user()->role === 'admin' ? 'background: #198754 !important;' : '' }}">
  <div class="sidebar-brand">
    <h4><i class="bi bi-hospital me-2"></i>HMS</h4>
    <small>Hospital Management System</small>
  </div>

  @if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="{{ route('admin.register') }}" class="{{ Route::currentRouteName() === 'admin.register' ? 'active' : '' }}"><i class="bi bi-person-plus"></i> Register Users</a>
    <a href="{{ route('patients.index') }}" class="{{ Route::currentRouteName() === 'patients.index' ? 'active' : '' }}"><i class="bi bi-people"></i> All Patients</a>
    <a href="{{ route('appointments.book') }}" class="{{ Route::currentRouteName() === 'appointments.book' ? 'active' : '' }}"><i class="bi bi-calendar-plus"></i> Book Appointment</a>
    <a href="{{ route('admin.dashboard') }}#department"><i class="bi bi-building"></i> Departments</a>
    <a href="{{ route('admin.dashboard') }}#doctorassign"><i class="bi bi-person-gear"></i> Assign Doctor</a>
    <a href="{{ route('admin.dashboard') }}#activity"><i class="bi bi-activity"></i> Activity Logs</a>
  @elseif(auth()->user()->role === 'patient')
    <a href="{{ route('patients.dashboard') }}" class="{{ Route::currentRouteName() === 'patients.dashboard' ? 'active' : '' }}"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="{{ route('appointments.index') }}" class="{{ Route::currentRouteName() === 'appointments.index' ? 'active' : '' }}"><i class="bi bi-clipboard-pulse"></i> My Appointments</a>
  @else
    <a href="{{ route('doctor.dashboard') }}" class="{{ Route::currentRouteName() === 'doctor.dashboard' ? 'active' : '' }}"><i class="bi bi-grid"></i> Dashboard</a>
  @endif

  <div style="border-top:1px solid rgba(255,255,255,.15); margin: 10px 0;"></div>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bi bi-box-arrow-left"></i> Logout
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</div>

<div class="main">

  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="font-size:.82rem;">
      <li class="breadcrumb-item"><a href="{{ route('patients.index') }}" class="text-decoration-none">Patients</a></li>
      <li class="breadcrumb-item active">Edit Patient</li>
    </ol>
  </nav>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="form-card">

        <!-- Patient Header -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="avatar-large">
            {{ strtoupper(substr($patient->name, 0, 1)) }}
          </div>
          <div>
            <h4 class="mb-1">Edit Patient Profile</h4>
            <span class="badge-patient">
              <i class="bi bi-person-check me-1"></i>Patient ID: P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}
            </span>
          </div>
        </div>

        @if($errors->any())
          <div class="alert alert-danger rounded-3 mb-4" style="border-left:4px solid #ef4444;">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('patients.update', $patient) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Personal Info -->
          <p class="section-label">Personal Information</p>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <div class="input-icon-wrap">
                <i class="bi bi-person"></i>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $patient->name) }}" required>
              </div>
              @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number</label>
              <div class="input-icon-wrap">
                <i class="bi bi-phone"></i>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $patient->phone) }}">
              </div>
              @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <div class="input-icon-wrap">
              <i class="bi bi-envelope"></i>
              <input type="email" name="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email', $patient->email) }}" required>
            </div>
            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

          <hr class="section-divider">

          <!-- Readonly Info -->
          <p class="section-label">Account Info (Read-only)</p>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label">Role</label>
              <input type="text" class="form-control" value="Patient" readonly
                     style="background:#f9fafb; color:#6b7280;">
            </div>
            <div class="col-md-6">
              <label class="form-label">Registered On</label>
              <input type="text" class="form-control"
                     value="{{ $patient->created_at->format('d M Y, h:i A') }}"
                     readonly style="background:#f9fafb; color:#6b7280;">
            </div>
          </div>

          <!-- Appointment Summary -->
          <div class="p-3 rounded-3 mb-4" style="background:#f0f4ff; border:1px solid #dbeafe;">
            <div class="d-flex align-items-center gap-3">
              <i class="bi bi-calendar2-week text-primary" style="font-size:1.4rem;"></i>
              <div>
                <strong>Total Appointments:</strong>
                {{ $patient->patientAppointments()->count() }}
                <span class="text-muted">(all time)</span>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
              <i class="bi bi-arrow-left me-1"></i>Back
            </a>
            <div class="d-flex gap-2">
              <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this patient?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-3 px-4">
                  <i class="bi bi-trash me-1"></i>Delete
                </button>
              </form>
              <button type="submit" class="btn btn-submit">
                <i class="bi bi-check-circle me-2"></i>Save Changes
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
