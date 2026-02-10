<header>

    <!-- Topbar Start -->
    <div class="container-fluid bg-dark p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>123 Street, New York, USA</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+012 345 6789</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center mx-n2">
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-square btn-link rounded-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 shadow-sm">
        <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
            <h2 class="m-0 text-success">Solartec</h2>
        </a>

        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                <a href="{{ url('/about') }}" class="nav-item nav-link">About</a>
                <a href="{{ url('/services') }}" class="nav-item nav-link">Services</a>
                <a href="{{ url('/contact') }}" class="nav-item nav-link">Contact</a>
            </div>

            <div class="d-flex align-items-center pe-lg-4 pe-3">
                <!-- Login / Register Buttons -->
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Login
                </button>

                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Register
                </button>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Role Dropdown -->
        
        <select id="loginRoleSelect" class="form-select mb-3" style="display: none">
          {{-- <option value="client" selected>Client</option>
          <option value="worker">Worker</option>
          <option value="business">Business</option> --}}
        </select>

        <!-- Forms -->
        <div id="clientLoginForm">@include('auth.login')</div>
        <div id="workerLoginForm" style="display:none;">@include('auth.login')</div>
        <div id="businessLoginForm" style="display:none;">@include('auth.login')</div>
      </div>
    </div>
  </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Role Dropdown -->
        <h6>Select your role first!</h6>
        <select id="registerRoleSelect" class="form-select mb-3">
          <option value="client" selected>Client</option>
          <option value="worker">Worker</option>
          <option value="business">Business</option>
        </select>

        <!-- Forms -->
        <div id="clientRegisterForm">@include('client.auth.register')</div>
        <div id="workerRegisterForm" style="display:none;">@include('worker.auth.register')</div>
        <div id="businessRegisterForm" style="display:none;">@include('business.auth.register')</div>
      </div>
    </div>
  </div>
</div>

<!-- JS to toggle forms -->
<script>
  // Login toggle
  const loginSelect = document.getElementById('loginRoleSelect');
  const clientLogin = document.getElementById('clientLoginForm');
  const workerLogin = document.getElementById('workerLoginForm');
  const businessLogin = document.getElementById('businessLoginForm');

  loginSelect.addEventListener('change', function() {
    clientLogin.style.display = this.value === 'client' ? 'block' : 'none';
    workerLogin.style.display = this.value === 'worker' ? 'block' : 'none';
    businessLogin.style.display = this.value === 'business' ? 'block' : 'none';
  });

  // Register toggle
  const registerSelect = document.getElementById('registerRoleSelect');
  const clientRegister = document.getElementById('clientRegisterForm');
  const workerRegister = document.getElementById('workerRegisterForm');
  const businessRegister = document.getElementById('businessRegisterForm');

  registerSelect.addEventListener('change', function() {
    clientRegister.style.display = this.value === 'client' ? 'block' : 'none';
    workerRegister.style.display = this.value === 'worker' ? 'block' : 'none';
    businessRegister.style.display = this.value === 'business' ? 'block' : 'none';
  });
</script>

</header>
