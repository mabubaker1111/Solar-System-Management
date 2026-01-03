<form action="{{ route('business.register.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Owner Name</label>
        <input type="text" name="owner_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Business Name</label>
        <input type="text" name="business_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control">
    </div>
    <div class="mb-3">
        <label>City</label>
        <input type="text" name="city" class="form-control">
    </div>
    <div class="mb-3">
        <label>Slots</label>
        <input type="number" name="slots" class="form-control" min="0">
    </div>
    <div class="mb-3">
        <label>Business Image</label>
        <input type="file" name="business_image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary w-100">Register Business</button>
</form>