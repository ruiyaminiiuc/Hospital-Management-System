<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Dashboard — HMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
  * { font-family: 'Inter', sans-serif; }

  body { background: #f0f4ff; }

  /* Sidebar */
  .sidebar {
    width: 260px; height: 100vh; position: fixed; top: 0; left: 0;
    background: linear-gradient(160deg, #1a1aff 0%, #0066cc 100%);
    color: #fff; padding: 0; z-index: 100; overflow-y: auto;
    box-shadow: 4px 0 20px rgba(0,0,0,.15);
  }
  .sidebar-brand {
    padding: 22px 20px 16px;
    border-bottom: 1px solid rgba(255,255,255,.15);
  }
  .sidebar-brand h4 { margin: 0; font-weight: 700; font-size: 1rem; letter-spacing:.5px; }
  .sidebar-brand small { font-size: .72rem; opacity: .75; }
  .sidebar a {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,.85); text-decoration: none;
    padding: 13px 22px; font-size: .875rem; transition: .2s;
    border-left: 3px solid transparent;
  }
  .sidebar a:hover, .sidebar a.active {
    background: rgba(255,255,255,.12);
    color: #fff; border-left-color: #fff;
  }
  .sidebar a i { font-size: 1.1rem; min-width: 20px; }

  /* Main */
  .main { margin-left: 260px; padding: 28px 30px; min-height: 100vh; }

  /* Topbar */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px;
  }
  .topbar h2 { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; margin: 0; }

  /* Stat cards */
  .stat-card {
    background: #fff; border-radius: 14px;
    padding: 20px 22px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.1); }
  .stat-card .icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin-bottom: 12px;
  }
  .stat-card h3 { font-size: 1.9rem; font-weight: 700; margin: 0; color: #1a1a2e; }
  .stat-card p  { font-size: .8rem; color: #6b7280; margin: 0; }

  /* Section card */
  .section-card {
    background: #fff; border-radius: 14px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 24px;
  }
  .section-card .card-header {
    background: transparent; border-bottom: 1px solid #f0f0f0;
    padding: 18px 22px; font-weight: 600; color: #1a1a2e;
    display: flex; align-items: center; gap: 8px;
  }

  /* Table */
  .table thead { background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff; }
  .table thead th { font-weight: 500; font-size: .83rem; border: none; padding: 12px 14px; }
  .table td { padding: 12px 14px; vertical-align: middle; font-size: .875rem; }
  .table tbody tr:hover { background: #f8f9ff; }

  /* Badge status */
  .badge-pending   { background: #fff3cd; color: #856404; }
  .badge-approved  { background: #d1e7dd; color: #0a3622; }
  .badge-cancelled { background: #f8d7da; color: #58151c; }

  /* Profile avatar */
  .avatar-circle {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg,#1a1aff,#0066cc);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.8rem; font-weight: 700; flex-shrink: 0;
  }

  /* Alert */
  .alert-success { border-radius: 10px; border-left: 4px solid #198754; }

  /* Action btn */
  .btn-book {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600;
    transition: opacity .2s;
  }
  .btn-book:hover { opacity: .88; color: #fff; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <div class="sidebar-brand">
    <h4><i class="bi bi-hospital me-2"></i>HMS</h4>
    <small>Hospital Management System</small>
  </div>
  <a href="{{ route('patients.dashboard') }}" class="active"><i class="bi bi-grid"></i> Dashboard</a>
  <a href="{{ route('appointments.index') }}"><i class="bi bi-clipboard-pulse"></i> My Appointments</a>
  <div style="border-top:1px solid rgba(255,255,255,.15); margin: 10px 0;"></div>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bi bi-box-arrow-left"></i> Logout
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</div>

<!-- Main Content -->
<div class="main">

  <!-- Topbar -->
  <div class="topbar">
    <div>
      <h2>Patient Dashboard</h2>
      <p class="text-muted mb-0" style="font-size:.85rem;">
        Welcome back, {{ optional($patient)->name ?? 'Guest' }}
      </p>
    </div>
    <a href="{{ route('appointments.book') }}" class="btn btn-book">
      <i class="bi bi-calendar-plus me-2"></i>Book Appointment
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Stat Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#eff6ff;">
          <i class="bi bi-calendar-check" style="color:#1a1aff;"></i>
        </div>
        <h3>{{ $appointments->count() }}</h3>
        <p>Total Appointments</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#f0fdf4;">
          <i class="bi bi-check-circle" style="color:#16a34a;"></i>
        </div>
        <h3>{{ $appointments->where('status','approved')->count() }}</h3>
        <p>Approved Appointments</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#fefce8;">
          <i class="bi bi-clock" style="color:#ca8a04;"></i>
        </div>
        <h3>{{ $appointments->where('status','pending')->count() }}</h3>
        <p>Pending Appointments</p>
      </div>
    </div>
  </div>

  <!-- Patient Profile Card -->
  <div class="section-card">
    <div class="card-header"><i class="bi bi-person-circle"></i> Patient Profile</div>
    <div class="card-body p-4">
      <div class="d-flex align-items-center gap-4">
        <div class="avatar-circle">
          {{ strtoupper(substr(optional($patient)->name ?? 'P', 0, 1)) }}
        </div>
        <div>
          <h5 class="fw-700 mb-1">{{ optional($patient)->name ?? 'No Patient Found' }}</h5>
          <p class="text-muted mb-1" style="font-size:.875rem;">
            <i class="bi bi-envelope me-1"></i>{{ optional($patient)->email ?? 'N/A' }}
          </p>
          <p class="text-muted mb-1" style="font-size:.875rem;">
            <i class="bi bi-phone me-1"></i>{{ optional($patient)->phone ?? 'Not provided' }}
          </p>
          <span class="badge bg-primary rounded-pill">Patient</span>
        </div>
        @if($patient)
        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-primary ms-auto btn-sm">
          <i class="bi bi-pencil me-1"></i>Edit Profile
        </a>
        @endif
      </div>
    </div>
  </div>

  <!-- Appointments Table -->
  <div class="section-card">
    <div class="card-header">
      <i class="bi bi-calendar2-week"></i> My Appointments
      <a href="{{ route('appointments.book') }}" class="btn btn-sm btn-book ms-auto">
        <i class="bi bi-plus-circle me-1"></i>New Booking
      </a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Doctor</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            @forelse($appointments as $apt)
            <tr>
              <td><span class="fw-600">APT-{{ str_pad($apt->id, 4, '0', STR_PAD_LEFT) }}</span></td>
              <td>
                <strong>{{ optional($apt->doctor)->name ?? 'N/A' }}</strong>
                @if($apt->doctor?->department)
                  <br><small class="text-muted">{{ $apt->doctor->department->name }}</small>
                @endif
              </td>
              <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</td>
              <td>{{ $apt->appointment_time ?? '—' }}</td>
              <td>
                @php $s = $apt->status; @endphp
                <span class="badge badge-{{ $s }} px-3 py-2 rounded-pill text-capitalize">
                  @if($s === 'approved') <i class="bi bi-check-circle me-1"></i>
                  @elseif($s === 'pending') <i class="bi bi-clock me-1"></i>
                  @else <i class="bi bi-x-circle me-1"></i>
                  @endif
                  {{ ucfirst($s) }}
                </span>
              </td>
              <td class="text-muted">{{ $apt->notes ?? '—' }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
                <i class="bi bi-calendar-x" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                No appointments found.
                <a href="{{ route('appointments.book') }}">Book your first one →</a>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Available Doctors -->
  <div class="section-card">
    <div class="card-header"><i class="bi bi-person-badge"></i> Available Doctors</div>
    <div class="card-body">
      <div class="row g-3">
        @forelse($doctors as $doctor)
        <div class="col-md-4">
          <div class="d-flex align-items-center gap-3 p-3 border rounded-3 bg-white">
            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);
                        display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex-shrink:0;">
              {{ strtoupper(substr($doctor->name, 0, 1)) }}
            </div>
            <div>
              <strong style="font-size:.875rem;">{{ $doctor->name }}</strong><br>
              <small class="text-muted">{{ optional($doctor->department)->name ?? 'General' }}</small>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-muted">No doctors registered yet.</div>
        @endforelse
      </div>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>