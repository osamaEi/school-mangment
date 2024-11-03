@extends('admin.index')
@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white p-4">
            <h2 class="mb-0">Personal Information</h2>
            <p class="mb-0 opacity-75">Manage your personal details and account settings</p>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Left Column: Profile Picture -->
                    <div class="col-md-4 text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <div class="profile-picture-container rounded-circle overflow-hidden mb-3" style="width: 200px; height: 200px; border: 3px solid #007bff;">
                                <img src="{{ asset('upload/admin_images/' . ($profileData->photo ?? 'default.png')) }}" 
                                     alt="Profile Picture" 
                                     class="w-100 h-100 object-fit-cover">
                            </div>
                            <label for="photo-upload" class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle p-2">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input id="photo-upload" type="file" name="photo" class="d-none" onchange="previewImage(this)">
                        </div>
                        <p class="text-muted small mt-2">Click the camera icon to update your profile picture</p>
                    </div>

                    <!-- Right Column: User Details -->
                    <div class="col-md-8">
                        <div class="row g-3">
                            <!-- Name Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-primary border-bottom pb-2">Name Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="first_name" class="form-control" id="firstName" value="{{ $profileData->first_name }}" placeholder="First Name">
                                            <label for="firstName">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="last_name" class="form-control" id="lastName" value="{{ $profileData->last_name }}" placeholder="Last Name">
                                            <label for="lastName">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="family_name" class="form-control" id="familyName" value="{{ $profileData->family_name }}" placeholder="Family Name">
                                            <label for="familyName">Family Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="family_name2" class="form-control" id="familyName2" value="{{ $profileData->family_name2 }}" placeholder="Family Name 2">
                                            <label for="familyName2">Family Name 2</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-primary border-bottom pb-2">Contact Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="email" value="{{ $profileData->email }}" placeholder="Email">
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" name="phone" class="form-control" id="phone" value="{{ $profileData->phone }}" placeholder="Phone">
                                            <label for="phone">Phone Number</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Details Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-primary border-bottom pb-2">Personal Details</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="country" class="form-control" id="country" value="{{ $profileData->country }}" placeholder="Country">
                                            <label for="country">Country</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" name="dob" class="form-control" id="dob" value="{{ $profileData->dob }}" placeholder="Date of Birth">
                                            <label for="dob">Date of Birth</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="number" name="age" class="form-control" id="age" value="{{ $profileData->age }}" placeholder="Age">
                                            <label for="age">Age</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="address" class="form-control" id="address" value="{{ $profileData->address }}" placeholder="Address">
                                            <label for="address">Address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4 py-2 ms-2">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<style>
.card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #007bff;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
}

.profile-picture-container {
    transition: all 0.3s ease;
}

.profile-picture-container:hover {
    transform: scale(1.02);
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = input.closest('.position-relative').querySelector('img');
            container.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Add validation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = ['first_name', 'last_name', 'email', 'phone'];
    let isValid = true;
    
    requiredFields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields');
    }
});
</script>
@endsection