<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Dashboard — HMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
  * { font-family: 'Inter', sans-serif; }
  body { background: #f0f4ff; }
  .sidebar {
    width: 260px; height: 100vh; position: fixed; top: 0; left: 0;
    background: linear-gradient(160deg,#7c3aed 0%,#5b21b6 100%);
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
  .section-card {
    background: #fff; border-radius: 14px; border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); margin-bottom: 24px;
  }
  .section-card .card-header {
    background: transparent; border-bottom: 1px solid #f0f0f0;
    padding: 18px 22px; font-weight: 600; display: flex; align-items: center; gap: 8px;
  }
  .stat-card {
    background: #fff; border-radius: 14px; padding: 20px 22px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: transform .2s;
  }
  .stat-card:hover { transform: translateY(-3px); }
  .stat-card .icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 12px; }
  .stat-card h3 { font-size: 1.9rem; font-weight: 700; margin: 0; }
  .stat-card p  { font-size: .8rem; color: #6b7280; margin: 0; }
  .table thead { background: linear-gradient(135deg,#7c3aed,#5b21b6); color: #fff; }
  .table thead th { font-weight: 500; font-size: .83rem; border: none; padding: 12px 14px; }
  .table td { padding: 12px 14px; vertical-align: middle; font-size: .875rem; }
  .badge-pending   { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 20px; font-size: .75rem; }
  .badge-approved  { background: #d1e7dd; color: #0a3622; padding: 4px 10px; border-radius: 20px; font-size: .75rem; }
  .badge-cancelled { background: #f8d7da; color: #58151c; padding: 4px 10px; border-radius: 20px; font-size: .75rem; }
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-brand">
    <h4><i class="bi bi-hospital me-2"></i>HMS — Doctor</h4>
    <small>Doctor Dashboard</small>
  </div>
  <a href="{{ route('doctor.dashboard') }}" class="active"><i class="bi bi-grid"></i> Dashboard</a>
  <a href="{{ route('patients.index') }}"><i class="bi bi-people"></i> My Patients</a>
  <div style="border-top:1px solid rgba(255,255,255,.15); margin: 10px 0;"></div>
  
  <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
    @csrf
    <button type="submit" style="background:none; border:none; width:100%; text-align:left; color: rgba(255,255,255,.85); padding: 13px 22px; font-size: .875rem; transition: .2s; border-left: 3px solid transparent;" onmouseover="this.style.background='rgba(255,255,255,.12)'; this.style.color='#fff'; this.style.borderLeftColor='#fff';" onmouseout="this.style.background='none'; this.style.color='rgba(255,255,255,.85)'; this.style.borderLeftColor='transparent';">
      <i class="bi bi-box-arrow-left"></i> Logout
    </button>
  </form>
</div>

<div class="main">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin:0;">Doctor Dashboard</h2>
      <p class="text-muted mb-0" style="font-size:.85rem;">Manage your patients and appointments</p>
    </div>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#f5f3ff;"><i class="bi bi-people-fill" style="color:#7c3aed;"></i></div>
        <h3>{{ \App\Models\Appointment::where('doctor_id', auth()->id())->distinct('patient_id')->count() }}</h3>
        <p>My Unique Patients</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#fff7ed;"><i class="bi bi-calendar-check-fill" style="color:#ea580c;"></i></div>
        <h3>{{ \App\Models\Appointment::where('doctor_id', auth()->id())->where('status','pending')->count() }}</h3>
        <p>Pending Appointments</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="stat-card">
        <div class="icon" style="background:#f0fdf4;"><i class="bi bi-check-circle-fill" style="color:#16a34a;"></i></div>
        <h3>{{ \App\Models\Appointment::where('doctor_id', auth()->id())->where('status','approved')->count() }}</h3>
        <p>Approved Appointments</p>
      </div>
    </div>
  </div>

  <!-- Recent Appointments -->
  <div class="section-card">
    <div class="card-header">
      <i class="bi bi-clipboard-pulse"></i> Recent Appointments
      <a href="{{ route('appointments.index') }}" class="ms-auto btn btn-sm btn-outline-secondary rounded-3">View All</a>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>#</th><th>Patient</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse(\App\Models\Appointment::with(['patient','doctor'])->where('doctor_id', auth()->id())->latest()->take(10)->get() as $apt)
            <tr>
              <td>APT-{{ str_pad($apt->id,4,'0',STR_PAD_LEFT) }}</td>
              <td><strong>{{ optional($apt->patient)->name ?? 'N/A' }}</strong></td>
              <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</td>
              <td>{{ $apt->appointment_time ?? '—' }}</td>
              <td><span class="badge-{{ $apt->status }}">{{ ucfirst($apt->status) }}</span></td>
              <td>
                @if($apt->status==='pending')
                  <form action="{{ route('appointments.status',$apt) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button class="btn btn-sm btn-success rounded-2"><i class="bi bi-check"></i> Approve</button>
                  </form>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No appointments yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
