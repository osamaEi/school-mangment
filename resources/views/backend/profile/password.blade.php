@extends('admin.index')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- Breadcrumb with modern styling -->
<div class="container-fluid bg-light py-3 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-2 text-primary">{{__('Change Password')}}</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                        
                        </li>
                        <li class="breadcrumb-item active fw-semibold" aria-current="page">
                            {{Auth::user()->first_name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-shadow">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="position-relative">
                            <img src="{{ (!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" 
                                 alt="Admin" 
                                 class="rounded-circle shadow-sm" 
                                 width="150"
                                 style="border: 4px solid #fff; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                            <div class="position-absolute bottom-0 end-0">
                                <span class="badge bg-success rounded-circle p-2">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h4 class="mb-1 fw-bold">{{ $profileData->name }}</h4>
                            <p class="text-muted mb-3">
                                <i class="fas fa-envelope me-2"></i>{{ $profileData->email }}
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    <i class="fas fa-shield-alt me-1"></i>{{__('Security Settings')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Change Form -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    
                    <form action="{{ route('profile.PasswordUpdate') }}" method="post" enctype="multipart/form-data" id="passwordForm">
                        @csrf
                        
                        <!-- Old Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">{{__('Old Password')}}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" 
                                       name="old_password" 
                                       class="form-control form-control-lg @error('old_password') is-invalid @enderror" 
                                       id="old_password"
                                       placeholder="Enter your current password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('old_password')">
                                    <i class="fas fa-eye" id="old_password_icon"></i>
                                </button>
                            </div>
                            @error('old_password')
                                <div class="text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">{{__('New Password')}}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       name="new_password" 
                                       class="form-control form-control-lg @error('new_password') is-invalid @enderror" 
                                       id="new_password"
                                       placeholder="Enter your new password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                            @error('new_password')
                                <div class="text-danger mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <!-- Password strength indicator -->
                            <div class="password-strength mt-2 d-none" id="password-strength">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted mt-1 d-block">{{__('Password strength')}}: <span id="strength-text">Poor</span></small>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">{{__('Confirm New Password')}}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-check-double"></i>
                                </span>
                                <input type="password" 
                                       name="new_password_confirmation" 
                                       class="form-control form-control-lg" 
                                       id="new_password_confirmation"
                                       placeholder="Confirm your new password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-2">
                                <i class="fas fa-save me-2"></i>{{__('Save Changes')}}
                            </button>
                            <button type="reset" class="btn btn-light btn-lg px-5 py-2 ms-2">
                                <i class="fas fa-undo me-2"></i>{{__('Reset')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15)!important;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}

.input-group-text {
    border: none;
}

.form-control {
    border-right: none;
}

.btn-outline-secondary {
    border: 1px solid #ced4da;
    border-left: none;
}

.btn-outline-secondary:hover {
    background-color: transparent;
    color: #0d6efd;
}

.password-strength {
    transition: all 0.3s ease;
}

.progress-bar {
    transition: width 0.3s ease;
}

/* Custom animation for success message */
@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.alert {
    animation: slideIn 0.3s ease forwards;
}
</style>

<script>
// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '_icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Password strength checker
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('password-strength');
    const progressBar = strengthIndicator.querySelector('.progress-bar');
    const strengthText = document.getElementById('strength-text');
    
    strengthIndicator.classList.remove('d-none');
    
    // Calculate strength
    let strength = 0;
    if (password.length >= 8) strength += 25;
    if (password.match(/[a-z]/)) strength += 25;
    if (password.match(/[A-Z]/)) strength += 25;
    if (password.match(/[0-9]/)) strength += 25;
    
    // Update UI
    progressBar.style.width = strength + '%';
    
    // Update color and text based on strength
    if (strength <= 25) {
        progressBar.className = 'progress-bar bg-danger';
        strengthText.textContent = 'Poor';
    } else if (strength <= 50) {
        progressBar.className = 'progress-bar bg-warning';
        strengthText.textContent = 'Fair';
    } else if (strength <= 75) {
        progressBar.className = 'progress-bar bg-info';
        strengthText.textContent = 'Good';
    } else {
        progressBar.className = 'progress-bar bg-success';
        strengthText.textContent = 'Strong';
    }
});

// Form validation
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>
@endsection