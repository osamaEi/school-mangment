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
                    <a href="{{route('student.dashboard')}}" class="nav-link">
                        <i class="fas fa-plus-circle nav-icon"></i>
                        <p> {{__('dashobard')}}</p>
                    </a>
                </li>
            </ul>
        </li>



   
    </ul>
  </nav>