<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="loginRoleSelect" class="form-select mb-3">
          <option value="client" selected>Client</option>
          <option value="worker">Worker</option>
          <option value="business">Business</option>
        </select>

        <div id="clientLoginForm">@include('client.auth.login')</div>
        <div id="workerLoginForm" style="display:none;">@include('worker.auth.login')</div>
        <div id="businessLoginForm" style="display:none;">@include('business.auth.login')</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="registerRoleSelect" class="form-select mb-3">
          <option value="client" selected>Client</option>
          <option value="worker">Worker</option>
          <option value="business">Business</option>
        </select>

        <div id="clientRegisterForm">@include('client.auth.register')</div>
        <div id="workerRegisterForm" style="display:none;">@include('worker.auth.register')</div>
        <div id="businessRegisterForm" style="display:none;">@include('business.auth.register')</div>
      </div>
    </div>
  </div>
</div>

<script>
    const loginSelect = document.getElementById('loginRoleSelect');
    const clientLogin = document.getElementById('clientLoginForm');
    const workerLogin = document.getElementById('workerLoginForm');
    const businessLogin = document.getElementById('businessLoginForm');

    loginSelect.addEventListener('change', function() {
        clientLogin.style.display = this.value === 'client' ? 'block' : 'none';
        workerLogin.style.display = this.value === 'worker' ? 'block' : 'none';
        businessLogin.style.display = this.value === 'business' ? 'block' : 'none';
    });

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
