<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            background: #f4f7fc;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: #198754;
            position: fixed;
            color: white;
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            display: block;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 14px 20px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: .3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
        }

        .main {
            margin-left: 260px;
            padding: 25px;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
        }

        .table thead {
            background: #198754;
            color: white;
        }

        .activity {
            border-left: 4px solid #198754;
            padding: 10px;
            margin-bottom: 10px;
            background: white;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.register') }}">Register Users</a>
        <a href="{{ route('patients.index') }}">All Patients</a>
        <a href="{{ route('appointments.index') }}">Appointments Dashboard</a>
        <a href="{{ route('appointments.book') }}">Book Appointment</a>
        <a href="{{ route('admin.dashboard') }}#department">Departments</a>
        <a href="{{ route('admin.dashboard') }}#doctorassign">Assign Doctor</a>
        <a href="{{ route('admin.dashboard') }}#activity">Activity Logs</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main">
        <h2 class="mb-4">Hospital Admin Dashboard</h2>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <h6>Total Doctors</h6>
                    <h2>{{ $totalDoctors }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <h6>Total Patients</h6>
                    <h2>{{ $totalPatients }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <h6>Departments</h6>
                    <h2>{{ $totalDepts }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <h6>Appointments</h6>
                    <h2>{{ $totalAppointments }}</h2>
                </div>
            </div>
        </div>

        <!-- Create Department Module -->
        <div id="department" class="card card-custom p-4 mb-4">
            <h4>Create Department</h4>
            <form action="{{ route('admin.dept.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" placeholder="Department Name" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="description" class="form-control" placeholder="Department Description">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Create</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Departments List Table -->
        <div class="card card-custom p-4 mb-4">
            <h4>Departments List</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                        <tr>
                            <td>D-{{ $dept->id }}</td>
                            <td>{{ $dept->name }}</td>
                            <td>{{ $dept->description ?? 'No Description' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No Departments Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Assign Doctor to Department -->
        <div id="doctorassign" class="card card-custom p-4 mb-4">
            <h4>Assign Doctor to Department</h4>
            <form action="#" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <select name="doctor_id" class="form-select" required>
                            <option value="" selected disabled>Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="department_id" class="form-select" required>
                            <option value="" selected disabled>Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Assign</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Activity Logs -->
        <div id="activity" class="card card-custom p-4">
            <h4>Recent Activity</h4>
            <div class="activity">New Department Created (Latest sync)</div>
            <div class="activity">Patient Records Updated</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>