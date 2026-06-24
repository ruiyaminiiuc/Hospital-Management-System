<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Manager</title>
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #f0f4f8; display: flex; }
        .sidebar { width: 260px; background-color: #1e70ff; color: white; min-height: 100vh; padding: 30px 20px; box-sizing: border-box; }
        .active { background: rgba(255,255,255,0.2); font-weight: bold; }
        .content { flex: 1; padding: 40px; }
        .form-card { background: white; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 30px; }
        input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; }
        .btn-submit { background: #1e70ff; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        table { width: 100%; background: white; border-collapse: collapse; border: 1px solid #e2e8f0; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Doctor Panel</h1><p>{{ Auth::user()->name }}</p>
        <div class="nav-links">
            <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
            <a href="{{ route('doctor.profile') }}">Profile</a>
            <a href="{{ route('doctor.appointments') }}">Appointments</a>
            <a href="{{ route('doctor.schedule') }}" class="active">Schedule</a>
        </div>
    </div>
    <div class="content">
        <h2>Schedule Manager</h2>
        <div class="form-card">
            <form action="{{ route('doctor.schedule.store') }}" method="POST">
                @csrf
                <label>Session Title</label><input type="text" name="title">
                <label>Date</label><input type="date" name="date">
                <label>Time</label><input type="time" name="time">
                <button type="submit" class="btn-submit">Create Schedule</button>
            </form>
        </div>
        <h3>My Schedules</h3>
        <table>
            <thead><tr><th>Title</th><th>Date</th><th>Time</th></tr></thead>
            <tbody>
                @foreach($schedules as $sc)
                <tr><td>{{ $sc->title }}</td><td>{{ $sc->date }}</td><td>{{ $sc->time }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>