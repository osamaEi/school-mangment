@extends('admin.index')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>{{__('Create User')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="first_name" class="form-label">{{__('First Name')}}</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter first name" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{__('Email')}}</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">{{__('Phone')}}</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone number" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="age" class="form-label">{{__('Age')}}</label>
                                <input type="number" id="age" name="age" class="form-control" placeholder="Enter age" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">{{__('Role')}}</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="admin">{{__('Admin')}}</option>
                                    <option value="manager">{{__('Manager')}}</option>
                                </select>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{__('Password')}}</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">{{__('Confirm Password')}}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{__('Create User')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
