{{-- resources/views/backend/students/create.blade.php --}}
@extends('admin.index')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{__('Add New Student')}}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">{{__('Dashboard')}}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('Adminstudent.index') }}">{{__('Students')}}</a></li>
        <li class="breadcrumb-item active">{{__('Add New Student')}}</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-plus me-1"></i>
                    {{__('Student Information')}}
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

                    <form method="POST" action="{{ route('Adminstudent.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{__('Personal Information')}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Photo Upload -->
                                    <div class="col-md-12 mb-4">
                                        <div class="text-center">
                                            <img id="photoPreview" 
                                                 src="{{ asset('images/default-user.png') }}" 
                                                 class="rounded-circle mb-3" 
                                                 width="150" height="150"
                                                 style="object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                            <div class="mt-2">
                                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                                <div class="form-text">{{__('Maximum file size: 2MB (JPG, PNG)')}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                   id="first_name" name="first_name" placeholder="First Name" 
                                                   value="{{ old('first_name') }}" required>
                                            <label for="first_name">{{__('First Name')}} *</label>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                                   id="last_name" name="last_name" placeholder="Last Name" 
                                                   value="{{ old('last_name') }}">
                                            <label for="last_name">{{__('Last Name')}}</label>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('family_name') is-invalid @enderror" 
                                                   id="family_name" name="family_name" placeholder="Family Name" 
                                                   value="{{ old('family_name') }}">
                                            <label for="family_name">{{__('Family Name')}}</label>
                                            @error('family_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('family_name2') is-invalid @enderror" 
                                                   id="family_name2" name="family_name2" placeholder="Second Family Name" 
                                                   value="{{ old('family_name2') }}">
                                            <label for="family_name2">{{__('Second Family Name')}}</label>
                                            @error('family_name2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                                   id="dob" name="dob" value="{{ old('dob') }}" required>
                                            <label for="dob">{{__('Date of Birth')}} *</label>
                                            @error('dob')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('country') is-invalid @enderror" 
                                                    id="country" name="country">
                                                <option value="">{{__('Select Country')}}</option>
                                                <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>{{__('United States')}}</option>
                                                <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>{{__('United Kingdom')}}</option>
                                                <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>{{__('Canada')}}</option>
                                            </select>
                                            <label for="country">{{__('Country')}}</label>
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
                                <h6 class="mb-0">{{__('Contact Information')}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" placeholder="Email" 
                                                   value="{{ old('email') }}" required>
                                            <label for="email">{{__('Email Address')}} *</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" placeholder="Phone" 
                                                   value="{{ old('phone') }}" required>
                                            <label for="phone">{{__('Phone Number')}} *</label>
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
                                <h6 class="mb-0">{{__('Academic Information')}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select @error('level_id') is-invalid @enderror" 
                                                    id="level_id" name="level_id" required>
                                                <option value="">{{__('Select Level')}}</option>
                                                @foreach($levels as $level)
                                                    <option value="{{ $level->id }}" 
                                                        {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="level_id">{{__('Academic Level')}} *</label>
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
                                <h6 class="mb-0">{{__('Account Information')}}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" placeholder="Password" required>
                                            <label for="password">{{__('Password')}} *</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" 
                                                   placeholder="Confirm Password" required>
                                            <label for="password_confirmation">{{__('Confirm Password')}} *</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="float-end">
                                    <a href="{{ route('Adminstudent.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i>{{__('Cancel')}}
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="fas fa-save me-1"></i>{{__('Create Student')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Photo preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Phone number formatting
    document.getElementById('phone').addEventListener('input', function (e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });

    // Form validation
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endpush
@endsection