{{-- resources/views/backend/students/edit.blade.php --}}
@extends('admin.index')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Student</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminstudent.index') }}">Students</a></li>
        <li class="breadcrumb-item active">Edit Student</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-edit me-1"></i>
                    Student Information
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('Adminstudent.update', $student->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT') <!-- Include the method spoofing for PUT requests -->

                        <!-- Personal Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Photo Upload -->
                                    <div class="col-md-12 mb-4">
                                        <div class="text-center">
                                            <img id="photoPreview" 
                                                 src="{{ $student->photo ? asset('images/'.$student->photo) : asset('images/default-user.png') }}" 
                                                 class="rounded-circle mb-3" 
                                                 width="150" height="150"
                                                 style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                            <div class="mt-2">
                                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                                <div class="form-text">Maximum file size: 2MB (JPG, PNG)</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                   id="first_name" name="first_name" placeholder="First Name" 
                                                   value="{{ old('first_name', $student->first_name) }}" required>
                                            <label for="first_name">First Name *</label>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                                   id="last_name" name="last_name" placeholder="Last Name" 
                                                   value="{{ old('last_name', $student->last_name) }}">
                                            <label for="last_name">Last Name</label>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('family_name') is-invalid @enderror" 
                                                   id="family_name" name="family_name" placeholder="Family Name" 
                                                   value="{{ old('family_name', $student->family_name) }}">
                                            <label for="family_name">Family Name</label>
                                            @error('family_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('family_name2') is-invalid @enderror" 
                                                   id="family_name2" name="family_name2" placeholder="Second Family Name" 
                                                   value="{{ old('family_name2', $student->family_name2) }}">
                                            <label for="family_name2">Second Family Name</label>
                                            @error('family_name2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                                   id="dob" name="dob" value="{{ old('dob', $student->dob) }}" required>
                                            <label for="dob">Date of Birth *</label>
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('country') is-invalid @enderror" 
                                                    id="country" name="country">
                                                <option value="">Select Country</option>
                                                <option value="USA" {{ old('country', $student->country) == 'USA' ? 'selected' : '' }}>United States</option>
                                                <option value="UK" {{ old('country', $student->country) == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="Canada" {{ old('country', $student->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                            </select>
                                            <label for="country">Country</label>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Contact Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" placeholder="Email" 
                                                   value="{{ old('email', $student->email) }}" required>
                                            <label for="email">Email Address *</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" placeholder="Phone" 
                                                   value="{{ old('phone', $student->phone) }}" required>
                                            <label for="phone">Phone Number *</label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Academic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('level_id') is-invalid @enderror" 
                                                    id="level_id" name="level_id" required>
                                                <option value="">Select Level</option>
                                                @foreach($levels as $level)
                                                    <option value="{{ $level->id }}" 
                                                        {{ old('level_id', $student->level_id) == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="level_id">Academic Level *</label>
                                            @error('level_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Account Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                   id="username" name="username" placeholder="Username" 
                                                   value="{{ old('username', $student->username) }}" required>
                                            <label for="username">Username *</label>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" placeholder="Password">
                                            <label for="password">Password (leave empty to keep current password)</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Student</button>
                            <a href="{{ route('Adminstudent.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('photoPreview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

@endsection
