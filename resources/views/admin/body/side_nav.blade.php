<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{__('school mangemnets')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{__('school mangemnets')}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                
               <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <p>
                        {{__('Teachers')}}             
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('Adminteacher.index')}}" class="nav-link">
                            <i class="fas fa-plus-circle nav-icon"></i>
                            <p> {{__('Teachers')}}</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="fas fa-clipboard-list"></i>
                  <p>
                      {{__('Students')}}             
                      <i class="fas fa-angle-left right"></i>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{route('Adminstudent.index')}}" class="nav-link">
                          <i class="fas fa-plus-circle nav-icon"></i>
                          <p> {{__('Students')}}</p>
                      </a>
                  </li>
              </ul>
          </li>
         
          
          
    
    
       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>