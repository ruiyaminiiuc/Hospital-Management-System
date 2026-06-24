<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Appointment Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fc;
    font-family:'Segoe UI',sans-serif;
}

.sidebar{
    width:260px;
    height:100vh;
    background:#4f46e5;
    position:fixed;
    color:white;
    padding-top:20px;
}

.sidebar h3{
    text-align:center;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 20px;
    transition:.3s;
}

.sidebar a:hover{
    background:white;
    color:#4f46e5;
}

.main{
    margin-left:260px;
    padding:25px;
}

.card-custom{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table thead{
    background:#4f46e5;
    color:white;
}

.status-pending{
    background:#ffc107;
}

.status-approved{
    background:#198754;
}

.status-cancelled{
    background:#dc3545;
}

.badge{
    padding:8px 15px;
}

</style>

</head>

<body>

<!-- Sidebar -->

<div class="sidebar">

    <h3>Appointment Panel</h3>

    <a href="#dashboard">Dashboard</a>
    <a href="#newAppointment">New Appointment</a>
    <a href="#appointments">Manage Appointments</a>
    <a href="#status">Status Tracking</a>

</div>

<!-- Main -->

<div class="main">

    <h2 class="mb-4">
        Appointment Management System
    </h2>

    <!-- Statistics -->

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card card-custom p-3">

                <h6>Total Appointments</h6>
<h2>{{ $totalAppointments }}</h2>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card card-custom p-3">

                <h6>Pending</h6>
<h2>{{ $pendingAppointments }}</h2>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card card-custom p-3">

                <h6>Approved</h6>
<h2>{{ $approvedAppointments }}</h2>
            </div>

        </div>

    </div>

    <!-- Create Appointment -->

    <div id="newAppointment"
         class="card card-custom p-4 mb-4">

        <h4 class="mb-3">
            Create Appointment
        </h4>

        
        <form action="/appointments"
      method="POST">

@csrf
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Patient Name</label>

                     <input
                      type="text"
                      name="patient_name"
                       class="form-control">
                </div>

                <div class="col-md-6 mb-3">

                    <label>Select Doctor</label>

                        <select
name="doctor_name"
class="form-select">
                        <option>Dr. John Smith</option>
                        <option>Dr. Sarah</option>
                        <option>Dr. Robert</option>

                    </select>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Date</label>

<input
type="date"
name="appointment_date" class="form-control">
                </div>

                <div class="col-md-6 mb-3">

                    <label>Time</label>

<input
type="time"
name="appointment_time" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary">
                Book Appointment
            </button>

        </form>

    </div>

    <!-- Appointment Table -->

    <div id="appointments"
         class="card card-custom p-4 mb-4">

        <h4 class="mb-3">
            Manage Appointments
        </h4>

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>

                </thead>

<tbody>

@foreach($appointments as $appointment)

<tr>

<td>{{ $appointment->id }}</td>

<td>{{ $appointment->patient_name }}</td>

<td>{{ $appointment->doctor_name }}</td>

<td>{{ $appointment->appointment_date }}</td>

<td>{{ $appointment->appointment_time }}</td>

<td>{{ $appointment->status }}</td>

<td>

<form action="/appointments/{{ $appointment->id }}/approve"
      method="POST"
      style="display:inline;">
@csrf
@method('PUT')

<button class="btn btn-success btn-sm">
Approve
</button>

</form>

<form action="/appointments/{{ $appointment->id }}/cancel"
      method="POST"
      style="display:inline;">
@csrf
@method('PUT')

<button class="btn btn-danger btn-sm">
Cancel
</button>

</form>

</td>
</tr>

@endforeach

</tbody>
            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>