<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments</title>
    <style>
        body { margin: 0; font-family: sans-serif; background-color: #f0f4f8; display: flex; }
        .sidebar { width: 260px; background-color: #1e70ff; color: white; min-height: 100vh; padding: 30px 20px; box-sizing: border-box; }
        .sidebar h1 { font-size: 24px; margin: 0; }
        .sidebar p { opacity: 0.8; margin-bottom: 40px; }
        
        /* Fixed Nav Links CSS */
        .nav-links a { 
            display: block; 
            color: white; 
            text-decoration: none; 
            padding: 12px 10px; 
            border-radius: 5px; 
            transition: 0.3s;
            margin-bottom: 5px;
        }
        .nav-links a:hover { background: rgba(255,255,255,0.1); }
        .active { background: rgba(255,255,255,0.2) !important; font-weight: bold; }

        .content { flex: 1; padding: 40px; }
        h2 { color: #1e293b; margin-bottom: 30px; }
        
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f1f5f9; }
        th { background: #f8fafc; color: #475569; font-size: 14px; }
        
        .status { background: #fbbf24; color: white; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .btn-approve { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .btn-cancel { background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Doctor Panel</h1>
        <!-- Using a fallback 'Dr. Test' if user is not logged in yet -->
        <p>{{ Auth::user()->name ?? 'Dr. Test' }}</p>
        
        <div class="nav-links">
            <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
            <a href="{{ route('doctor.profile') }}">Profile</a>
            <a href="{{ route('doctor.appointments') }}" class="active">Appointments</a>
            <a href="{{ rout