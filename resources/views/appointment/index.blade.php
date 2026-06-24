<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>All Appointments — HMS</title>
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

  .page-card {
    background: #fff; border-radius: 14px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 24px;
  }
  .page-card .card-header {
    background: transparent; border-bottom: 1px solid #f0f0f0;
    padding: 18px 22px; font-weight: 600; color: #1a1a2e;
    display: flex; align-items: center; justify-content: space-between;
  }
  .table thead { background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff; }
  .table thead th { font-weight: 500; font-size: .83rem; border: none; padding: 12px 14px; }
  .table td { padding: 12px 14px; vertical-align: middle; font-size: .875rem; }
  .table tbody tr:hover { background: #f8f9ff; }

  .badge-pending   { background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-size: .75rem; }
  .badge-approved  { background: #d1e7dd; color: #0a3622; padding: 5px 12px; border-radius: 20px; font-size: .75rem; }
  .badge-cancelled { background: #f8d7da; color: #58151c; padding: 5px 12px; border-radius: 20px; font-size: .75rem; }

  .btn-add {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 10px; padding: 9px 20px; font-weight: 600;
    font-size: .875rem; text-decoration: none; transition: opacity .2s;
  }
  .btn-add:hover { opacity: .88; color: #fff; }

  .stat-card {
    background: #fff; border-radius: 14px; padding: 18px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); text-align: center;
  }
  .stat-card h3 { font-size: 1.8rem; font-weight: 700; margin: 0; color: #1a1a2e; }
  .stat-card p  { font-size: .78rem; color: #6b7280; margin: 4px 0 0; }
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

  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin:0;">Appointments</h2>
      <p class="text-muted mb-0" style="font-size:.85rem;">Manage all hospital appointments</p>
    </div>
    <a href="{{ route('appointments.book') }}" class="btn btn-add">
      <i class="bi bi-calendar-plus me-2"></i>Book New
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert"
         style="border-left: 4px solid #198754;">
      <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#1a1aff; margin-bottom:6px;"><i class="bi bi-calendar-fill"></i></div>
        <h3>{{ $appointments->total() }}</h3>
        <p>Total Appointments</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#ca8a04; margin-bottom:6px;"><i class="bi bi-clock-fill"></i></div>
        <h3>{{ $appointments->where('status','pending')->count() }}</h3>
        <p>Pending</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#16a34a; margin-bottom:6px;"><i class="bi bi-check-circle-fill"></i></div>
        <h3>{{ $appointments->where('status','approved')->count() }}</h3>
        <p>Approved</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card">
        <div style="font-size:1.8rem; color:#ef4444; margin-bottom:6px;"><i class="bi bi-x-circle-fill"></i></div>
        <h3>{{ $appointments->where('status','cancelled')->count() }}</h3>
        <p>Cancelled</p>
      </div>
    </div>
  </div>

  <!-- Appointments Table -->
  <div class="page-card">
    <div class="card-header">
      <span><i class="bi bi-clipboard-pulse me-2"></i>All Appointments</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Patient</th>
              <th>Doctor</th>
              <th>Department</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($appointments as $apt)
            <tr>
              <td><span class="text-muted" style="font-size:.78rem;">APT-{{ str_pad($apt->id,4,'0',STR_PAD_LEFT) }}</span></td>
              <td>
                <strong style="font-size:.875rem;">{{ optional($apt->patient)->name ?? 'N/A' }}</strong><br>
                <small class="text-muted">{{ optional($apt->patient)->phone ?? '' }}</small>
              </td>
              <td>
                <strong style="font-size:.875rem;">{{ optional($apt->doctor)->name ?? 'N/A' }}</strong>
              </td>
              <td class="text-muted">{{ optional($apt->doctor?->department)->name ?? '—' }}</td>
              <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</td>
              <td class="text-muted">{{ $apt->appointment_time ?? '—' }}</td>
              <td>
                <span class="badge-{{ $apt->status }}">
                  {{ ucfirst($apt->status) }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1 flex-wrap">
                  @if($apt->status === 'pending')
                    <form action="{{ route('appointments.status', $apt) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="approved">
                      <button class="btn btn-sm btn-success rounded-2" title="Approve">
                        <i class="bi bi-check"></i>
                      </button>
                    </form>
                    <form action="{{ route('appointments.status', $apt) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="cancelled">
                      <button class="btn btn-sm btn-danger rounded-2" title="Cancel">
                        <i class="bi bi-x"></i>
                      </button>
                    </form>
                  @elseif($apt->status === 'approved')
                    <form action="{{ route('appointments.status', $apt) }}" method="POST">
                      @csrf @method('PATCH')
                      <input type="hidden" name="status" value="cancelled">
                      <button class="btn btn-sm btn-outline-danger rounded-2" title="Cancel">
                        <i class="bi bi-x-circle"></i>
                      </button>
                    </form>
                  @else
                    <span class="text-muted" style="font-size:.78rem;">—</span>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center text-muted py-5">
                <i class="bi bi-calendar-x" style="font-size:2.5rem; display:block; margin-bottom:10px;"></i>
                No appointments found.
                <a href="{{ route('appointments.book') }}">Book the first one →</a>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($appointments->hasPages())
      <div class="px-4 py-3 border-top">
        {{ $appointments->links() }}
      </div>
      @endif
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
