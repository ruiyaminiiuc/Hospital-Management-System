<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Profile</title>
    <style>
        /* (Same CSS as Dashboard for Sidebar) */
        body { margin: 0; font-family: sans-serif; background-color: #f0f4f8; display: flex; }
        .sidebar { width: 260px; background-color: #1e70ff; color: white; min-height: 100vh; padding: 30px 20px; box-sizing: border-box; }
        .nav-links a { display: block; color: white; text-decoration: none; padding: 15px 10px; border-radius: 5px; }
        .active { background: rgba(255,255,255,0.2); font-weight: bold; }
        .content { flex: 1; padding: 40px; }
        .form-card { background: white; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; max-width: 600px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #475569; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; box-sizing: border-box; }
        .update-btn { background: #1e70ff; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Doctor Panel</h1><p>{{ Auth::user()->name }}</p>
        <div class="nav-links">
            <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
            <a href="{{ route('doctor.profile') }}" class="active">Profile</a>
            <a href="{{ route('doctor.appointments') }}">Appointments</a>
            <a href="{{ route('doctor.schedule') }}">Schedule</a>
        </div>
    </div>
    <div class="content">
        <h2>Profile</h2>
        <div class="form-card">
            <div class="form-group"><label>Name</label><input type="text" value="{{ Auth::user()->name }}"></div>
            <div class="form-group"><label>Email</label><input type="email" value="{{ Auth::user()->email }}"></div>
            <div class="form-group">
                <label>Department</label>
                <select>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ Auth::user()->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="update-btn">Update</button>
        </div>
    </div>
</body>
</html>