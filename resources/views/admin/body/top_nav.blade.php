<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="" class="nav-link">Home</a>
    </li>



    






  </ul>

  <!-- SEARCH FORM -->


  
  <ul class="navbar-nav ml-auto"   style="margin-right: 100px;">

    <!-- Messages Dropdown Menu -->

    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-dark">
          @if(session('locale') == 'es')
             Espanish
          @else
              English
          @endif
      </button>
      <button type="button" class="btn btn-sm btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
          <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu" role="menu">
         <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}"> <i class="fas fa-check nav-icon {{ session('locale') != 'es' ? 'visible' : 'invisible' }}"></i> English</a>
          <div class="dropdown-divider"></div>
         <a class="dropdown-item" href="{{ route('lang.switch', 'es') }}">   <i class="fas fa-check nav-icon {{ session('locale') != 'en' ? 'visible' : 'invisible' }}"></i> Espanish</a>
      </div>
  </div>
  
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-dark">
    
        <i class="bx bx-user"></i> {{ Auth::user()->getFullNameAttribute() }}

    
      </button>
      <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu" role="menu">
        <a class="dropdown-item" href="{{ route('profile.view') }}"">
          <i class="fas fa-user-circle nav-icon"></i> profile
      </a>
    <div class="dropdown-divider"></div>
    
    <a class="dropdown-item" href="{{ route('profile.ChangePassword') }}"">
      <i class="fas fa-key nav-icon"></i> change password
  </a>
<div class="dropdown-divider"></div>
 
    @auth
    <a class="dropdown-item" href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       <i class="fas fa-sign-out-alt nav-icon"></i>Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth
</div>
    </div>



  





  </ul>
</nav>


