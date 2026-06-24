<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #f0f4f8; display: flex; }
        .sidebar { width: 260px; background-color: #1e70ff; color: white; min-height: 100vh; padding: 30px 20px; box-sizing: border-box; }
        .sidebar h1 { font-size: 24px; margin: 0; }
        .sidebar p { opacity: 0.8; margin-bottom: 40px; }
        .nav-links a { display: block; color: white; text-decoration: none; padding: 15px 10px; border-radius: 5px; transition: 0.3s; }
        .nav-links a:hover { background: rgba(255,255,255,0.1); }
        .active { background: rgba(255,255,255,0.2); font-weight: bold; }
        .content { flex: 1; padding: 40px; }
        .card-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
        .card p { color: #64748b; font-weight: bold; margin: 0; }
        .card h3 { font-size: 45px; margin: 10px 0; color: #1e293b; }
        .status-badge { background: #059669; color: white; text-align: center; padding: 8px; border-radius: 5px; font-weight: bold; font-size: 12px; }
        .logout-btn { background: none; border: none; color: white; cursor: pointer; padding: 15px 10px; text-align: left; width: 100%; font-size: 16px; opacity: 0.8; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Doctor Panel</h1>
        <p>{{ Auth::user()->name }}</p>
        <div class="nav-links">
            <a href="{{ route('doctor.dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('doctor.profile') }}">Profile</a>
            <a href="{{ route('doctor.appointments') }}">Appointments</a>
            <a href="{{ route('doctor.schedule') }}">Schedule</a>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
    <div class="content">
        <h2>Doctor Dashboard</h2>
        <div class="card-container">
            <div class="card"><p>Total Patients</p><h3>{{ $totalPatients }}</h3></div>
            <div class="card"><p>Today Appointments</p><h3>{{ $todayApps }}</h3></div>
            <div class="card"><p>Status</p><div class="status-badge">Active</div></div>
        </div>
    </div>
</body>
</html>