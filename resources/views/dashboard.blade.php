@extends('admin.index')
@section('admin')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div class="col-md-12">
    <div class="card">
        <div class="card-body">

            <h3>Products</h3>

            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Quantity</th>
                            <th>Active</th>
                            <th>Images</th> <!-- New column for displaying images -->
                            <th>Files</th> <!-- New column for displaying files -->
                            <th>Features</th> <!-- New column for displaying features -->
                            <th>Total Price</th> <!-- New column for displaying total price -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Quantity</th>
                            <th>Active</th>
                            <th>Images</th>
                            <th>Files</th>
                            <th>Features</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
        </div>
    </div>
</div>

@endsection
