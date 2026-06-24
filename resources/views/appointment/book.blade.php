<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Appointment — HMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
  * { font-family: 'Inter', sans-serif; }
  body { background: #f0f4ff; }

  .sidebar {
    width: 260px; height: 100vh; position: fixed; top: 0; left: 0;
    background: linear-gradient(160deg,#1a1aff 0%,#0066cc 100%);
    color: #fff; z-index: 100; box-shadow: 4px 0 20px rgba(0,0,0,.15);
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
    box-shadow: 0 2px 16px rgba(0,0,0,.07); padding: 34px 38px;
    max-width: 700px;
  }
  .form-label { font-size: .83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
  .form-control, .form-select {
    border-radius: 10px; border: 1.5px solid #e5e7eb;
    padding: 10px 14px; font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: #1a1aff; box-shadow: 0 0 0 3px rgba(26,26,255,.1); outline: none;
  }
  .btn-book {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 10px; padding: 12px 32px; font-weight: 600; transition: .2s;
  }
  .btn-book:hover { opacity: .88; color: #fff; }
  .section-label {
    font-size: .75rem; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px;
  }
  .divider { border: none; border-top: 1.5px solid #f0f0f0; margin: 22px 0; }

  /* Doctor cards */
  .doctor-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .doctor-card {
    border: 2px solid #e5e7eb; border-radius: 12px; padding: 12px 14px;
    cursor: pointer; transition: .2s; background: #f9fafb;
    display: flex; align-items: center; gap: 10px;
  }
  .doctor-card:hover { border-color: #1a1aff; background: #eff6ff; }
  .doctor-card.selected { border-color: #1a1aff; background: #eff6ff; }
  .doc-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg,#6366f1,#8b5cf6);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: .9rem; flex-shrink: 0;
  }
  .doctor-card strong { font-size: .85rem; }
  .doctor-card small { color: #6b7280; font-size: .75rem; }
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

  <div class="mb-4">
    <h2 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin:0;">Book an Appointment</h2>
    <p class="text-muted mb-0" style="font-size:.85rem;">Schedule a consultation with a doctor</p>
  </div>

  @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4" style="border-left:4px solid #ef4444; max-width:700px;">
      <i class="bi bi-exclamation-triangle me-2"></i>
      @foreach($errors->all() as $error) {{ $error }} @endforeach
    </div>
  @endif

  <div class="form-card">

    <form action="{{ route('appointments.store') }}" method="POST">
      @csrf

      <!-- Select Patient -->
      <p class="section-label">Patient Details</p>
      <div class="mb-3">
        <label class="form-label">Select Patient <span class="text-danger">*</span></label>
        <select name="patient_id" id="apt_patient" class="form-select @error('patient_id') is-invalid @enderror" required>
          <option value="" disabled selected>— Choose a patient —</option>
          @foreach(\App\Models\User::where('role','patient')->get() as $p)
            <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
              {{ $p->name }} ({{ $p->email }})
            </option>
          @endforeach
        </select>
        @error('patient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <hr class="divider">

      <!-- Choose Doctor -->
      <p class="section-label">Choose Doctor</p>
      <input type="hidden" name="doctor_id" id="doctor_id_hidden" value="{{ old('doctor_id') }}" required>
      @error('doctor_id')
        <div class="text-danger mb-2" style="font-size:.8rem;">{{ $message }}</div>
      @enderror

      <div class="doctor-grid mb-3">
        @forelse($doctors as $doc)
          <div class="doctor-card {{ old('doctor_id') == $doc->id ? 'selected' : '' }}"
               onclick="selectDoctor({{ $doc->id }}, this)">
            <div class="doc-avatar">{{ strtoupper(substr($doc->name,0,1)) }}</div>
            <div>
              <strong>{{ $doc->name }}</strong><br>
              <small>{{ optional($doc->department)->name ?? 'General' }}</small>
            </div>
            <div class="ms-auto">
              <i class="bi bi-check-circle-fill text-primary"
                 id="check_{{ $doc->id }}"
                 style="{{ old('doctor_id') == $doc->id ? '' : 'display:none;' }} font-size:1.1rem;"></i>
            </div>
          </div>
        @empty
          <div class="col-span-2 text-muted">No doctors registered. Add doctors via Admin panel.</div>
        @endforelse
      </div>

      <hr class="divider">

      <!-- Date & Time -->
      <p class="section-label">Appointment Schedule</p>
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label class="form-label">Appointment Date <span class="text-danger">*</span></label>
          <input type="date" name="appointment_date" id="apt_date"
                 class="form-control @error('appointment_date') is-invalid @enderror"
                 value="{{ old('appointment_date') }}"
                 min="{{ date('Y-m-d') }}" required>
          @error('appointment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label">Preferred Time</label>
          <input type="time" name="appointment_time" id="apt_time"
                 class="form-control" value="{{ old('appointment_time') }}">
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Notes / Symptoms (Optional)</label>
        <textarea name="notes" id="apt_notes" rows="3" class="form-control"
                  placeholder="Describe your symptoms or reason for visit…">{{ old('notes') }}</textarea>
      </div>

      <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('patients.dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
          <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <button type="submit" class="btn btn-book">
          <i class="bi bi-calendar-check me-2"></i>Book Appointment
        </button>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let selectedDoctorId = null;

  function selectDoctor(id, el) {
    // deselect all
    document.querySelectorAll('.doctor-card').forEach(c => {
      c.classList.remove('selected');
    });
    document.querySelectorAll('[id^="check_"]').forEach(i => i.style.display = 'none');

    // select this
    el.classList.add('selected');
    document.getElementById('check_' + id).style.display = 'inline';
    document.getElementById('doctor_id_hidden').value = id;
    selectedDoctorId = id;
  }
</script>
</body>
</html>
