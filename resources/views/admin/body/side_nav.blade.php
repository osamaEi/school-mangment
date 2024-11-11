<aside class="main-sidebar sidebar-dark-primary elevation-4"

@if(auth()->user()->role == 'admin')
style="background-color:  #343a40;"
@elseif(auth()->user()->role == 'teacher')
style="background-color: dark-gray;"
@else
style="background-color:#1c2e51;"

@endif
>
    <!-- Brand Logo -->

    <a  class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light" style="color:white;">{{__('school mangements')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">


          <img src="
          @if(auth()->user()->role == 'admin')
          {{ url('upload/admin_images/'.auth()->user()->photo) }}
          @elseif(auth()->user()->role == 'teacher')
{{auth()->user()->getPhotoUrlteacher()}}
@else
{{auth()->user()->getPhotoUrlstudent()}}

@endif
          
          " class="img-circle elevation-2" alt="User Image">


        </div>
        <div class="info">
          <a  class="d-block">{{auth()->user()->getFullNameAttribute()}}<a>
        </div>
      </div>

      @if(auth()->user()->role == 'admin')
      @include('admin.body.partials.admin_side_nav')
      @elseif(auth()->user()->role == 'teacher')
      @include('admin.body.partials.teacher_side_nav')
      @else
      @include('admin.body.partials.student_side_nav')
      @endif



      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>