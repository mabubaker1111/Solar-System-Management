<div class="card p-4">
    <h3 class="text-center">Business Login</h3>
    <form action="{{ route('business.login.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-dark w-100">Login</button>
        <p class="text-center mt-2">
            No account? <a href="{{ route('business.register') }}">Register Now</a>
        </p>
    </form>
</div>
