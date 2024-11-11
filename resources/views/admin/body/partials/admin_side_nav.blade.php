<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="fas fa-clipboard-list"></i>
                <p>
                    {{__('Dashboard')}}             
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <p> {{__('Dashboard')}}</p>
                    </a>
                </li>
            </ul>
        </li>

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
     
      
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="fas fa-clipboard-list"></i>
            <p>
                {{__('Levels')}}             
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('Adminlevel.index')}}" class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <p> {{__('Levels')}}</p>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="fas fa-clipboard-list"></i>
            <p>
                {{__('Employees')}}             
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('Adminlevel.index')}}" class="nav-link">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <p> {{__('Employees')}}</p>
                </a>
            </li>
        </ul>
    </li>


   
    </ul>
  </nav>