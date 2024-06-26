<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light" style="background-color: #40A2D8;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Example single danger button -->
    <li class="nav-item dropdown">
      <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
        <i class="far fa-user"></i> {{ Auth::user()->name }}
      </a>
      <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
        <li><a href="#" class="dropdown-item">Setting</a></li>
        <li>
          <a href="{{ route('logout') }}" class="dropdown-item"
             onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
            Log Out
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
