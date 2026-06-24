<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Hospital Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }

  body {
    min-height: 100vh; display: flex;
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
  }

  /* Left Panel */
  .left-panel {
    width: 45%; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding: 40px; color: #fff;
  }
  .left-panel .logo {
    width: 72px; height: 72px; border-radius: 20px;
    background: linear-gradient(135deg,#1a1aff,#0099ff);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; margin-bottom: 24px;
    box-shadow: 0 12px 40px rgba(26,26,255,.4);
  }
  .left-panel h1 { font-size: 2.2rem; font-weight: 800; margin-bottom: 12px; text-align: center; }
  .left-panel p { color: rgba(255,255,255,.7); text-align: center; max-width: 320px; line-height: 1.6; }

  .feature-list { list-style: none; margin-top: 32px; }
  .feature-list li {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,.8); margin-bottom: 12px; font-size: .9rem;
  }
  .feature-list li .bi { color: #4ade80; font-size: 1.1rem; }

  /* Right Panel / Form */
  .right-panel {
    flex: 1; background: #fff; display: flex;
    align-items: center; justify-content: center;
    padding: 40px; border-radius: 0 0 0 60px;
    box-shadow: -20px 0 60px rgba(0,0,0,.3);
  }
  .login-box { width: 100%; max-width: 420px; }
  .login-box h2 { font-size: 1.7rem; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
  .login-box p.subtitle { color: #6b7280; font-size: .875rem; margin-bottom: 30px; }

  .form-label { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 6px; }
  .form-control {
    border-radius: 12px; border: 1.5px solid #e5e7eb;
    padding: 12px 16px 12px 44px; font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus {
    border-color: #1a1aff; box-shadow: 0 0 0 3px rgba(26,26,255,.1); outline: none;
  }
  .form-control.is-invalid { border-color: #ef4444; }

  .input-wrap { position: relative; }
  .input-wrap .bi {
    position: absolute; top: 50%; left: 14px; transform: translateY(-50%);
    color: #9ca3af; font-size: 1.05rem;
  }

  .btn-login {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 12px; padding: 13px; font-weight: 700;
    font-size: .95rem; width: 100%; transition: opacity .2s, transform .15s;
  }
  .btn-login:hover { opacity: .88; transform: translateY(-1px); color: #fff; }

  .divider { text-align: center; margin: 18px 0; color: #9ca3af; font-size: .8rem; position: relative; }
  .divider::before, .divider::after {
    content: ''; position: absolute; top: 50%;
    width: 42%; height: 1px; background: #e5e7eb;
  }
  .divider::before { left: 0; }
  .divider::after { right: 0; }

  .quick-access {
    display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-bottom: 20px;
  }
  .quick-btn {
    padding: 10px 6px; border-radius: 10px; border: 1.5px solid #e5e7eb;
    text-align: center; cursor: pointer; font-size: .75rem; font-weight: 600;
    color: #374151; transition: .2s; background: #f9fafb;
  }
  .quick-btn:hover { border-color: #1a1aff; color: #1a1aff; background: #eff6ff; }
  .quick-btn i { display: block; font-size: 1.2rem; margin-bottom: 3px; }

  @media(max-width: 768px) {
    body { flex-direction: column; }
    .left-panel { width: 100%; padding: 30px; }
    .right-panel { border-radius: 30px 30px 0 0; }
  }
</style>
</head>
<body>

<!-- Left Panel -->
<div class="left-panel">
  <div class="logo"><i class="bi bi-hospital-fill"></i></div>
  <h1>Hospital<br>Management</h1>
  <p>A complete system for managing patients, doctors, appointments and departments.</p>

  <ul class="feature-list">
    <li><i class="bi bi-check-circle-fill"></i> Patient Registration & Management</li>
    <li><i class="bi bi-check-circle-fill"></i> Doctor Appointment Booking</li>
    <li><i class="bi bi-check-circle-fill"></i> Department Administration</li>
    <li><i class="bi bi-check-circle-fill"></i> Real-time Status Tracking</li>
  </ul>
</div>

<!-- Right Panel -->
<div class="right-panel">
  <div class="login-box">

    <h2>Welcome Back 👋</h2>
    <p class="subtitle">Sign in to your HMS account to continue</p>

    @if(session('success'))
      <div class="alert alert-success rounded-3 mb-4" style="border-left:4px solid #16a34a; font-size:.85rem;">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger rounded-3 mb-4" style="border-left:4px solid #ef4444; font-size:.85rem;">
        <i class="bi bi-exclamation-triangle me-2"></i>
        @foreach($errors->all() as $error) {{ $error }} @endforeach
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-wrap">
          <i class="bi bi-envelope"></i>
          <input type="email" name="email" id="login_email"
                 class="form-control @error('email') is-invalid @enderror"
                 value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
        </div>
      </div>

      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="input-wrap">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" id="login_password"
                 class="form-control" placeholder="Enter password" required>
        </div>
      </div>

      <button type="submit" class="btn btn-login mb-4">
        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
      </button>
    </form>

    <div class="divider">Quick Demo Access</div>

    <div class="quick-access mb-4">
      <div class="quick-btn" onclick="fillDemo('admin@hms.com','password')">
        <i class="bi bi-shield-check"></i> Admin
      </div>
      <div class="quick-btn" onclick="fillDemo('doctor@hms.com','password')">
        <i class="bi bi-person-badge"></i> Doctor
      </div>
      <div class="quick-btn" onclick="fillDemo('patient@hms.com','password')">
        <i class="bi bi-person-heart"></i> Patient
      </div>
    </div>

    <p class="text-center text-muted" style="font-size:.85rem;">
      Don't have an account?
      <a href="{{ route('register') }}" class="text-decoration-none fw-600" style="color:#1a1aff;">
        Register here
      </a>
    </p>

    <p class="text-center text-muted mt-3" style="font-size:.78rem;">
      Or access directly:
      <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Admin</a> ·
      <a href="{{ route('patients.dashboard') }}" class="text-decoration-none text-muted">Patient</a> ·
      <a href="{{ route('patients.index') }}" class="text-decoration-none text-muted">Patients List</a>
    </p>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fillDemo(email, pass) {
  document.getElementById('login_email').value = email;
  document.getElementById('login_password').value = pass;
}
</script>
</body>
</html>
