<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Patients — HMS</title>
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

  .page-card {
    background: #fff; border-radius: 14px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 24px;
  }
  .page-card .card-header {
    background: transparent; border-bottom: 1px solid #f0f0f0;
    padding: 18px 22px; font-weight: 600; color: #1a1a2e;
    display: flex; align-items: center; justify-content: space-between;
  }

  .stat-card {
    background: #fff; border-radius: 14px; padding: 18px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); text-align: center;
  }
  .stat-card h3 { font-size: 1.8rem; font-weight: 700; margin: 0; color: #1a1a2e; }
  .stat-card p  { font-size: .78rem; color: #6b7280; margin: 4px 0 0; }

  .table thead { background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff; }
  .table thead th { font-weight: 500; font-size: .83rem; border: none; padding: 12px 14px; }
  .table td { padding: 12px 14px; vertical-align: middle; font-size: .875rem; }
  .table tbody tr:hover { background: #f8f9ff; }

  .avatar-sm {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg,#1a1aff,#0066cc);
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: .85rem;
  }
  .btn-add {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 10px; padding: 9px 20px; font-weight: 600;
    font-size: .875rem; transition: opacity .2s;
  }
  .btn-add:hover { opacity: .88; color: #fff; }

  .search-input {
    border-radius: 10px; border: 1px solid #e5e7eb;
    padding: 9px 16px; font-size: .875rem; min-width: 260px;
  }
  .search-input:focus { outline: none; border-color: #1a1aff; box-shadow: 0 0 0 3px rgba(26,26,255,.1); }
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

  <!-- Heading -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin:0;">Patient Management</h2>
      <p class="text-muted mb-0" style="font-size:.85rem;">Manage all registered patients</p>
    </div>
    <a href="{{ route('patients.create') }}" class="btn btn-add">
      <i class="bi bi-person-plus me-2"></i>Register New Patient
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert"
         style="border-left: 4px solid #198754;">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#1a1aff; margin-bottom:6px;"><i class="bi bi-people-fill"></i></div>
        <h3>{{ $totalPatients }}</h3>
        <p>Total Patients</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#16a34a; margin-bottom:6px;"><i class="bi bi-calendar-check-fill"></i></div>
        <h3>{{ $totalAppointments }}</h3>
        <p>Total Appointments</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#9333ea; margin-bottom:6px;"><i class="bi bi-person-check-fill"></i></div>
        <h3>{{ $patients->total() }}</h3>
        <p>Matching Results</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#ea580c; margin-bottom:6px;"><i class="bi bi-bar-chart-fill"></i></div>
        <h3>{{ $patients->lastPage() }}</h3>
        <p>Total Pages</p>
      </div>
    </div>
  </div>

  <!-- Patient Table -->
  <div class="page-card">
    <div class="card-header">
      <span><i class="bi bi-people me-2"></i>All Patients</span>
      <!-- Search -->
      <form action="{{ route('patients.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" value="{{ $search }}"
               class="search-input" placeholder="Search by name or email…">
        <button type="submit" class="btn btn-add">
          <i class="bi bi-search"></i>
        </button>
        @if($search)
          <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary rounded-3">Clear</a>
        @endif
      </form>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Patient</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Registered</th>
              <th>Appointments</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($patients as $patient)
            <tr>
              <td>
                <span class="text-muted" style="font-size:.8rem;">
                  P-{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}
                </span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="avatar-sm">{{ strtoupper(substr($patient->name, 0, 1)) }}</span>
                  <strong style="font-size:.875rem;">{{ $patient->name }}</strong>
                </div>
              </td>
              <td class="text-muted">{{ $patient->email }}</td>
              <td class="text-muted">{{ $patient->phone ?? '—' }}</td>
              <td class="text-muted" style="font-size:.8rem;">
                {{ $patient->created_at->format('d M Y') }}
              </td>
              <td>
                <span class="badge bg-primary rounded-pill">
                  {{ $patient->patientAppointments()->count() }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('patients.edit', $patient) }}"
                     class="btn btn-sm btn-outline-primary rounded-2">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('patients.destroy', $patient) }}"
                        method="POST" onsubmit="return confirm('Delete this patient?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                  <a href="{{ route('appointments.book') }}"
                     class="btn btn-sm btn-outline-success rounded-2" title="Book Appointment">
                    <i class="bi bi-calendar-plus"></i>
                  </a>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-5">
                <i class="bi bi-people" style="font-size:2.5rem; display:block; margin-bottom:10px;"></i>
                @if($search)
                  No patients found matching "<strong>{{ $search }}</strong>".
                @else
                  No patients registered yet.
                  <a href="{{ route('patients.create') }}">Register the first patient →</a>
                @endif
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($patients->hasPages())
      <div class="px-4 py-3 border-top">
        {{ $patients->appends(['search' => $search])->links() }}
      </div>
      @endif
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
