<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register — Hospital Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
  body {
    min-height: 100vh; display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    padding: 30px 16px;
  }
  .register-card {
    background: #fff; border-radius: 20px; width: 100%; max-width: 560px;
    padding: 40px 44px; box-shadow: 0 30px 80px rgba(0,0,0,.35);
  }
  .register-card .logo {
    width: 56px; height: 56px; border-radius: 14px;
    background: linear-gradient(135deg,#1a1aff,#0099ff);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #fff; margin-bottom: 20px;
  }
  .register-card h2 { font-size: 1.6rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
  .register-card p.subtitle { color: #6b7280; font-size: .875rem; margin-bottom: 28px; }

  .form-label { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
  .form-control, .form-select {
    border-radius: 10px; border: 1.5px solid #e5e7eb;
    padding: 10px 14px 10px 40px; font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: #1a1aff; box-shadow: 0 0 0 3px rgba(26,26,255,.1); outline: none;
  }
  .form-control.is-invalid { border-color: #ef4444; }
  .form-select { padding-left: 14px; }

  .input-wrap { position: relative; }
  .input-wrap .bi {
    position: absolute; top: 50%; left: 12px; transform: translateY(-50%);
    color: #9ca3af; font-size: 1rem;
  }

  .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 4px; }
  .role-option { display: none; }
  .role-label {
    border: 2px solid #e5e7eb; border-radius: 12px; padding: 14px 16px;
    cursor: pointer; text-align: center; transition: .2s; background: #f9fafb;
  }
  .role-label:hover { border-color: #1a1aff; }
  .role-option:checked + .role-label {
    border-color: #1a1aff; background: #eff6ff; color: #1a1aff;
  }
  .role-label i { display: block; font-size: 1.6rem; margin-bottom: 4px; }
  .role-label span { font-size: .82rem; font-weight: 600; }

  .btn-register {
    background: linear-gradient(135deg,#1a1aff,#0066cc); color: #fff;
    border: none; border-radius: 12px; padding: 13px; font-weight: 700;
    font-size: .95rem; width: 100%; transition: opacity .2s, transform .15s;
  }
  .btn-register:hover { opacity: .88; transform: translateY(-1px); color: #fff; }

  .section-divider { border: none; border-top: 1.5px solid #f0f0f0; margin: 20px 0; }
</style>
</head>
<body>

<div class="register-card">
  <div class="logo"><i class="bi bi-hospital-fill"></i></div>
  <h2>Create Account</h2>
  <p class="subtitle">Register for the Hospital Management System</p>

  @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4" style="border-left:4px solid #ef4444; font-size:.85rem;">
      <i class="bi bi-exclamation-triangle me-2"></i>
      <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('register') }}" method="POST">
    @csrf

    <!-- Role Selection -->
    <div class="mb-3">
      <label class="form-label">I am registering as <span class="text-danger">*</span></label>
      <div class="role-grid">
        <div>
          <input type="radio" name="role" id="role_patient" value="patient" class="role-option"
                 {{ old('role','patient') === 'patient' ? 'checked' : '' }}>
          <label for="role_patient" class="role-label">
            <i class="bi bi-person-heart"></i>
            <span>Patient</span>
          </label>
        </div>
        <div>
          <input type="radio" name="role" id="role_doctor" value="doctor" class="role-option"
                 {{ old('role') === 'doctor' ? 'checked' : '' }}>
          <label for="role_doctor" class="role-label">
            <i class="bi bi-person-badge"></i>
            <span>Doctor</span>
          </label>
        </div>
      </div>
      @error('role') <div class="text-danger mt-1" style="font-size:.78rem;">{{ $message }}</div> @enderror
    </div>

    <hr class="section-divider">

    <!-- Personal Info -->
    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <div class="input-wrap">
          <i class="bi bi-person"></i>
          <input type="text" name="name" id="reg_name"
                 class="form-control @error('name') is-invalid @enderror"
                 value="{{ old('name') }}" placeholder="John Smith" required>
        </div>
        @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Phone</label>
        <div class="input-wrap">
          <i class="bi bi-phone"></i>
          <input type="text" name="phone" id="reg_phone"
                 class="form-control @error('phone') is-invalid @enderror"
                 value="{{ old('phone') }}" placeholder="+880 17XXXXXXXX">
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Email Address <span class="text-danger">*</span></label>
      <div class="input-wrap">
        <i class="bi bi-envelope"></i>
        <input type="email" name="email" id="reg_email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="your@email.com" required>
      </div>
      @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <label class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-wrap">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" id="reg_pass"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Min. 6 characters" required>
        </div>
        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
        <div class="input-wrap">
          <i class="bi bi-lock-fill"></i>
          <input type="password" name="password_confirmation"
                 class="form-control" placeholder="Repeat password" required>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-register mb-4">
      <i class="bi bi-person-check me-2"></i>Create Account
    </button>

  </form>

  <p class="text-center text-muted" style="font-size:.85rem;">
    Already have an account?
    <a href="{{ route('login') }}" class="text-decoration-none fw-600" style="color:#1a1aff;">
      Sign in here
    </a>
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
