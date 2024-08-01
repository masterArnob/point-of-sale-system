<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
   
    </ul>

  </form>
  <ul class="navbar-nav navbar-right">

    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    
      <div class="d-sm-none d-lg-inline-block">{{Auth::user()->name}}</div></a>
      <div class="dropdown-menu dropdown-menu-right">

        
        <a href="{{route('profile.edit')}}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>

        <div class="dropdown-divider"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
      
          <x-dropdown-link 
              :href="route('logout')"
              onclick="event.preventDefault(); this.closest('form').submit();"
              style="text-decoration: none; color: inherit;">
              {{ __('Log Out') }}
          </x-dropdown-link>
      </form>
      

    
      </div>
    </li>
  </ul>
</nav>